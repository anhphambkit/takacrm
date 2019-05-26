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
}
