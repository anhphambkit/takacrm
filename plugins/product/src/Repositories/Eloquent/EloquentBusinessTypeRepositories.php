<?php
/**
 * BusinessType repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentBusinessTypeRepositories extends RepositoriesAbstract implements BusinessTypeRepositories {
    /**
     * @return mixed
     */
    public function getAllBusinessTypeGroupByParent() {
        return $this->model->select('id', 'name', 'slug', 'order')->where('parent_id', 0)->with('children')->orderBy('order', 'asc')->get();
    }
}