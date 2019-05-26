<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 09:12
 */

namespace Plugins\CustomAttributes\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class AttributeValueString extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attribute_value_string';

    protected $fillable = [
        'custom_attribute_id',
        'value',
        'name',
        'image_feature',
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
     * Get the custom attribute set that owns the attribute.
     */
    public function customAttribute()
    {
        return $this->belongsTo(CustomAttributes::class);
    }
}