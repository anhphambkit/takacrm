<?php
/**
 * Category repository implemented
 */
namespace Plugins\Blog\Repositories\Eloquent;
use Plugins\Blog\Repositories\Interfaces\CategoryRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Eloquent;

class EloquentCategoryRepositories extends RepositoriesAbstract implements CategoryRepositories {

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->where('categories.status', '=', true)
            ->select('categories.*')
            ->orderBy('categories.created_at', 'desc');

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedCategories($limit)
    {
        $data = $this->model
            ->where([
                'categories.status'      => true,
                'categories.is_featured' => 1,
            ])
            ->select([
                'categories.id',
                'categories.name',
                'categories.icon',
            ])
            ->orderBy('categories.order', 'asc')
            ->select('categories.*')
            ->limit($limit);

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCategories(array $condition = [])
    {
        $data = $this->model->select('categories.*');
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data->orderBy('categories.order', 'DESC');

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryById($id)
    {
        $data = $this->model->where([
            'categories.id'     => $id,
            'categories.status' => true,
        ]);

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories(array $select, array $orderBy)
    {
        $data = $this->model->select($select);
        foreach ($orderBy as $by => $direction) {
            $data = $data->orderBy($by, $direction);
        }

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllRelatedChildrenIds($id)
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['categories.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('categories.id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIds($child), $result);
        }
        $this->resetModel();

        return array_unique($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCategoriesWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        $data = $this->model
            ->where($condition)
            ->with($with)
            ->select($select);

        return $data->get();
    }
}