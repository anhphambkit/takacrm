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
        'target_type',
        'target_id',
        'value_origin',
        'value_current',
        'field_name',
        'path_session',
        'table_name',
        'attribute_name'
    ];


    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
        return $this->morphTo();
    }
}
