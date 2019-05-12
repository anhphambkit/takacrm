<?php

namespace Plugins\Product\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

class CacheProductRepositories extends CacheAbstractDecorator implements ProductRepositories
{
    /**
     * @var ProductRepositories
     */
    protected $repository;

    /**
     * ProductCacheDecorator constructor.
     * @param ProductRepositories $repository
     * @author AnhPham
     */
    public function __construct(ProductRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Product"; # Please setup reference name of cache.
    }

    /**
     * @param int|null $categoryId
     * @return mixed
     */
    public function getAllProductsByCategory(int $categoryId = null) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
