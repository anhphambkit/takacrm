<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2/16/19
 * Time: 15:44
 */

namespace Core\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'english_name',
        'district_code',
        'type_level'
    ];

    public $timestamps = true;
}