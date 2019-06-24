<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 09:16
 */

namespace Plugins\Order\Services;


interface ProductsInOrderServices
{
    /**
     * @param array $data
     * @return mixed
     */
    public function insertProductsInOrder(array $data);

    /**
     * @param int $orderId
     * @return mixed
     */
    public function getAllProductsInOrder(int $orderId);
}