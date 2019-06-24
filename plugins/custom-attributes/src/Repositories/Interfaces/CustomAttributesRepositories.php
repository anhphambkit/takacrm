<?php

namespace Plugins\CustomAttributes\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface CustomAttributesRepositories extends RepositoryInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function createOrUpdateCustomAttribute(array $data);

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCustomAttributeByConditions(array $conditions = [], array $with = [], array $select = ['*']);
}
