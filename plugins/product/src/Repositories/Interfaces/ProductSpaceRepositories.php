<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductSpaceRepositories extends RepositoryInterface{
    /**
     * @param int $businessTypeId
     * @return mixed
     */
    public function getAllSpacesByBusinessTypeId(int $businessTypeId);
}