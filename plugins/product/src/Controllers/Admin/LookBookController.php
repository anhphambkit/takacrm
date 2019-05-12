<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 08:58
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Setting\Services\ReferenceServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\DataTables\LookBookDataTable;
use Plugins\Product\Models\LookBookBusinessTypeSpaceRelation;
use Plugins\Product\Models\LookBookTag;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use AssetManager;
use AssetPipeline;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;
use Plugins\Product\Requests\LookBookRequest;

class LookBookController extends BaseAdminController
{
    /**
     * @var LookBookRepositories
     */
    protected $lookBookRepository;

    /**
     * @var ProductCategoryRepositories
     */
    protected $productCategoryRepositories;

    /**
     * @var BusinessTypeRepositories
     */
    protected $businessTypeRepositories;

    /**
     * @var ProductSpaceRepositories
     */
    protected $productSpaceRepositories;

    /**
     * @var ReferenceServices
     */
    protected $referenceServices;

    /**
     * LookBookController constructor.
     * @param LookBookRepositories $lookBookRepository
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @param BusinessTypeRepositories $businessTypeRepositories
     * @param ProductSpaceRepositories $productSpaceRepositories
     * @param ReferenceServices $referenceServices
     */
    public function __construct(LookBookRepositories $lookBookRepository, ProductCategoryRepositories $productCategoryRepositories,
                                BusinessTypeRepositories $businessTypeRepositories, ProductSpaceRepositories $productSpaceRepositories,
                                ReferenceServices $referenceServices
                                )
    {
        $this->lookBookRepository = $lookBookRepository;
        $this->productCategoryRepositories = $productCategoryRepositories;
        $this->businessTypeRepositories = $businessTypeRepositories;
        $this->productSpaceRepositories = $productSpaceRepositories;
        $this->referenceServices = $referenceServices;
    }

    /**
     * Display all look_book
     * @param LookBookDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(LookBookDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::look-book.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::look-book.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $categories = $this->productCategoryRepositories->pluck('name', 'id');
        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');
        $spaces = $this->productSpaceRepositories->select(['id', 'name as text', 'image_feature'])->get();
        $products = [];
        $tags = [];
        $typeLayouts = $this->referenceServices->getReferenceFromAttributeType(ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT)
            ->pluck('value', 'value')
            ->toArray();

        page_title()->setTitle(trans('plugins-product::look-book.create'));

        $this->addDetailAssets();

        return view('plugins-product::look-book.create', compact('categories', 'products','tags', 'businessTypes', 'spaces', 'typeLayouts'));
    }

    /**
     * @param LookBookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(LookBookRequest $request)
    {
        $data = $request->input();

        $data['created_by'] = Auth::id();
        $data['is_main'] = (isset($data['is_main']) ? $data['is_main'] : false);

        $lookBook = DB::transaction(function () use ($data, $request) {
            $lookBook = $this->lookBookRepository->createOrUpdate($data);

            $lookBookTags = $data['tag'];
            $lookBook->lookBookTags()->createMany($lookBookTags);

            $lookBookSpaces = (isset($data['space_business']) ? $data['space_business'] : []);
            $lookBook->lookBookSpaces()->createMany($lookBookSpaces);

            $lookBookAllSpaces = (isset($data['all_space']) ? $data['all_space'] : []);
            foreach ($lookBookAllSpaces as $lookBookAllSpace) {
                $lookBook->lookBookSpaces()->create([
                    'business_type_id' => 0,
                    'space_id' => $lookBookAllSpace['space_id'],
                    'apply_all' => true
                ]);
            }

            return $lookBook->save();
        }, 3);


        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $lookBook);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.look_book.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.look_book.edit', $lookBook->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getEdit($id)
    {
        $categories = $this->productCategoryRepositories->pluck('name', 'id');
        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');
        $spaces = $this->productSpaceRepositories->select(['id', 'name as text', 'image_feature'])->get();
        $typeLayouts = $this->referenceServices->getReferenceFromAttributeType(ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT)
            ->pluck('value', 'value')
            ->toArray();
        $products = [];

        $lookBook = $this->lookBookRepository->findById($id);

        $lookBookTags = [];
        $maxIndex = 0;
        if ($lookBook->lookBookTags() != null) {
            $lookBookTags = $lookBook->lookBookTags()->select('*', 'id as index')->get()->toArray();
            $maxIndex = LookBookTag::max('id') + 1;
        }

        $businessSpaces = [];
        $allSpaces = [];
        if ($lookBook->lookBookSpaces() != null) {
            $businessSpaces = $lookBook->lookBookSpaces()->where('look_book_business_type_space_relation.apply_all', false)->select('*')->get()->toArray();
            $allSpaces = $lookBook->lookBookSpaces()->where('look_book_business_type_space_relation.apply_all', true)->select('*')->get()->toArray();
        }

        if (empty($lookBook)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::look-book.edit') . ' #' . $id);

        $this->addDetailAssets();

        return view('plugins-product::look-book.edit',
            compact('products', 'categories', 'lookBook', 'lookBookTags',
                'maxIndex', 'businessTypes', 'spaces', 'businessSpaces', 'allSpaces', 'typeLayouts'));
    }

    /**
     * @param $id
     * @param LookBookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, LookBookRequest $request)
    {
        $lookBook = $this->lookBookRepository->findById($id);
        if (empty($lookBook)) {
            abort(404);
        }

        $data = $request->all();

        $data['updated_by'] = Auth::id();
        $data['is_main'] = (isset($data['is_main']) ? $data['is_main'] : false);

        $lookBook = DB::transaction(function () use ($data, $lookBook) {
            $lookBook->fill($data);

            $this->lookBookRepository->createOrUpdate($lookBook);

            LookBookTag::with('lookBook')->where('look_book_id', $lookBook->id)->delete();
            $lookBookTags = $data['tag'];
            $lookBook->lookBookTags()->createMany($lookBookTags);

            LookBookBusinessTypeSpaceRelation::with('lookBook')->where('look_book_id', $lookBook->id)->delete();
            $lookBookSpaces = (isset($data['space_business']) ? $data['space_business'] : []);
            $lookBook->lookBookSpaces()->createMany($lookBookSpaces);
            $lookBookAllSpaces = (isset($data['all_space']) ? $data['all_space'] : []);
            foreach ($lookBookAllSpaces as $lookBookAllSpace) {
                $lookBook->lookBookSpaces()->create([
                    'business_type_id' => 0,
                    'space_id' => $lookBookAllSpace['space_id'],
                    'apply_all' => true
                ]);
            }

            return $lookBook->save();
        }, 3);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $lookBook);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.look_book.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.look_book.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author AnhPham
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $lookBook = $this->lookBookRepository->findById($id);
            if (empty($lookBook)) {
                abort(404);
            }
            $this->lookBookRepository->delete($lookBook);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $lookBook);

            return [
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ];
        }
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/plugins/product/css/select2/select2.min.css');
        AssetManager::addAsset('look-book-component-css', 'backend/core/base/assets/css/look-book-component.css');
        AssetManager::addAsset('look-book-css', 'backend/plugins/product/assets/css/look-book.css');

        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('cropper-js', '//cdnjs.cloudflare.com/ajax/libs/cropper/0.7.9/cropper.min.js');
        AssetManager::addAsset('look-book-js', 'backend/plugins/product/assets/js/look-book.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('look-book-component-css');
        AssetPipeline::requireCss('look-book-css');

        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('cropper-js');
        AssetPipeline::requireJs('look-book-js');

        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');
    }
}