<?php

namespace Plugins\Tenant\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;

class CacheTenantRepositories extends CacheAbstractDecorator implements TenantRepositories
{
    /**
     * @var TenantRepositories
     */
    protected $repository;

    /**
     * TenantCacheDecorator constructor.
     * @param TenantRepositories $repository
     * @author TrinhLe
     */
    public function __construct(TenantRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Tenant"; # Please setup reference name of cache.
    }
}
