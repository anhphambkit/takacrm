<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 7/15/18
 * Time: 11:54
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Services\ProductCategoryServices;

class ImplementProductCategoryServices implements ProductCategoryServices{

    private $repository;

    /**
     * ImplementProductCategoryServices constructor.
     * @param ProductCategoryRepositories $productCategoryRepositories
     */
    public function __construct(ProductCategoryRepositories $productCategoryRepositories)
    {
        $this->repository = $productCategoryRepositories;
    }

}