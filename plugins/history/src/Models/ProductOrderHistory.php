<?php

namespace Plugins\History\Models;

use Eloquent;

/**
 * Plugins\History\Models\History
 *
 * @mixin \Eloquent
 */
class ProductOrderHistory extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_order_history';

    /**
     * [$fillable description]
     * @var [type]
     */
    protected $fillable = [
    	'path_session',
        'json_product',
        'order_id',
    ];
}
