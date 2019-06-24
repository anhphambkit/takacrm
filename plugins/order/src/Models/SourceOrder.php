<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-06
 * Time: 04:03
 */

namespace Plugins\Order\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class SourceOrder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_sources';

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
     * @author Tu Nguyen
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Tu Nguyen
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}