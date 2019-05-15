<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-11
 * Time: 16:32
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Plugins\Product\DataTables\ProductBusinessTypeDataTable;
use Plugins\Product\Models\ProductBusinessType;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use AssetManager;
use AssetPipeline;

class ProductBusinessTypeController extends BaseAdminController
{
    /**
     * @var BusinessTypeRepositories
     */
    protected $businessTypeRepository;

    /**
     * ProductController constructor.
     * @param BusinessTypeRepositories $businessTypeRepository
     * @author AnhPham
     */
    public function __construct(BusinessTypeRepositories $businessTypeRepository)
    {
        $this->businessTypeRepository = $businessTypeRepository;
    }

    /**
     * Display all business-type
     * @param ProductBusinessTypeDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductBusinessTypeDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-product::business-type.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::business-type.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $businessTypes = $this->businessTypeRepository->pluck('name', 'id');

        $businessTypes = array_merge([ 0 => "Please select parent business type" ], $businessTypes);

        page_title()->setTitle(trans('plugins-product::business-type.create'));

        $this->addDetailAssets();

        return view('plugins-product::business-type.create', compact('businessTypes'));
    }

    /**
     * Insert new Product into database
     *
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postCreate(Request $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);

        $business_type = $this->businessTypeRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $business_type);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.business-type.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.business-type.edit', $business_type->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $businessTypes = DB::table('product_business_types')->whereNotIn('id', function ($query) use ($id) {
            $query->select('id')->where('parent_id', $id);
        })->pluck('name', 'id');

        $infoBusinessType = $this->businessTypeRepository->findById($id);
        
        if (empty($infoBusinessType)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::business-type.edit') . ' #' . $id);

        return view('plugins-product::business-type.edit', compact('infoBusinessType', 'businessTypes'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postEdit($id, Request $request)
    {
        $business_type = $this->businessTypeRepository->findById($id);
        if (empty($business_type)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);

        $business_type->fill($data);

        $this->businessTypeRepository->createOrUpdate($business_type);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $business_type);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.business-type.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.business-type.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $business_type = $this->businessTypeRepository->findById($id);
            if (empty($business_type)) {
                abort(404);
            }
            $this->businessTypeRepository->delete($business_type);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $business_type);

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
        AssetManager::addAsset('form-select2-js', 'backend/plugins/product/assets/scripts/form-select2.scripts.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('form-select2-js');
    }
}