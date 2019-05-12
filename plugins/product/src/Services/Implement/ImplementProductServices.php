<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 11/7/18
 * Time: 03:32
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Services\ProductServices;

class ImplementProductServices implements ProductServices {

    private $repository;

    /**
     * ImplementProductCategoryServices constructor.
     * @param ProductRepositories $productRepository
     */
    public function __construct(ProductRepositories $productRepository)
    {
        $this->repository = $productRepository;
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
}