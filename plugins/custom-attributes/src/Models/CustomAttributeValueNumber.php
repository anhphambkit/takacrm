<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-27
 * Time: 16:42
 */
namespace Plugins\CustomAttributes\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomAttributeValueNumber extends Model
{
//    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'custom_attribute_value_number';

    protected $fillable = [
        'custom_attribute_id',
        'entity_id',
        'value',
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

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (float)$value;
    }
}