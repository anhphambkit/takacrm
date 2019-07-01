<?php

namespace Plugins\Customer\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;

class CacheCustomerRepositories extends CacheAbstractDecorator implements CustomerRepositories
{
    /**
     * @var CustomerRepositories
     */
    protected $repository;

    /**
     * CustomerCacheDecorator constructor.
     * @param CustomerRepositories $repository
     * @author TrinhLe
     */
    public function __construct(CustomerRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Customer"; # Please setup reference name of cache.
    }

    /**
     * @return mixed
     */
    public function getAllCustomers() {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListCustomer(array $request) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param string $type
     * @param int $id
     * @return mixed
     */
    public function getListCustomerIntroducedByTypeAndId(string $type, int $id) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function searchAjaxCustomer(array $filters) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $customerId
     * @return mixed
     */
    public function getInfoWithContactOfCustomer(int $customerId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
