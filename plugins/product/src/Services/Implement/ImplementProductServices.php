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
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Services\ProductServices;

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
     * ImplementProductServices constructor.
     * @param ProductRepositories $productRepository
     * @param CustomAttributesRepositories $customAttributesRepositories
     * @param CustomAttributeServices $customAttributeServices
     */
    public function __construct(ProductRepositories $productRepository, CustomAttributesRepositories $customAttributesRepositories, CustomAttributeServices $customAttributeServices)
    {
        $this->repository = $productRepository;
        $this->customAttributesRepositories = $customAttributesRepositories;
        $this->customAttributeServices = $customAttributeServices;
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
}