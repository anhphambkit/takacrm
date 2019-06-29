<?php

namespace Plugins\Order\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface OrderRepositories extends RepositoryInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createNewOrUpdateOrder(array $data);

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListOrder(array $request);
}
