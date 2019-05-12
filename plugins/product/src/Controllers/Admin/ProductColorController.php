<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-09
 * Time: 00:30
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductColorDataTable;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Requests\ProductColorRequest;

class ProductColorController extends BaseAdminController
{
    /**
     * @var ProductColorRepositories
     */
    protected $productColorRepository;

    /**
     * ProductController constructor.
     * @param ProductColorRepositories $productColorRepository
     * @author AnhPham
     */
    public function __construct(ProductColorRepositories $productColorRepository)
    {
        $this->productColorRepository = $productColorRepository;
        parent::__construct();
    }

    /**
     * Display all color
     * @param ProductColorDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductColorDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::color.list'));
        $this->addManageAssets();
        return $dataTable->renderTable(['title' => trans('plugins-product::color.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::color.create'));
        $this->addDetailAssets();
        return view('plugins-product::color.create');
    }

    /**
     * @param ProductColorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductColorRequest $request)
    {
        $data = $request->input();

        $data['created_by'] = Auth::id();

        $color = $this->productColorRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.color.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.color.edit', $color->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $color = $this->productColorRepository->findById($id);
        if (empty($color)) {
            abort(404);
        }
        page_title()->setTitle(trans('plugins-product::color.edit') . ' #' . $id);
        $this->addDetailAssets();
        return view('plugins-product::color.edit', compact('color'));
    }

    /**
     * @param $id
     * @param ProductColorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductColorRequest $request)
    {
        $color = $this->productColorRepository->findById($id);
        if (empty($color)) {
            abort(404);
        }
        $color->fill(array($request->input(), ['updated_by' => Auth::id()]));

        $this->productColorRepository->createOrUpdate($color);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.color.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.color.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $color = $this->productColorRepository->findById($id);
            if (empty($color)) {
                abort(404);
            }
            $this->productColorRepository->delete($color);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

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
        AssetManager::addAsset('product-color-css', 'backend/plugins/product/assets/css/product-color.css');
        AssetManager::addAsset('mini-colors-css', 'libs/plugins/product/css/miniColors/jquery.minicolors.css');
        AssetManager::addAsset('mini-colors-js', 'libs/plugins/product/js/miniColors/jquery.minicolors.min.js');
        AssetManager::addAsset('spectrum-js', 'libs/plugins/product/js/spectrum/spectrum.js');
        AssetManager::addAsset('picker-color-js', 'backend/plugins/product/assets/scripts/picker-color.min.js');

        AssetPipeline::requireCss('mini-colors-css');
        AssetPipeline::requireCss('product-color-css');
        AssetPipeline::requireJs('mini-colors-js');
        AssetPipeline::requireJs('spectrum-js');
        AssetPipeline::requireJs('picker-color-js');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addManageAssets()
    {
        AssetManager::addAsset('product-color-css', 'backend/plugins/product/assets/css/product-color.css');

        AssetPipeline::requireCss('product-color-css');
    }
}