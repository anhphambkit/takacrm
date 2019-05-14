<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-12
 * Time: 23:03
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_units';

    protected $fillable = [
        'name',
        'slug',
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