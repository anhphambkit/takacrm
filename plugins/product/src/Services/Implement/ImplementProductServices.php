<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 11/7/18
 * Time: 03:32
 */

namespace Plugins\Product\Services\Implement;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Services\CustomAttributeServices;
use Plugins\Product\Models\ProductGallery;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductOriginRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Repositories\Interfaces\ProductUnitRepositories;
use Plugins\Product\Services\ProductServices;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Filesystem\Filesystem as File;


class ImplementProductServices implements ProductServices {

    /**
     * @var ProductRepositories
     */
    private $repository;

    /**
     * @var CustomAttributesRepositories
     */
    private $customAttributesRepositories;

    /**
     * @var CustomAttributeServices
     */
    private $customAttributeServices;

    /**
     * @var file
     */
    private $file;

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
     * ImplementProductServices constructor.
     * @param ProductRepositories $productRepository
     * @param CustomAttributesRepositories $customAttributesRepositories
     * @param CustomAttributeServices $customAttributeServices
     * @param File $file
     * @param ManufacturerRepositories $manufacturerRepositories
     * @param ProductUnitRepositories $productUnitRepositories
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @param ProductOriginRepositories $productOriginRepositories
     */
    public function __construct(ProductRepositories $productRepository,
                                CustomAttributesRepositories $customAttributesRepositories,
                                CustomAttributeServices $customAttributeServices,
                                File $file,
                                ManufacturerRepositories $manufacturerRepositories,
                                ProductUnitRepositories $productUnitRepositories,
                                ProductCategoryRepositories $productCategoryRepositories,
                                ProductOriginRepositories $productOriginRepositories){
        $this->repository = $productRepository;
        $this->customAttributesRepositories = $customAttributesRepositories;
        $this->customAttributeServices = $customAttributeServices;
        $this->file = $file;

        $this->manufacturerRepositories = $manufacturerRepositories;
        $this->productCategoryRepositories = $productCategoryRepositories;
        $this->productOriginRepositories = $productOriginRepositories;
        $this->productUnitRepositories = $productUnitRepositories;
    }

    /**
     * Function render product in page category
     * @param int $categoryId
     * @return mixed
     * @throws \Exception
     */
    public function getAllProductsOfCategoryById(int $categoryId)
    {
        try {
            return $this->repository->getAllProductsByCategory($categoryId);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @param null $productId
     * @return mixed
     */
    public function createOrUpdateProduct(array $data, $productId = null) {
        $isModeCreate = true;
        if ($productId)
            $isModeCreate = false;

        $dataProduct = $this->prepareDataForCreateOrUpdateProduct($data, $isModeCreate);

        $allProductCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT)
            ]
        ], ['stringValueAttributes', 'numberValueAttributes', 'textValueAttributes', 'dateValueAttributes', 'optionValueAttributes']);

        if ($isModeCreate) {
            $product = DB::transaction(function () use ($dataProduct, $allProductCustomAttributes) {
                $product = $this->repository->createOrUpdate($dataProduct);

                foreach ($dataProduct['image_gallery'] as $gallery) {
                    $product->galleries()->create([
                        'media' => $gallery,
                    ]);
                }
                $this->customAttributeServices->createOrUpdateDataEntityCustomAttributes($product, $allProductCustomAttributes, $dataProduct);
                $product->save();
                return $product;
            }, 3);
        }
        else {
            $product = $this->repository->findById($productId);
            if (empty($product)) {
                abort(404);
            }

            $dataProduct = $this->prepareDataForCreateOrUpdateProduct($data, $isModeCreate);

            $product = DB::transaction(function () use ($dataProduct, $product, $allProductCustomAttributes) {
                $product->fill($dataProduct);

                $this->repository->createOrUpdate($product);

                ProductGallery::with('product')->where('product_id', $product->id)->delete();

                foreach ($dataProduct['image_gallery'] as $gallery) {
                    $product->galleries()->create([
                        'media' => $gallery,
                    ]);
                }
                $this->customAttributeServices->createOrUpdateDataEntityCustomAttributes($product, $allProductCustomAttributes, $dataProduct);
                $product->save();
                return $product;
            }, 3);
        }

        return $product;
    }

    /**
     * @param array $data
     * @param bool $isModeCreate
     * @return array|mixed
     */
    public function prepareDataForCreateOrUpdateProduct(array $data, bool $isModeCreate = true) {
        $data['slug'] = str_slug($data['name']);
        $data['is_feature'] = (isset($data['is_feature']) ? $data['is_feature'] : false);
        $data['image_gallery'] = (isset($data['image_gallery']) ? json_decode($data['image_gallery']) : []);
        if ($isModeCreate)
            $data['created_by'] = Auth::id();
        else
            $data['updated_by'] = Auth::id();
        return $data;
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function getInfoPriceProduct(int $productId) {
        return $this->repository->findById($productId, [], ['id', 'slug', 'sku', 'name', 'retail_price', 'discount_percent', 'vat', 'unit_id', 'short_description']);
    }

    /**
     * @return mixed|string
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    public function getTemplateExcel(){
        $allProductCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT)
            ]
        ], ['attributeOptions']);
        $dataColumns = config('plugins-product.product.export_columns');
        if($allProductCustomAttributes)
            foreach ($allProductCustomAttributes as $attribute){
                $dataColumns[$attribute->name] = '';
            }

        $list = collect([
            $dataColumns
        ]);

        $path = public_path().'/download/template/products';
        if(!$this->file->isDirectory($path))
            $this->file->makeDirectory($path, 0755, true);

        $name = time().'-product-template.xlsx';
        (new FastExcel($list))->export($path.'/'.$name);
        return $name;
    }

    /**
     * Get id of product properties by name
     * @param $name
     * @param string $type
     * @return mixed
     */
    public function quickAddProductProperties($name, $type = 'manufacturer'){
        if(empty($name)) return false;
        $repositories = $this->manufacturerRepositories;
        $slug = str_slug($name);
        $dataCreate = ['name' => $name, 'slug'  => $slug, 'created_by' => Auth::id()];
        switch ($type){
            case 'unit':
                $repositories = $this->productUnitRepositories;
                break;
            case 'origin':
                $repositories = $this->productOriginRepositories;
                break;
            case 'category':
                $repositories = $this->productCategoryRepositories;
                $dataCreate['parent_id']  = 0;
                $dataCreate['order']      = 0;
                break;
            default: $repositories = $this->manufacturerRepositories;
                break;
        }
        $data = $repositories->select(['*'], ['slug'  => $slug])->first();
        if(!$data) $data = $repositories->create($dataCreate);
        return $data;
    }

    /** import product from excel */
    public function importProduct($override, $templates){
        DB::beginTransaction();
        try{
            $customAttrs = $this->customAttributeServices->getAllCustomAttributeByConditions([
                [
                    'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT)
                ]
            ], ['attributeOptions']);

            $availableAttrs = $customAttrs->pluck('name')->toArray();
            $mainColumns = config('plugins-product.product.export_columns');

            (new FastExcel)->import($templates[0], function($row) use($override, $mainColumns, $availableAttrs){
                $manufacturer = $this->quickAddProductProperties($row[trans('plugins-product::product.form.manufacturer')], 'manufacturer');
                $unit = $this->quickAddProductProperties($row[trans('plugins-product::product.form.units')], 'unit');
                $origin = $this->quickAddProductProperties($row[trans('plugins-product::product.form.origins')], 'origin');
                $category = $this->quickAddProductProperties($row[trans('plugins-product::product.form.category')], 'category');

                if(!$manufacturer || !$unit || !$origin || !$category) return false;
                $products = [
                    'sku'                       => $row[trans('plugins-product::product.product_code')],
                    'name'                      => $row[trans('plugins-product::product.product_name')],
                    'slug'                      => str_slug($row[trans('plugins-product::product.product_name')]),
                    'short_description'         => $row[trans('plugins-product::product.form.short_description')],
                    'long_desc'                 => $row[trans('plugins-product::product.form.long_desc')],
                    'manufacturer_id'           => $manufacturer->id,
                    'unit_id'                   => $unit->id,
                    'origin_id'                 => $origin->id,
                    'category_id'               => $category->id,
                    'retail_price'              => floatval($row[trans('plugins-product::product.form.retail_price')]),
                    'wholesale_price'           => floatval($row[trans('plugins-product::product.form.wholesale_price')]),
                    'online_price'              => floatval($row[trans('plugins-product::product.form.online_price')]),
                    'purchase_price'            => floatval($row[trans('plugins-product::product.form.purchase_price')]),
                    'discount_percent'          => floatval($row[trans('plugins-product::product.form.discount').'(%)']),
                    'wholesale_discount'        => floatval($row[trans('plugins-product::product.form.wholesale_discount').'(%)']),
                    'purchase_discount'         => floatval($row[trans('plugins-product::product.form.purchase_discount').'(%)']),
                    'online_discount'           => floatval($row[trans('plugins-product::product.form.online_discount').'(%)']),
                    'vat'                       => floatval($row[trans('plugins-product::product.form.vat').'(%)']),
                    'created_by'                => Auth::id()
                ];
                $productOrigin = $this->repository->getModel()->where('sku', $products['sku'])->first();
                if($override && $productOrigin)
                    $products = $productOrigin->fill($products); 
                $product = $this->repository->createOrUpdate($products);

                if(!$product) return false;
                //check row in attrbutes
                //if row in attributes -> detach and add new
                //if row not in attributes -> add attr to product attr -> add product attrs
                //array_walk
                //save()
                // foreach($row as $key => $item){
                //     if(array_key_exists($key, $mainColumns)) continue;
                //     if(in_array($key, $availableAttrs)){
                //         //update product attribute
                //         echo 'available: ';
                //         echo $key;
                //         echo '<br/>';
                //     }else{
                //         //add new attribute and update product attribute
                //         echo 'not available';
                //         echo $key;
                //         echo '<br/>';
                //     }
                // }
                // dd('here');
            });

            DB::commit();
            return true;
        }catch(\Exception $error){
            DB::rollBack();
            dd($error->getMessage());
            return false;
        }


    }

}
