<?php

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package Plugins\Product\Models
 */
class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'image_feature',
        'short_description',
        'long_desc',
        'manufacturer_id',
        'unit_id',
        'origin_id',
        'category_id',
        'retail_price',
        'wholesale_price',
        'online_price',
        'purchase_price',
        'discount',
        'wholesale_discount',
        'purchase_discount',
        'online_discount',
        'vat',
        'is_feature',
        'created_by',
        'updated_by',
        'status',
    ];

    /**
     * Get the gallery for the product.
     */
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
