<?php
/**
 * ProductSpace repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentProductSpaceRepositories extends RepositoriesAbstract implements ProductSpaceRepositories {
    /**
     * @param int $businessTypeId
     * @return mixed
     */
    public function getAllSpacesByBusinessTypeId(int $businessTypeId) {
        return [];
    }
}