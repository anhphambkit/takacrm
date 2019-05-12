<?php
namespace Plugins\Blog\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface CategoryRepositories extends RepositoryInterface{

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     * @author TrinhLe
     */
    public function getFeaturedCategories($limit);

    /**
     * @param array $condition
     * @return mixed
     * @author TrinhLe
     */
    public function getAllCategories(array $condition = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function getCategoryById($id);

    /**
     * @param array $select
     * @param array $orderBy
     * @return Collection
     */
    public function getCategories(array $select, array $orderBy);

    /**
     * @param int $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id);

    /**
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return mixed
     * @author TrinhLe
     */
    public function getAllCategoriesWithChildren(array $condition = [], array $with = [], array $select = ['*']);
}