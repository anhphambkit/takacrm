<?php

namespace Plugins\Tenancy\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Tenancy\Repositories\Interfaces\TenancyRepositories;

class CacheTenancyRepositories extends CacheAbstractDecorator implements TenancyRepositories
{
    /**
     * @var TenancyRepositories
     */
    protected $repository;

    /**
     * TenancyCacheDecorator constructor.
     * @param TenancyRepositories $repository
     * @author TrinhLe
     */
    public function __construct(TenancyRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Tenancy"; # Please setup reference name of cache.
    }
}
