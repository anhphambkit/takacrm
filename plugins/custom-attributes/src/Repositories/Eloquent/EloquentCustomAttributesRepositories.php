<?php

namespace Plugins\CustomAttributes\Repositories\Eloquent;

use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;

class EloquentCustomAttributesRepositories extends RepositoriesAbstract implements CustomAttributesRepositories
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createOrUpdateCustomAttribute(array $data) {
        return $this->createOrUpdate($data);
    }

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCustomAttributeByConditions(array $conditions = [], array $with = [], array $select = ['*']) {
        return $this->allBy($conditions, $with, $select);
    }
}
