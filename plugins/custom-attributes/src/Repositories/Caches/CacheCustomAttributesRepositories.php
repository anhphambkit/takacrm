<?php

namespace Plugins\CustomAttributes\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;

class CacheCustomAttributesRepositories extends CacheAbstractDecorator implements CustomAttributesRepositories
{
    /**
     * @var CustomAttributesRepositories
     */
    protected $repository;

    /**
     * CustomAttributesCacheDecorator constructor.
     * @param CustomAttributesRepositories $repository
     * @author TrinhLe
     */
    public function __construct(CustomAttributesRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-CustomAttributes"; # Please setup reference name of cache.
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createOrUpdateCustomAttribute(array $data) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
