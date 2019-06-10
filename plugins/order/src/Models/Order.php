<?php

namespace Plugins\Order\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package Plugins\Order\Models
 */
class Order extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_code',
        'customer_phone',
        'customer_address',
        'customer_email',
        'customer_id',
        'customer_info',
        'user_performed_id',
        'user_performed_info',
        'order_date',
        'payment_method_id',
        'payment_method_info',
        'order_source_id',
        'order_source_info',
        'lading_code',
        'campaign_id',
        'customer_contact_id',
        'customer_contact_info',
        'order_file',
        'order_conditions',
        'fees_ship',
        'fees_vat',
        'fees_shipping',
        'fees_installation',
        'fees_ship_percent',
        'fees_vat_percent',
        'fees_shipping_percent',
        'fees_installation_percent',
        'is_discount_after_tax',
        'sale_order',
        'discount_order',
        'vat_order',
        'sub_total',
        'total_order',
        'created_by',
        'updated_by',
        'order_status',
        'payment_status',
        'status'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'created_by_instance',
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

    /*
     * ==========================================================================================================
     * ================================================== SETTER ================================================
     * ==========================================================================================================
     */

    /**
     * @param $value
     */
    public function setCustomerInfoAttribute($value)
    {
        $this->attributes['customer_info'] = json_encode($value);
    }

    /**
     * @param $value
     */
    public function setUserPerformedInfoAttribute($value)
    {
        $this->attributes['user_performed_info'] = json_encode($value);
    }

    /**
     * @param $value
     */
    public function setPaymentMethodInfoAttribute($value)
    {
        $this->attributes['payment_method_info'] = json_encode($value);
    }

    /**
     * @param $value
     */
    public function setOrderSourceInfoAttribute($value)
    {
        $this->attributes['order_source_info'] = json_encode($value);
    }

    /**
     * @param $value
     */
    public function setCustomerContactInfoAttribute($value)
    {
        $this->attributes['customer_contact_info'] = json_encode($value);
    }

    /**
     * @param $value
     */
    public function setOrderConditionsAttribute($value)
    {
        $this->attributes['order_conditions'] = json_encode($value);
    }

    /*
    * ==========================================================================================================
    * ================================================== GETTER ================================================
    * ==========================================================================================================
    */

    /**
     * @param $value
     * @return array|mixed
     */
    public function getCustomerInfoAttribute($value)
    {
        return (!empty($value)) ? json_decode($value, true) : [];
    }

    /**
     * @param $value
     * @return array|mixed
     */
    public function getUserPerformedInfoAttribute($value)
    {
        return (!empty($value)) ? json_decode($value, true) : [];
    }

    /**
     * @param $value
     * @return array|mixed
     */
    public function getPaymentMethodInfoAttribute($value)
    {
        return (!empty($value)) ? json_decode($value, true) : [];
    }

    /**
     * @param $value
     * @return array|mixed
     */
    public function getOrderSourceInfoAttribute($value)
    {
        return (!empty($value)) ? json_decode($value, true) : [];
    }

    /**
     * @param $value
     * @return array|mixed
     */
    public function getCustomerContactInfoAttribute($value)
    {
        return (!empty($value)) ? json_decode($value, true) : [];
    }

    /**
     * @param $value
     * @return array|mixed
     */
    public function getOrderConditionsAttribute($value)
    {
        return (!empty($value)) ? json_decode($value, true) : [];
    }

    /**
     * @return string
     */
    public function getCreatedByInstanceAttribute() {
        return $this->createdByUser;
    }

    /**
     * With Functions
     */
    /**
     * Get the gallery for the product.
     */
    public function products()
    {
        return $this->hasMany(ProductsInOrder::class);
    }
}
