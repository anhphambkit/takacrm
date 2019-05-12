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
}