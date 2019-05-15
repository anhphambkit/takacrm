<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\BrandRepositories;

class CacheBrandRepositories extends CacheAbstractDecorator implements BrandRepositories
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
    public function __construct(BrandRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'product_brands'; # Please setup reference name of cache.
    }
}
