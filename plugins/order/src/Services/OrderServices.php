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
     * @return mixed
     */
    public function createNewOrder(array $dataCheckouts);

    /**
     * @param array $conditions
     * @param array $data
     * @return mixed
     */
    public function updateOrder(array $conditions, array $data);
}