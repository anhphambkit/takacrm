<?php

namespace Plugins\History\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\History\Models\History
 *
 * @mixin \Eloquent
 */
class History extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history';

    protected $fillable = [
    	'name',
		'status',
		'user_id',
		'user_type',
		'type',
		'content',
    ];
}
