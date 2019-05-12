<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-04
 * Time: 13:36
 */

namespace Plugins\Customer\Services\Implement;

use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Services\CustomerServices;

class ImplementCustomerServices implements CustomerServices
{
    /**
     * @var CustomerRepositories
     */
    private $customerRepository;

    /**
     * ImplementCustomerServices constructor.
     * @param CustomerRepositories $customerRepositories
     */
    public function __construct(CustomerRepositories $customerRepositories)
    {
        $this->customerRepository = $customerRepositories;
    }

    /**
     * @param array $request
     * @return mixed|void
     */
    public function searchListCustomer(array $request)
    {
        return $this->customerRepository->searchListCustomer($request);
    }
}