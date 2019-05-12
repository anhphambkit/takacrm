<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-26
 * Time: 23:39
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSpace extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_spaces';

    protected $fillable = [
        'name',
        'slug',
        'image_feature',
        'description',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function spaceBusinessTypes()
    {
        return $this->belongsToMany(ProductBusinessType::class, 'business_type_space_relation', 'space_id', 'business_type_id');
    }
}