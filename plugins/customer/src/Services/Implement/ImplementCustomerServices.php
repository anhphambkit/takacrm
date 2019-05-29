<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-04
 * Time: 13:36
 */

namespace Plugins\Customer\Services\Implement;

use Core\Base\Traits\ParseFilterSearch;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Services\CustomerServices;

class ImplementCustomerServices implements CustomerServices
{
    use ParseFilterSearch;
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
     * @return mixed
     */
    public function searchListCustomer(array $request)
    {
        return $this->customerRepository->searchListCustomer($request);
    }

    /**
     * @param array $filters
     * @return array|mixed
     */
    public function searchAjaxCustomer(array $filters) {
        $filters = $this->getFilterAjaxSearch($filters);
        return $customers = $this->customerRepository->searchAjaxCustomer($filters);
    }
}