<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;

class CacheProductSpaceRepositories extends CacheAbstractDecorator implements ProductSpaceRepositories
{
    /**
     * @var ApplicationInterface
     */
    protected $repository;

    /**
     * ApplicationCacheDecorator constructor.
     * @param ApplicationInterface $repository
     * @author TrinhLe
     */
    public function __construct(ProductSpaceRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'space-repo'; # Please setup reference name of cache.
    }

    /**
     * @param int $businessTypeId
     * @return mixed
     */
    public function getAllSpacesByBusinessTypeId(int $businessTypeId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
