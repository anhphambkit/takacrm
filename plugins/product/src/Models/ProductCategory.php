<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-13
 * Time: 05:13
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'slug',
        'image_feature',
        'description',
        'parent_id',
        'order',
        'status',
        'created_by',
        'updated_by',
        'is_root',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories_relation')->select(['products.id', 'name as text', 'image_feature']);
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