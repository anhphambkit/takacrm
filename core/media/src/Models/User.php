<?php

namespace Core\Media\Models;

use Eloquent;

class User extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Static function get filter list users
     * @author  TrinhLe
     * @return Illuminate\Support\Collection
     */
    public static function getListUsers($userId)
    {
        $prefix = env('DB_PREFIX', '');
        $selectColumns = "{$prefix}users.id, CONCAT({$prefix}users.first_name, ' ', {$prefix}users.last_name) AS name";
        return static::where('id', '!=', (int)$userId)->selectRaw($selectColumns)->get();
    }
}