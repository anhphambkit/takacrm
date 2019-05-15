<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;

class CacheProductColorRepositories extends CacheAbstractDecorator implements ProductColorRepositories
{
    /**
     * @var ApplicationInterface
     */
    protected $repository;

    /**
     * ApplicationCacheDecorator constructor.
     * @param ApplicationInterface $repository
     * @author AnhPham
     */
    public function __construct(ProductColorRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'product_colors'; # Please setup reference name of cache.
    }
}
