<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;

class CacheManufacturerRepositories extends CacheAbstractDecorator implements ManufacturerRepositories
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
    public function __construct(ManufacturerRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'product_manufacturers'; # Please setup reference name of cache.
    }
}
