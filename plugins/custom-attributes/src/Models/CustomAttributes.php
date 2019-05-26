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

class CustomAttributes extends Model
{
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
     * Get the look book tags for the look book.
     */
    public function stringAttributes()
    {
        return $this->hasMany(CustomAttributeValueString::class);
    }
}