<?php
/**
 * CustomerQueryList repository implemented
 */
namespace Plugins\Customer\Repositories\Eloquent;
use Plugins\Customer\Repositories\Interfaces\CustomerQueryListRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentCustomerQueryListRepositories extends RepositoriesAbstract implements CustomerQueryListRepositories {
    /**
     * @param int $userId
     * @return mixed
     */
    public function getListCustomerForSelect2(int $userId) {
        return $this->model->select('id', 'name as text')->where('user_id', $userId)->orderBy('id', 'asc')->get();
    }
}