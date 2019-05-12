<?php

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Product\Models\Product
 *
 * @mixin \Eloquent
 */
class Product extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'upc',
        'sku',
        'image_feature',
        'short_description',
        'long_desc',
        'manufacturer_id',
        'is_feature',
        'is_best_seller',
        'is_free_ship',
        'available_3d',
        'is_outdoor',
        'has_assembly',
        'product_dimension',
        'package_dimension',
        'product_weight',
        'package_weight',
        'price',
        'sale_price',
        'inventory',
        'rating',
        'keywords',
        'created_by',
        'updated_by',
        'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_categories_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productBusinessTypes()
    {
        return $this->belongsToMany(ProductBusinessType::class, 'product_business_types_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productCollections()
    {
        return $this->belongsToMany(ProductCollection::class, 'product_collections_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productColors()
    {
        return $this->belongsToMany(ProductColor::class, 'product_colors_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function productMaterials()
    {
        return $this->belongsToMany(ProductMaterial::class, 'product_materials_relation');
    }

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
}
