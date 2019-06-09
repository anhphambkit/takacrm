<?php
namespace Plugins\Order\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductsInOrderRepositories extends RepositoryInterface{
    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function insertProductsInOrder(array $data);

    /**
     * @param int $orderId
     * @return mixed
     */
    public function getAllProductsInOrder(int $orderId);
}