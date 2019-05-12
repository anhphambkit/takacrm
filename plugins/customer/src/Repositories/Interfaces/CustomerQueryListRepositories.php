<?php
namespace Plugins\Customer\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface CustomerQueryListRepositories extends RepositoryInterface{
    /**
     * @param int $userId
     * @return mixed
     */
    public function getListCustomerForSelect2(int $userId);
}