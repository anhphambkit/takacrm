<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-30
 * Time: 18:02
 */

namespace Plugins\Customer\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerContact extends Model
{
//    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customer_contacts';

    protected $fillable = [
        'customer_id',
        'full_name',
        'job_position',
        'phone',
        'gender',
        'email',
        'dob',
        'note',
        'is_receive_email',
        'is_primary_contact',
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
     * Get the customer that owns the contact.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

//    /**
//     * @param $value
//     */
//    public function setDobAttribute($value)
//    {
////        $this->attributes['dob'] = (empty($value)) ? null : format_date_time($value, 'Asia/Ho_Chi_Minh', 'd/m/Y')->format('Y-m-d');
//    }
}