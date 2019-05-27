<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-27
 * Time: 12:23
 */

namespace Plugins\CustomAttributes\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;

class CustomAttributeOptions extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'custom_attribute_options';

    protected $fillable = [
        'custom_attribute_id',
        'option_text',
        'is_default',
        'is_option_header',
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
     * Get the custom of attribute.
     */
    public function customAttribute()
    {
        return $this->belongsTo(CustomAttributes::class);
    }
}