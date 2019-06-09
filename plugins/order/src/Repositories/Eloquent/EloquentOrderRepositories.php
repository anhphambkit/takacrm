<?php

namespace Plugins\Order\Repositories\Eloquent;

use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;

class EloquentOrderRepositories extends RepositoriesAbstract implements OrderRepositories
{
    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function createNewInvoiceOrder(array $data) {
        return $this->model->create($data);
    }
}
