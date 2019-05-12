<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-11
 * Time: 16:27
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductBusinessType extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_business_types';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'status',
        'is_root',
        'created_by',
        'updated_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_business_types_relation');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function spaces()
    {
        return $this->belongsToMany(ProductSpace::class, 'business_type_space_relation', 'business_type_id', 'space_id')->select(['product_spaces.id', 'name as text', 'slug', 'image_feature']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author TrinhLe
     */
    public function parent()
    {
        return $this->belongsTo(ProductBusinessType::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author TrinhLe
     */
    public function children()
    {
        return $this->hasMany(ProductBusinessType::class, 'parent_id');
    }
}