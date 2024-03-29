<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 09:08
 */

namespace Plugins\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Plugins\History\Models\ProductOrderHistory;

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

    /**
     * Get the product that owns the gallery.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @author TrinhLe
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($productsOrder) {
            $sessionUpdate = session()->get('session_update_order');
            ProductOrderHistory::create([
                'path_session' => $sessionUpdate,
                'order_id'     => $productsOrder->order_id,
                'json_product' => json_encode($productsOrder->toArray())
            ]);
        });
    }
}