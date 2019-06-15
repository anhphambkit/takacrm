<?php

namespace Plugins\Order\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plugins\Customer\Models\Customer;
use Plugins\History\Models\ModelHistoryLog;

/**
 * Class Order
 * @package Plugins\Order\Models
 */
class Order extends ModelHistoryLog
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(ProductsInOrder::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->with('customerContacts');
    }

    ################### LOGGER ###########################

    /**
     * [$attributeDelete description]
     * @var array
     */
    protected $deleteAttributes = [
        'primaryIndex' => 'order_code',
    ];

    /**
     * [$createAttributes description]
     * @var array
     */
    protected $createAttributes = [
        'primaryIndex' => 'order_code',
    ];

    /**
     * [$ignoreLogAttributes description]
     * @var [type]
     */
    protected $ignoreLogAttributes = [
        'updated_at',
        'updated_by',
        'deleted_at',
        'user_performed_info',
        'payment_method_info',
        'order_source_info'
    ];

    /**
     * [$displayAttributes description]
     * @var [type]
     */
    protected $displayAttributes = [
        'order_code'                => 'Order Code',
        'customer_name'             => 'Customer Name',
        'customer_code'             => 'Customer Code',
        'customer_phone'            => 'Customer Phone',
        'customer_address'          => 'Customer Address',
        'customer_email'            => 'Customer Email',
        'customer_id'               => 'Customer Id',
        'customer_info'             => 'Customer Info',
        'user_performed_id'         => 'User Performed Id',
        'user_performed_info'       => 'User Performed Info',
        'order_date'                => 'Order Date',
        'payment_method_id'         => 'Payment Method Id',
        'payment_method_info'       => 'Payment Method Info',
        'order_source_id'           => 'Order Source Id',
        'order_source_info'         => 'Order Source Info',
        'lading_code'               => 'Lading Code',
        'campaign_id'               => 'Campaign Id',
        'customer_contact_id'       => 'Customer Contact Id',
        'customer_contact_info'     => 'Customer Contact Info',
        'order_file'                => 'Order File',
        'order_conditions'          => 'Order Conditions',
        'fees_ship'                 => 'Fees Ship',
        'fees_vat'                  => 'Fees Vat',
        'fees_shipping'             => 'Fees Shipping',
        'fees_installation'         => 'Fees Installation',
        'fees_ship_percent'         => 'Fees Ship Percent',
        'fees_vat_percent'          => 'Fees Vat Percent',
        'fees_shipping_percent'     => 'Fees Shipping Percent',
        'fees_installation_percent' => 'Fees Installation Percent',
        'is_discount_after_tax'     => 'Discount After Tax',
        'sale_order'                => 'Sale Order',
        'discount_order'            => 'Discount Order',
        'vat_order'                 => 'Vat Order',
        'sub_total'                 => 'Sub Total',
        'total_order'               => 'Total Order',
        'order_status'              => 'Order Status',
        'payment_status'            => 'Payment Status',
        'status'                    => 'Status'
    ];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $relationShipAttributes = [
        'customer_id' => [
            'mapTable'  => 'customers',
            'mapColumn' => 'id',
            'mapResult' => 'full_name'
        ],
        'order_status' => [
            'mapTable'  => 'references',
            'mapColumn' => 'id',
            'mapResult' => 'value'
        ],
        'payment_status' => [
            'mapTable'  => 'references',
            'mapColumn' => 'id',
            'mapResult' => 'value'
        ],
    ];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $jsonAttributes = [
        'order_conditions'
    ];

    /**
     * [$logBooleanAttributes description]
     * @var [type]
     */
    protected $logBooleanAttributes = [
        'status' => ['Activated', 'Disabled'],
    ];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $logTargetAttributes = [
        'target' => HISTORY_MODULE_ORDER,
        'primary' => 'id'
    ];
}
