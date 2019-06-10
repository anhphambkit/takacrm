<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 09:14
 */

namespace Plugins\Order\Services;

interface OrderServices
{
    /**
     * @param array $dataCheckouts
     * @param int $orderId
     * @return mixed
     */
    public function createNewOrUpdateOrder(array $dataCheckouts, int $orderId = null);

    /**
     * @param array $conditions
     * @param array $data
     * @return mixed
     */
    public function updateOrder(array $conditions, array $data);

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListOrder(array $request);
}