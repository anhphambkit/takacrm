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

    /**
     * @param array $data
     * @return mixed
     */
    public function createNewInvoiceOrder(array $data) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListOrder(array $request) {
        $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
