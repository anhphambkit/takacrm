<?php

namespace Plugins\Order\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Order\Models\Order
 *
 * @mixin \Eloquent
 */
class Order extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order';

    protected $fillable = ['name'];
}
