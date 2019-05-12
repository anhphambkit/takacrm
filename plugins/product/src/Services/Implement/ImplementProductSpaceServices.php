<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-11
 * Time: 13:47
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;
use Plugins\Product\Services\ProductSpaceServices;

class ImplementProductSpaceServices implements ProductSpaceServices {

    private $repository;

    /**
     * ImplementBusinessTypeServices constructor.
     * @param ProductSpaceRepositories $productSpaceRepositories
     */
    public function __construct(ProductSpaceRepositories $productSpaceRepositories)
    {
        $this->repository = $productSpaceRepositories;
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getSpaceBySlug(string $slug) {
        return $this->repository->bySlug($slug);
    }
}