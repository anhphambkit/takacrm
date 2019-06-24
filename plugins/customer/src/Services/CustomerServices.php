<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-04
 * Time: 13:35
 */

namespace Plugins\Customer\Services;


interface CustomerServices
{
    /**
     * @param array $request
     * @return mixed
     */
    public function searchListCustomer(array $request);

    /**
     * @param array $filters
     * @return mixed
     */
    public function searchAjaxCustomer(array $filters);

    /**
     * @param int $customerId
     * @return mixed
     */
    public function getInfoWithContactOfCustomer(int $customerId);
}