<?php

namespace Plugins\Customer\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface CustomerRepositories extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAllCustomers();

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListCustomer(array $request);

    /**
     * @param string $type
     * @param int $id
     * @return mixed
     */
    public function getListCustomerIntroducedByTypeAndId(string $type, int $id);

    /**
     * @param array $filters
     * @return mixed
     */
    public function searchAjaxCustomer(array $filters);
}
