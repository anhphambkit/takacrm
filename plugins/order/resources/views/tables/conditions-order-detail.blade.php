<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-10
 * Time: 21:41
 */
?>
<div class="conditions-order-detail">
    <h4 class="text-bold-600">{{ trans('plugins-order::order.condition_order') }}</h4>
    <hr />
    <div class="conditions-order">
        @foreach($order->order_conditions as $indexCondition => $order->order_condition)
            <div class="order-condition">
                {{ $indexCondition }}. {{ $order->order_condition }}
            </div>
        @endforeach
    </div>
</div>
