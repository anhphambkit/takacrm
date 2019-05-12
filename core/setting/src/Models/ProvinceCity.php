<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2/16/19
 * Time: 15:42
 */

namespace Core\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinceCity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'provinces_cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'english_name',
        'country_code',
        'type_level',
        'order'
    ];

    public $timestamps = true;
}