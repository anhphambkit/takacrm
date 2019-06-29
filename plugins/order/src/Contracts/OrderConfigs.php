<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 10:45
 */

namespace Plugins\Order\Contracts;


interface OrderConfigs
{
    const GUEST                             = 'Guest';
    const ORDER_CODE_DEFAULT                = 'ORDER';
    const STATUS_ORDER_TYPE                = 'ORDER STATUS';
    const STATUS_ORDER_NEW                = 'New';
    const STATUS_ORDER_COMPLETED                = 'Completed';
    const STATUS_ORDER_CANCELLED                = 'Cancelled';

    const STATUS_PAYMENT_ORDER_TYPE                = 'PAYMENT ORDER STATUS';
    const STATUS_PAYMENT_ORDER_PAID                = 'Paid';
    const STATUS_PAYMENT_ORDER_NOT_PAID                = 'Not Paid';
}