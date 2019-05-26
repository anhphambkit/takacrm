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
}
