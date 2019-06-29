<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-13
 * Time: 23:50
 */
?>
<table class="table table-product table-product-landing-page">
    <thead>
    <tr>
        <th class="width-40-per">{{ trans('plugins-product::product.product_name') }}</th>
        <th class="width-18-per">{{ trans('plugins-product::product.product_code') }}</th>
        <th class="width-10-per text-right">{{ trans('plugins-product::product.quantity') }}</th>
        <th class="width-16-per text-right">{{ trans('plugins-product::product.online_price') }}</th>
        <th class="width-16-per text-right">{{ trans('plugins-product::product.online_discount') }}</th>
    </tr>
    </thead>
    <tbody class="table-body-order-detail-product">
        <tr class="row-product-order row-product-landing-page" id="row-product-landing-page">
            <td>
                {{ $product->name }}
                {!! Form::number('order_products[0][id]', $product->id, ['class' => 'hidden form-control', 'id' => 'product-id', 'type' => 'number', 'min' => 0]) !!}
            </td>
            <td>
                {{ $product->sku }}
            </td>
            <td class="text-right">
                {!! Form::number('order_products[0][quantity]', !empty(old('quantity')) ? old('quantity') : 1, ['class' => 'form-control', 'id' => 'product-quantity', 'type' => 'number', 'min' => 1]) !!}
            </td>
            <td class="text-right online-price">
                {{ $product->online_price ? $product->online_price : trans('core-base::base.contact') }}
                {!! Form::number('order_products[0][retail_price]', (int)$product->online_price, ['class' => 'hidden form-control', 'id' => 'retail_price', 'type' => 'number', 'min' => 0]) !!}
            </td>
            <td class="text-right online-discount">
                {{ $product->online_discount ? $product->online_discount . "(%)" : trans('core-base::base.contact') }}
                {!! Form::text('order_products[0][discount_percent]', (float)$product->online_discount, ['class' => 'hidden form-control', 'id' => 'online_discount']) !!}
            </td>
        </tr>
        <tr class="row-product-total row-total-product-landing-page" id="row-product-landing-page">
            <td colspan="4">
                {{ trans('plugins-order::order.form.total_order') }}
            </td>
            <td class="text-right td-total-price-product">
                <span class="total-price-product">{{ $product->online_price ? abs($product->online_price*((100-(float)$product->online_discount)/100)) : trans('core-base::base.contact') }}</span>
                {!! Form::number('order_products[0][total_price]', (int)abs((int)$product->online_price*((100-(float)$product->online_discount)/100)), ['class' => 'hidden form-control', 'id' => 'total_price', 'type' => 'number', 'min' => 0]) !!}
                {!! Form::number('sub_total', (int)abs((int)$product->online_price*((100-(float)$product->online_discount)/100)), ['class' => 'hidden form-control', 'id' => 'sub_total', 'type' => 'number', 'min' => 0]) !!}
                {!! Form::number('total_order', (int)abs((int)$product->online_price*((100-(float)$product->online_discount)/100)), ['class' => 'hidden form-control', 'id' => 'total_order', 'type' => 'number', 'min' => 0]) !!}
            </td>
        </tr>
    </tbody>
</table>
