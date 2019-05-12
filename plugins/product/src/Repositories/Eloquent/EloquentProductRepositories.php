<?php

namespace Plugins\Product\Repositories\Eloquent;

use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

class EloquentProductRepositories extends RepositoriesAbstract implements ProductRepositories
{
    /**
     * @param int|null $categoryId
     * @return mixed
     * @throws \Exception
     */
    public function getAllProductsByCategory(int $categoryId = null)
    {
        try {
            $query = $this->model->products();

//            if ($categoryId)
//                $query = $query->where('relation.cate_id', '=', $categoryId);
//            ->orderBy('category.order', 'asc')->orderBy('products.order', 'asc')
            return $query->get();
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
