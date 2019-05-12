<?php

namespace Plugins\Product\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductRepositories extends RepositoryInterface
{
    /**
     * @param int|null $categoryId
     * @return mixed
     */
    public function getAllProductsByCategory(int $categoryId = null);
}
