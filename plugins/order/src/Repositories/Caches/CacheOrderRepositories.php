<?php

namespace Plugins\Order\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;

class CacheOrderRepositories extends CacheAbstractDecorator implements OrderRepositories
{
    /**
     * @var OrderRepositories
     */
    protected $repository;

    /**
     * OrderCacheDecorator constructor.
     * @param OrderRepositories $repository
     * @author TrinhLe
     */
    public function __construct(OrderRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Order"; # Please setup reference name of cache.
    }
}