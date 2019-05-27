<?php

namespace Plugins\Product\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\Product\Models\ProductGallery;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductOriginRepositories;
use Plugins\Product\Repositories\Interfaces\ProductUnitRepositories;
use Plugins\Product\Requests\ProductRequest;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\DataTables\ProductDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;

class ProductController extends BaseAdminController
{
    /**
     * @var ProductRepositories
     */
    protected $productRepository;

    /**
     * @var ProductCategoryRepositories
     */
    protected $productCategoryRepositories;

    /**
     * @var ManufacturerRepositories
     */
    protected $manufacturerRepositories;

    /**
     * @var ProductUnitRepositories
     */
    protected $productUnitRepositories;

    /**
     * @var ProductOriginRepositories
     */
    protected $productOriginRepositories;

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @param ManufacturerRepositories $manufacturerRepositories
     * @param ProductUnitRepositories $productUnitRepositories
     * @param ProductOriginRepositories $productOriginRepositories
     */
    public function __construct(ProductRepositories $productRepository, ProductCategoryRepositories $productCategoryRepositories,
                                ManufacturerRepositories $manufacturerRepositories, ProductUnitRepositories $productUnitRepositories,
                                ProductOriginRepositories $productOriginRepositories
    )
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepositories = $productCategoryRepositories;
        $this->manufacturerRepositories = $manufacturerRepositories;
        $this->productUnitRepositories = $productUnitRepositories;
        $this->productOriginRepositories = $productOriginRepositories;
    }

    /**
     * Display all product
     * @param ProductDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::product.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::product.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $categories = $this->productCategoryRepositories->pluck('name', 'id');
        $categories = [ 0 => "Please select a product category" ] + $categories;

        $manufacturer = $this->manufacturerRepositories->pluck('name', 'id');
        $manufacturer = [ 0 => "Please select a manufacturer" ] + $manufacturer;

        $units = $this->productUnitRepositories->pluck('name', 'id');
        $units = [ 0 => "Please select a unit" ] + $units;

        $origins = $this->productOriginRepositories->pluck('name', 'id');
        $origins = [ 0 => "Please select a product origin" ] + $origins;

        page_title()->setTitle(trans('plugins-product::product.create'));

        $this->addDetailAssets();

        return view('plugins-product::product.create', compact('categories', 'manufacturer', 'units', 'origins'));
    }

    /**
     * Insert new Product into database
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postCreate(ProductRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();
        $data['is_feature'] = (isset($data['is_feature']) ? $data['is_feature'] : false);

        $product = DB::transaction(function () use ($data, $request) {
            $product = $this->productRepository->createOrUpdate($data);

            $galleries = json_decode($request->input('image_gallery', "[]"));

            foreach ($galleries as $gallery) {
                $product->galleries()->create([
                    'media' => $gallery,
                ]);
            }

            return $product->save();
        }, 3);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $product);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.edit', $product->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $categories = [ 0 => "Please select a product category" ] + $categories;

        $manufacturer = $this->manufacturerRepositories->pluck('name', 'id');
        $manufacturer = [ 0 => "Please select a manufacturer" ] + $manufacturer;

        $units = $this->productUnitRepositories->pluck('name', 'id');
        $units = [ 0 => "Please select a unit" ] + $units;

        $origins = $this->productOriginRepositories->pluck('name', 'id');
        $origins = [ 0 => "Please select a product origin" ] + $origins;

        $product = $this->productRepository->findById($id);

        $galleries = [];
        if ($product->galleries != null) {
            $galleries = $product->galleries->pluck('media')->all();
        }

        if (empty($product)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::product.edit') . ' #' . $id);

        $this->addDetailAssets();

        return view('plugins-product::product.edit', compact('product', 'categories', 'manufacturer', 'galleries', 'units', 'origins'));
    }

    /**
     * @param $id
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postEdit($id, ProductRequest $request)
    {
        $product = $this->productRepository->findById($id);
        if (empty($product)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['is_feature'] = (isset($data['is_feature']) ? $data['is_feature'] : false);
        $data['updated_by'] = Auth::id();

        $product = DB::transaction(function () use ($data, $product, $request) {
            $product->fill($data);

            $this->productRepository->createOrUpdate($product);

            $galleries = json_decode($request->input('image_gallery', "[]"));

            ProductGallery::with('product')->where('product_id', $product->id)->delete();

            foreach ($galleries as $gallery) {
                $product->galleries()->create([
                    'media' => $gallery,
                ]);
            }

            return $product;
        }, 3);


        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $product);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $product = $this->productRepository->findById($id);
            if (empty($product)) {
                abort(404);
            }
            $this->productRepository->delete($product);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $product);

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
     * @param $productId
     * @return mixed
     * @author Tu Nguyen
     */
    public function getDetail($id){
        page_title()->setTitle(trans('plugins-product::product.detail') . ' #' . $id);
        $product = $this->productRepository->findById($id);

        $galleries = [];
        if ($product->galleries != null)
            $galleries = $product->galleries->pluck('media')->all();

        if (empty($product))
            abort(404);

        $this->addDetailAssets();
        return view('plugins-product::product.detail', compact('product', 'galleries'));
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/plugins/product/css/select2/select2.min.css');
        AssetManager::addAsset('bootstrap-switch-css', 'libs/plugins/product/css/toggle/bootstrap-switch.min.css');
        AssetManager::addAsset('switchery-css', 'libs/plugins/product/css/toggle/switchery.min.css');
        AssetManager::addAsset('admin-gallery-css', 'libs/core/base/css/gallery/admin-gallery.css');
        AssetManager::addAsset('product-css', 'backend/plugins/product/assets/css/product.css');

        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('bootstrap-switch-js', 'libs/plugins/product/js/toggle/bootstrap-switch.min.js');
        AssetManager::addAsset('bootstrap-checkbox-js', 'libs/plugins/product/js/toggle/bootstrap-checkbox.min.js');
        AssetManager::addAsset('switchery-js', 'libs/plugins/product/js/toggle/switchery.min.js');
        AssetManager::addAsset('form-select2-js', 'backend/plugins/product/assets/scripts/form-select2.min.js');
        AssetManager::addAsset('switch-js', 'backend/plugins/product/assets/scripts/switch.min.js');

        AssetManager::addAsset('product-detail', 'plugins/product/app-assets/backend/ecommerce-shop.min.css');

        AssetManager::addAsset('product-detail-slider-js', 'plugins/product/app-assets/backend/slick/slick.js');
        AssetManager::addAsset('product-detail-slider-css', 'plugins/product/app-assets/backend/slick/slick.css');
        AssetManager::addAsset('product-detail-slider-theme-css', 'plugins/product/app-assets/backend/slick/slick-theme.css');
        AssetManager::addAsset('product-js', 'backend/plugins/product/assets/scripts/product.js');


        AssetPipeline::requireCss('product-detail');
        AssetPipeline::requireJs('product-detail-slider-js');
        AssetPipeline::requireCss('product-detail-slider-css');
        AssetPipeline::requireCss('product-detail-slider-theme-css');
        AssetPipeline::requireJs('product-js');


        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('bootstrap-switch-css');
        AssetPipeline::requireCss('switchery-css');
        AssetPipeline::requireCss('admin-gallery-css');
        AssetPipeline::requireCss('product-css');

        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('bootstrap-switch-js');
        AssetPipeline::requireJs('bootstrap-checkbox-js');
        AssetPipeline::requireJs('switchery-js');
        AssetPipeline::requireJs('form-select2-js');
        AssetPipeline::requireJs('switch-js');

        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');
    }
}
