<?php
namespace Plugins\Customer\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Customer\Repositories\Interfaces\CustomerQueryListRepositories;

class CacheCustomerQueryListRepositories extends CacheAbstractDecorator implements CustomerQueryListRepositories
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
    public function __construct(CustomerQueryListRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'customerQueryList'; # Please setup reference name of cache.
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getListCustomerForSelect2(int $userId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
