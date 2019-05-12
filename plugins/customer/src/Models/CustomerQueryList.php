<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-04
 * Time: 21:57
 */

namespace Plugins\Customer\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class CustomerQueryList extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customer_query_list';

    protected $fillable = [
        'name',
        'slug',
        'conditions',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function referenceUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getConditionsAttribute($value)
    {
        return json_decode($value);
    }
}