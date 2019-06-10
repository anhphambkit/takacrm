<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-10
 * Time: 09:34
 */
?>
<table class="table table-products-order-detail">
    <thead>
    <tr>
        <th class="width-2-per">#</th>
        <th class="width-40-per">{{ trans('plugins-order::order.table.product') }}</th>
        <th class="width-7-per">{{ trans('plugins-order::order.table.product_code') }}</th>
        <th class="width-7-per">{{ trans('plugins-order::order.table.unit') }}</th>
        <th class="width-4-per text-right">{{ trans('plugins-order::order.table.quantity') }}</th>
        <th class="width-15-per text-right">{{ trans('plugins-order::order.table.price') }}</th>
        <th class="width-2-per text-right">{{ trans('plugins-order::order.table.vat_percent') }}</th>
        <th class="width-2-per text-right">{{ trans('plugins-order::order.table.discount_percent') }}</th>
        <th class="width-10-per text-right">{{ trans('plugins-order::order.table.discount') }}</th>
        <th class="width-15-per text-right">{{ trans('plugins-order::order.table.total_price') }}</th>
    </tr>
    </thead>
    <tbody class="table-body-order-detail-product">
    @foreach($order->products as $index => $orderProduct)
        <tr class="row-product-order row-product-order-{{ $index }}" id="row-product-order-detail-{{ $index }}" data-product-index="{{ $index }}">
            <td scope="row">{{ $index + 1 }}</td>
            <td class="product-basic-info product-basic-info-{{ $index }}" id="product-basic-info-{{ $index }}">
                {{ $orderProduct->name }}
            </td>
            <td>
                {{ $orderProduct->sku }}
            </td>
            <td>
                {{ $orderProduct->unit_name }}
            </td>
            <td class="text-right">
                {{ $orderProduct->quantity }}
            </td>
            <td class="text-right">
                {{ $orderProduct->retail_price }}
            </td>
            <td class="text-right">
                {{ $orderProduct->vat }}
            </td>
            <td class="text-right">
                {{ $orderProduct->discount_percent }}
            </td>
            <td class="text-right">
                {{ $orderProduct->discount }}
            </td>
            <td class="text-right">
                {{ $orderProduct->total_price }}
            </td>
        </tr>
    @endforeach
        <tr class="row-total-order">
            <td colspan="9" class="td-sub-title">
                {{ trans('plugins-order::order.table.sub_total') }}
            </td>
            <td class="text-right">
                {{ $order->sub_total }}
            </td>
        </tr>
        <tr class="row-total-order">
            <td colspan="9" class="td-sub-title">
                {{ trans('plugins-order::order.table.discount') }} {{ ($order->is_discount_after_tax) ? strtolower(trans('plugins-order::order.after_tax')) : strtolower(trans('plugins-order::order.before_tax')) }} {{ $order->fees_ship_percent }}%
            </td>
            <td class="text-right">
                {{ $order->fees_ship }}
            </td>
        </tr>
        <tr class="row-total-order">
            <td colspan="9" class="td-sub-title">
                {{ trans('plugins-order::order.vat') }} {{ $order->fees_vat_percent }}%
            </td>
            <td class="text-right">
                {{ $order->fees_vat }}
            </td>
        </tr>
        <tr class="row-total-order">
            <td colspan="9" class="td-sub-title">
                {{ trans('plugins-order::order.shipping_fee') }} {{ $order->fees_shipping_percent }}%
            </td>
            <td class="text-right">
                {{ $order->fees_shipping }}
            </td>
        </tr>
        <tr class="row-total-order">
            <td colspan="9" class="td-sub-title">
                {{ trans('plugins-order::order.installation_fee') }} {{ $order->fees_installation_percent }}%
            </td>
            <td class="text-right">
                {{ $order->fees_installation }}
            </td>
        </tr>
        <tr class="row-total-order">
            <td colspan="9" class="td-sub-title">
                {{ trans('plugins-order::order.table.total') }}
            </td>
            <td class="text-right">
                {{ $order->total_order }}
            </td>
        </tr>
    </tbody>
</table>
