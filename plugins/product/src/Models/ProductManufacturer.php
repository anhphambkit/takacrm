<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-08
 * Time: 22:07
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProductManufacturer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_manufacturers';

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
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