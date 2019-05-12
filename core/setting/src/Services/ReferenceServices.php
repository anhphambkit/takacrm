<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 3/9/19
 * Time: 15:14
 */

namespace Core\Setting\Services;

interface ReferenceServices
{
    /**
     * @param $table
     * @param $where
     * @param bool $isUnique
     * @param string $orderBy
     * @return mixed
     */
    public function getReferenceFromAttribute($table, $where, $isUnique = false, $orderBy = 'id');

    /**
     * @param string $type
     * @param string|null $value
     * @return mixed
     */
    public function getReferenceFromAttributeType(string $type, string $value = null);
}