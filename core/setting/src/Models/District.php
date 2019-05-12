<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2/16/19
 * Time: 15:43
 */

namespace Core\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'districts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'english_name',
        'city_province_code',
        'type_level'
    ];

    public $timestamps = true;
}