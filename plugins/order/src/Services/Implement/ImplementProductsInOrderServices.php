<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 09:16
 */

namespace Plugins\Order\Services\Implement;

use Plugins\Order\Repositories\Interfaces\ProductsInOrderRepositories;
use Plugins\Order\Services\ProductsInOrderServices;

class ImplementProductsInOrderServices implements ProductsInOrderServices
{
    /**
     * @var ProductsInOrderRepositories
     */
    private $productsInOrderRepository;

    /**
     * ProductsInOrderServices constructor.
     * @param ProductsInOrderRepositories $productsInOrderRepository
     */
    public function __construct(ProductsInOrderRepositories $productsInOrderRepository)
    {
        $this->productsInOrderRepository = $productsInOrderRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function insertProductsInOrder(array $data) {
        try {
            return $this->productsInOrderRepository->insertProductsInOrder($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $orderId
     * @return mixed
     */
    public function getAllProductsInOrder(int $orderId) {
        return $this->productsInOrderRepository->getAllProductsInOrder($orderId);
    }
}