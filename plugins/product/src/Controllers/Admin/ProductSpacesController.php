<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-26
 * Time: 23:01
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductSpaceDataTable;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;
use Plugins\Product\Requests\ProductSpaceRequest;
use AssetManager;
use AssetPipeline;
use Illuminate\Support\Facades\DB;

class ProductSpacesController extends BaseAdminController
{
    /**
     * @var ProductSpaceRepositories
     */
    protected $productSpaceRepository;

    /**
     * @var BusinessTypeRepositories
     */
    protected $businessTypeRepositories;

    /**
     * ProductSpacesController constructor.
     * @param ProductSpaceRepositories $productSpaceRepository
     * @param BusinessTypeRepositories $businessTypeRepositories
     */
    public function __construct(ProductSpaceRepositories $productSpaceRepository, BusinessTypeRepositories $businessTypeRepositories)
    {
        $this->productSpaceRepository = $productSpaceRepository;
        $this->businessTypeRepositories = $businessTypeRepositories;
    }

    /**
     * Display all space
     * @param ProductSpaceDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductSpaceDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::space.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::space.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');
        page_title()->setTitle(trans('plugins-product::space.create'));
        $this->addDetailAssets();
        return view('plugins-product::space.create', compact('businessTypes'));
    }

    /**
     * @param ProductSpaceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductSpaceRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $space = DB::transaction(function () use ($data, $request) {
            $space = $this->productSpaceRepository->createOrUpdate($data);

            $businessTypeIds = $request->input('business_type_id', []);
            $space->spaceBusinessTypes()->attach($businessTypeIds);

            return $space->save();
        }, 3);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $space);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.space.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.space.edit', $space->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $space = $this->productSpaceRepository->findById($id);
        if (empty($space)) {
            abort(404);
        }

        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');

        $selectedSpaceBusinessTypes = [];
        if ($space->spaceBusinessTypes != null) {
            $selectedSpaceBusinessTypes = $space->spaceBusinessTypes->pluck('id')->all();
        }

        $this->addDetailAssets();

        page_title()->setTitle(trans('plugins-product::space.edit') . ' #' . $id);

        return view('plugins-product::space.edit', compact('space', 'selectedSpaceBusinessTypes', 'businessTypes'));
    }

    /**
     * @param $id
     * @param ProductSpaceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductSpaceRequest $request)
    {
        $space = $this->productSpaceRepository->findById($id);
        if (empty($space)) {
            abort(404);
        }

        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $space = DB::transaction(function () use ($data, $space, $request) {
            $space->fill($data);
            $this->productSpaceRepository->createOrUpdate($space);

            $businessTypeIds = $request->input('business_type_id', []);
            $space->spaceBusinessTypes()->detach();
            $space->spaceBusinessTypes()->attach($businessTypeIds);

            return $space;
        }, 3);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $space);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.space.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.space.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $space = $this->productSpaceRepository->findById($id);
            if (empty($space)) {
                abort(404);
            }
            $this->productSpaceRepository->delete($space);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $space);

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
        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('form-select2-js', 'backend/plugins/product/assets/scripts/form-select2.min.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('form-select2-js');
    }
}