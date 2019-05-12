<?php

namespace Plugins\Product\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\Product\Models\ProductGallery;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
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
     * @var ProductColorRepositories
     */
    protected $productColorRepositories;

    /**
     * @var BusinessTypeRepositories
     */
    protected $businessTypeRepositories;

    /**
     * @var ProductCollectionRepositories
     */
    protected $productCollectionRepositories;

    /**
     * @var ProductMaterialRepositories
     */
    protected $productMaterialRepositories;

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @param ManufacturerRepositories $manufacturerRepositories
     * @param ProductColorRepositories $productColorRepositories
     * @param BusinessTypeRepositories $businessTypeRepositories
     * @param ProductCollectionRepositories $productCollectionRepositories
     * @param ProductMaterialRepositories $productMaterialRepositories
     */
    public function __construct(ProductRepositories $productRepository, ProductCategoryRepositories $productCategoryRepositories,
                                ManufacturerRepositories $manufacturerRepositories, ProductColorRepositories $productColorRepositories,
                                BusinessTypeRepositories $businessTypeRepositories, ProductCollectionRepositories $productCollectionRepositories,
                                ProductMaterialRepositories $productMaterialRepositories)
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepositories = $productCategoryRepositories;
        $this->manufacturerRepositories = $manufacturerRepositories;
        $this->productColorRepositories = $productColorRepositories;
        $this->businessTypeRepositories = $businessTypeRepositories;
        $this->productCollectionRepositories = $productCollectionRepositories;
        $this->productMaterialRepositories = $productMaterialRepositories;
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

        $manufacturer = $this->manufacturerRepositories->pluck('name', 'id');

        $colors = $this->productColorRepositories->pluck('name', 'id');

        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');

        $collections = $this->productCollectionRepositories->pluck('name', 'id');

        $materials = $this->productMaterialRepositories->pluck('name', 'id');

        page_title()->setTitle(trans('plugins-product::product.create'));

        $this->addDetailAssets();

        return view('plugins-product::product.create', compact('categories', 'manufacturer', 'colors', 'businessTypes', 'collections', 'materials'));
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
        $data['is_best_seller'] = $request->input('is_best_seller', false);
        $data['available_3d'] = $request->input('available_3d', false);
        $data['has_assembly'] = $request->input('has_assembly', false);
        $data['is_outdoor'] = $request->input('is_outdoor', false);
        $data['sku'] = "{$data['manufacturer_id']}{$data['sku']}";
        $data['created_by'] = Auth::id();

        $product = DB::transaction(function () use ($data, $request) {
            $product = $this->productRepository->createOrUpdate($data);

            $galleries = json_decode($request->input('image_gallery', "[]"));

            foreach ($galleries as $gallery) {
                $product->galleries()->create([
                    'media' => $gallery,
//                    'description' => $gallery->description,
                ]);
            }

            $categoryIds = $request->input('category_id', []);
            $product->productCategories()->attach($categoryIds);

            $businessTypeIds = $request->input('business_type_id', []);
            $product->productBusinessTypes()->attach($businessTypeIds);

            $collectionIds = $request->input('collection_id', []);
            $product->productCollections()->attach($collectionIds);

            $colorIds = $request->input('color_id', []);
            $product->productColors()->attach($colorIds);

            $materialIds = $request->input('material_id', []);
            $product->productMaterials()->attach($materialIds);

            $product->sku .= $product->id;

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

        $manufacturer = $this->manufacturerRepositories->pluck('name', 'id');

        $colors = $this->productColorRepositories->pluck('name', 'id');

        $businessTypes = $this->businessTypeRepositories->pluck('name', 'id');

        $collections = $this->productCollectionRepositories->pluck('name', 'id');

        $materials = $this->productMaterialRepositories->pluck('name', 'id');

        $product = $this->productRepository->findById($id);

        $selectedProductCategories = [];
        if ($product->productCategories != null) {
            $selectedProductCategories = $product->productCategories->pluck('id')->all();
        }

        $selectedProductBusinessTypes = [];
        if ($product->productBusinessTypes != null) {
            $selectedProductBusinessTypes = $product->productBusinessTypes->pluck('id')->all();
        }

        $selectedProductCollections = [];
        if ($product->productCollections != null) {
            $selectedProductCollections = $product->productCollections->pluck('id')->all();
        }

        $selectedProductColors = [];
        if ($product->productColors != null) {
            $selectedProductColors = $product->productColors->pluck('id')->all();
        }

        $selectedProductMaterials = [];
        if ($product->productMaterials != null) {
            $selectedProductMaterials = $product->productMaterials->pluck('id')->all();
        }

        $galleries = [];
        if ($product->galleries != null) {
            $galleries = $product->galleries->pluck('media')->all();
        }

        if (empty($product)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::product.edit') . ' #' . $id);

        $this->addDetailAssets();

        return view('plugins-product::product.edit', compact('product', 'categories', 'manufacturer', 'colors',
                    'businessTypes', 'collections', 'materials', 'selectedProductCategories', 'selectedProductBusinessTypes',
                    'selectedProductCollections', 'selectedProductColors', 'selectedProductMaterials', 'galleries'));
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
        $data['is_best_seller'] = $request->input('is_best_seller', false);
        $data['available_3d'] = $request->input('available_3d', false);
        $data['has_assembly'] = $request->input('has_assembly', false);
        $data['is_outdoor'] = $request->input('is_outdoor', false);
        $data['sku'] = "{$data['manufacturer_id']}{$data['sku']}{$id}";
        $data['updated_by'] = Auth::id();

        $product = DB::transaction(function () use ($data, $product, $request) {
            $product->fill($data);

            $this->productRepository->createOrUpdate($product);

            $galleries = json_decode($request->input('image_gallery', "[]"));

            ProductGallery::with('product')->where('product_id', $product->id)->delete();

            foreach ($galleries as $gallery) {
                $product->galleries()->create([
                    'media' => $gallery,
//                    'description' => $gallery->description,
                ]);
            }

            $categoryIds = $request->input('category_id', []);
            $product->productCategories()->detach();
            $product->productCategories()->attach($categoryIds);

            $businessTypeIds = $request->input('business_type_id', []);
            $product->productBusinessTypes()->detach();
            $product->productBusinessTypes()->attach($businessTypeIds);

            $collectionIds = $request->input('collection_id', []);
            $product->productCollections()->detach();
            $product->productCollections()->attach($collectionIds);

            $colorIds = $request->input('color_id', []);
            $product->productColors()->detach();
            $product->productColors()->attach($colorIds);

            $materialIds = $request->input('material_id', []);
            $product->productMaterials()->detach();
            $product->productMaterials()->attach($materialIds);

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
    }
}
