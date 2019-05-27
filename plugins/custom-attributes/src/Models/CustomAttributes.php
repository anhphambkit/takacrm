<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-18
 * Time: 15:37
 */

namespace Plugins\CustomAttributes\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;

class CustomAttributes extends Model
{
//    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'custom_attributes';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type_entity',
        'type_value',
        'type_render',
        'is_required',
        'is_unique',
        'status',
        'created_by',
        'updated_by',
    ];

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
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the value string of custom attribute.
     */
    public function stringValueAttributes()
    {
        return $this->hasMany(CustomAttributeValueString::class, 'custom_attribute_id');
    }

    /**
     * Get the value number of custom attribute.
     */
    public function numberValueAttributes()
    {
        return $this->hasMany(CustomAttributeValueNumber::class, 'custom_attribute_id');
    }

    /**
     * Get the value text of custom attribute.
     */
    public function textValueAttributes()
    {
        return $this->hasMany(CustomAttributeValueText::class, 'custom_attribute_id');
    }

    /**
     * Get the value date of custom attribute.
     */
    public function dateValueAttributes()
    {
        return $this->hasMany(CustomAttributeValueDate::class, 'custom_attribute_id');
    }

    /**
     * Get the value option of custom attribute.
     */
    public function optionValueAttributes()
    {
        return $this->hasMany(CustomAttributeValueOption::class, 'custom_attribute_id');
    }

    /**
     * Get the options of attribute.
     */
    public function attributeOptions()
    {
        return $this->hasMany(CustomAttributeOptions::class, 'custom_attribute_id');
    }
}