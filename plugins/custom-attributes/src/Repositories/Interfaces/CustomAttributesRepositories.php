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
}
