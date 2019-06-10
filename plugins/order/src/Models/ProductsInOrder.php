<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 09:08
 */

namespace Plugins\Order\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsInOrder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products_in_order';

    protected $fillable = [
        'order_id',
        'product_id',
        'sku',
        'name',
        'slug',
        'short_description',
        'unit_name',
        'quantity',
        'retail_price',
        'vat',
        'discount',
        'discount_percent',
        'total_price',
        'product_info'
    ];
}