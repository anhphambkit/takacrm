<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-13
 * Time: 05:13
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
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
        return $this->belongsTo(User::class, 'created_by');
    }
}