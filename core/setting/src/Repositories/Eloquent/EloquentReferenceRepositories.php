<?php
/**
 * Created by PhpStorm.
 * User: BiWin
 * Date: 22/12/2018
 * Time: 2:36 PM
 */
namespace Core\Setting\Repositories\Eloquent;

use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Core\Setting\Repositories\Interfaces\ReferenceRepositories;
use Illuminate\Support\Facades\DB;

class EloquentReferenceRepositories extends RepositoriesAbstract implements ReferenceRepositories {
    /**
     * @param $table
     * @param $where
     * @param bool $isUnique
     * @param string $orderBy
     * @return mixed
     */
    public function getReferenceFromAttribute($table, $where, $isUnique = false, $orderBy = 'id') {
        $query = DB::table($table)
            ->select('*')
            ->where($where)
            ->where('is_publish', '=', true)
            ->orderBy($orderBy);
        if ($isUnique) return $query->first();
        return $query->get();
    }

    /**
     * @param string $type
     * @param string|null $value
     * @return mixed
     * @throws \Exception
     */
    public function getReferenceFromAttributeType(string $type, string $value = null) {
        try {
            if ($value)
                return $this->model
                    ->select('*')
                    ->where('type', $type)
                    ->where('value', $value)
                    ->where('publish', true)
                    ->get();
            else
                return $this->model
                    ->select('*')
                    ->where('type', $type)
                    ->where('publish', true)
                    ->orderBy('order', 'asc')
                    ->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}