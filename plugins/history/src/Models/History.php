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

    /**
     * [$appends description]
     * @var [type]
     */
    protected $appends =[
        'user_image',
        'username'
    ];

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

    /**
     * [getUserImageAttribute description]
     * @return [type] [description]
     */
    public function getUserImageAttribute()
    {
        return $this->user->profile_image ?? '/storage/system/images/default-avatar.png';
    }

    /**
     * [getUserImageAttribute description]
     * @return [type] [description]
     */
    public function getUsernameAttribute()
    {
        return $this->user->getFullName() ?? '';
    }
}
