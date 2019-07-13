<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-13
 * Time: 04:56
 */

namespace Plugins\Product\Controllers\Admin;

use AssetManager;
use AssetPipeline;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\DataTables\ProductCategoryDataTable;
use Illuminate\Support\Facades\DB;
use Plugins\Product\Requests\ProductCategoryRequest;

class ProductCategoryController extends BaseAdminController
{
    /**
     * @var ProductCategoryRepositories
     */
    protected $productCategoryRepository;

    /**
     * ProductController constructor.
     * @param ProductCategoryRepositories $productCategoryRepository
     * @author AnhPham
     */
    public function __construct(ProductCategoryRepositories $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * Display all category
     * @param ProductCategoryDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductCategoryDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-product::category.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::category.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $categories = $this->productCategoryRepository->pluck('name', 'id');

        $categories = [ 0 => "Please select parent product category" ] + $categories;

        page_title()->setTitle(trans('plugins-product::category.create'));

        $this->addDetailAssets();

        return view('plugins-product::category.create', compact('categories'));
    }

    /**
     * @param ProductCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductCategoryRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $category= $this->productCategoryRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $category);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.category.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.category.edit', $category>id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $categories = DB::table('product_categories')->whereNotIn('id', function ($query) use ($id) {
            $query->select('id')->where('parent_id', $id);
        })->pluck('name', 'id');

        $infoCategory = $this->productCategoryRepository->findById($id);

        if (empty($infoCategory)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::category.edit') . ' #' . $id);

        return view('plugins-product::category.edit', compact('infoCategory', 'categories'));
    }

    /**
     * @param $id
     * @param ProductCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductCategoryRequest $request)
    {
        $category= $this->productCategoryRepository->findById($id);
        if (empty($category)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $category->fill($data);

        $this->productCategoryRepository->createOrUpdate($category);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $category);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.category.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.category.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $category= $this->productCategoryRepository->findById($id);
            if (empty($category)) {
                abort(404);
            }
            $this->productCategoryRepository->delete($category);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $category);

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
