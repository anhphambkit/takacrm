<?php
/**
 * ProductsInOrder repository implemented
 */
namespace Plugins\Order\Repositories\Eloquent;
use Plugins\Order\Repositories\Interfaces\ProductsInOrderRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentProductsInOrderRepositories extends RepositoriesAbstract implements ProductsInOrderRepositories {
    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function insertProductsInOrder(array $data) {
        try {
            return $this->model->insert($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $orderId
     * @return mixed
     * @throws \Exception
     */
    public function getAllProductsInOrder(int $orderId) {
        try {
            $query = $this->model->select('*')->where('order_id', $orderId)->get();
            return $query;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}