<?php
namespace Core\User\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface RoleInterface extends RepositoryInterface
{
    /**
     * @param $name
     * @param $id
     * @return mixed
     * @author TrinhLe
     */
    public function createSlug($name, $id);
}
