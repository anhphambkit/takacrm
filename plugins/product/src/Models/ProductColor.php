<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-09
 * Time: 00:21
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_colors';

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];
}