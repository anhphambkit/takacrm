<?php
namespace Plugins\Order\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Order\Repositories\Interfaces\ProductsInOrderRepositories;

class CacheProductsInOrderRepositories extends CacheAbstractDecorator implements ProductsInOrderRepositories
{
    /**
     * @var ProductsInOrderRepositories
     */
    protected $repository;

    /**
     * CacheProductsInOrderRepositories constructor.
     * @param ProductsInOrderRepositories $repository
     */
    public function __construct(ProductsInOrderRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'Cache-Product-In-Order'; # Please setup reference name of cache.
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function insertProductsInOrder(array $data) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $orderId
     * @return mixed
     */
    public function getAllProductsInOrder(int $orderId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
