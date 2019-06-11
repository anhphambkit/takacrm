<?php

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Models\CustomAttributes;

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
        'discount_percent',
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'custom_attributes_value',
        'category_name',
        'unit_name',
        'manufacturer_name',
        'origin_name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function productManufacturer()
    {
        return $this->belongsTo(ProductManufacturer::class, 'manufacturer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function productOrigin()
    {
        return $this->belongsTo(ProductOrigin::class, 'origin_id');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productValueStringCustomAttribute() {
        return $this->belongsToMany(CustomAttributes::class, 'custom_attribute_value_string', 'entity_id', 'custom_attribute_id');
    }

    /**
     * Get the value of custom attribute.
     */
    public function getCustomAttributesValueAttribute()
    {
        $typeValue = ucfirst($this->type_value);
        $methodAttribute = "productValue{$typeValue}Attribute";
        switch ($this->type_value) {
            case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_STRING:
                return (!empty($this->$methodAttribute()) ? $this->$methodAttribute() : null);
                break;
            case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_NUMBER:
                return null;
                break;
            case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_DATE:
                return null;
                break;
            case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_OPTION:
                return null;
                break;
        }
    }

    public function getCategoryNameAttribute() {
        return ($this->productCategory) ? $this->productCategory->name : '';
    }

    public function getUnitNameAttribute() {
        return ($this->productUnit) ? $this->productUnit->name : '';
    }

    public function getManufacturerNameAttribute() {
        return ($this->productManufacturer) ? $this->productManufacturer->name : '';
    }

    public function getOriginNameAttribute() {
        return ($this->productOrigin) ? $this->productOrigin->name : '';
    }
}
