<?php
/**
 * Created by PhpStorm.
 * User: Tu Nguyen
 * Date: 2019-05-24
 * Time: 23:03
 */

namespace Plugins\Order\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_method';

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
