<?php

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Models\CustomAttributes;
use Plugins\History\Models\ModelHistoryLog;

/**
 * Class Product
 * @package Plugins\Product\Models
 */
class Product extends ModelHistoryLog
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

    /**
     * [getCategoryNameAttribute description]
     * @return [type] [description]
     */
    public function getCategoryNameAttribute() {
        return ($this->productCategory) ? $this->productCategory->name : '';
    }

    /**
     * [getUnitNameAttribute description]
     * @return [type] [description]
     */
    public function getUnitNameAttribute() {
        return ($this->productUnit) ? $this->productUnit->name : '';
    }

    /**
     * [getManufacturerNameAttribute description]
     * @return [type] [description]
     */
    public function getManufacturerNameAttribute() {
        return ($this->productManufacturer) ? $this->productManufacturer->name : '';
    }

    /**
     * [getOriginNameAttribute description]
     * @return [type] [description]
     */
    public function getOriginNameAttribute() {
        return ($this->productOrigin) ? $this->productOrigin->name : '';
    }


    ################### LOGGER ###########################

    /**
     * [$attributeDelete description]
     * @var array
     */
    protected $deleteAttributes = [
        'primaryIndex' => 'name',
    ];

    /**
     * [$createAttributes description]
     * @var array
     */
    protected $createAttributes = [
        'primaryIndex' => 'name',
    ];

    /**
     * [$ignoreLogAttributes description]
     * @var [type]
     */
    protected $ignoreLogAttributes = [
        'updated_at',
        'updated_by',
        'deleted_at'
    ];

    /**
     * [$displayAttributes description]
     * @var [type]
     */
    protected $displayAttributes = [
        'name'               => 'Name',
        'slug'               => 'Slug',
        'sku'                => 'Sku',
        'image_feature'      => 'Image',
        'short_description'  => 'Short Description',
        'long_desc'          => 'Long Description',
        'manufacturer_id'    => 'Manufacturer',
        'unit_id'            => 'Unit',
        'origin_id'          => 'Origin',
        'category_id'        => 'Product Category',
        'retail_price'       => 'Retail Price',
        'wholesale_price'    => 'Wholesale Price',
        'online_price'       => 'Online Price',
        'purchase_price'     => 'Purchase Price',
        'discount_percent'   => 'Discount Percent',
        'wholesale_discount' => 'Wholesale Discount',
        'purchase_discount'  => 'Purchase Discount',
        'online_discount'    => 'Online Discount',
        'vat'                => 'Vat',
        'is_feature'         => 'Product Feature',
        'status'             => 'Status',
    ];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $relationShipAttributes = [
        'parent_id' => [
            'mapTable'  => 'product_categories',
            'mapColumn' => 'id',
            'mapResult' => 'name'
        ],
        'manufacturer_id' => [
            'mapTable'  => 'product_manufacturers',
            'mapColumn' => 'id',
            'mapResult' => 'name'
        ],
        'unit_id' => [
            'mapTable'  => 'product_units',
            'mapColumn' => 'id',
            'mapResult' => 'name'
        ],
        'origin_id' => [
            'mapTable'  => 'product_origins',
            'mapColumn' => 'id',
            'mapResult' => 'name'
        ]
    ];

    /**
     * [$logBooleanAttributes description]
     * @var [type]
     */
    protected $logBooleanAttributes = [
        'status' => ['Activated', 'Disabled'],
        'is_feature' => ['Feature', 'None Feature']
    ];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $logTargetAttributes = [
        'target' => HISTORY_MODULE_PRODUCT,
        'primary' => 'id'
    ];
}
