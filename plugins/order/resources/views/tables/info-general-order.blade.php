<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-10
 * Time: 07:47
 */
?>
<table class="table table-info-general-order">
    <tbody>
        <tr>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.customer_name') }}: </span>
                <span class="sub-content">{{ $order->customer_name }}</span>
            </td>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.user_performed') }}: </span>
                <span class="sub-content">{{ !empty($order->user_performed_info['full_name']) ? $order->user_performed_info['full_name'] : '' }}</span>
            </td>
        </tr>
        <tr>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.customer_address') }}: </span>
                <span class="sub-content">{{ $order->customer_address }}</span>
            </td>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.group_user') }}: </span>
                <span class="sub-content">{{ (!empty($order->user_performed_info['super_user'])) ? \Core\User\Contracts\UserConfigs::SUPER_ADMIN : (!empty($order->user_performed_info['get_role'][0]['name']) ? $order->user_performed_info['get_role'][0]['name'] : '') }}</span>
            </td>
        </tr>
        <tr>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.customer_phone') }}: </span>
                <span class="sub-content">{{ $order->customer_phone }}</span>
            </td>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.order_date') }}: </span>
                <span class="sub-content">{{ $order->order_date }}</span>
            </td>
        </tr>
        <tr>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.customer_contact') }}: </span>
                <span class="sub-content">{{ !empty($order->customer_contact_info['full_name']) ? $order->customer_contact_info['full_name'] : "" }}</span>
            </td>
            <td class="width-50-per">
                <span class="title-sub-content text-bold-700">{{ trans('plugins-order::order.form.payment_method') }}: </span>
                <span class="sub-content">{{ !empty($order->payment_method_info['name']) ? $order->payment_method_info['name'] : ""}}</span>
            </td>
        </tr>
    </tbody>
</table>
