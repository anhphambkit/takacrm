<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 11/7/18
 * Time: 03:32
 */

namespace Plugins\Product\Services;

interface ProductServices {
    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getAllProductsOfCategoryById(int $categoryId);

    /**
     * @param array $data
     * @param null $productId
     * @return mixed
     */
    public function createOrUpdateProduct(array $data, $productId = null);

    /**
     * @param array $data
     * @param bool $isModeCreate
     * @return mixed
     */
    public function prepareDataForCreateOrUpdateProduct(array $data, bool $isModeCreate = true);

    /**
     * @param int $productId
     * @return mixed
     */
    public function getInfoPriceProduct(int $productId);
}