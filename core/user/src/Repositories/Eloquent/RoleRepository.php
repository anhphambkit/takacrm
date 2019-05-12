<?php

namespace Core\User\Repositories\Eloquent;

use Core\User\Repositories\Interfaces\RoleInterface;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class RoleRepository extends RepositoriesAbstract implements RoleInterface
{
    /**
     * @param $name
     * @param $id
     * @return mixed
     * @author TrinhLe
     */
    public function createSlug($name, $id)
    {
        $slug = str_slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->model->where('slug', '=', $slug)->where('id', '!=', $id)->withTrashed()->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }

        $this->resetModel();

        return $slug;
    }
}
