<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-21
 * Time: 21:30
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_galleries';

    protected $fillable = [
        'product_id',
        'media',
        'description'
    ];

    /**
     * Get the product that owns the gallery.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}