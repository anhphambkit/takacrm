<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-10
 * Time: 07:30
 */
?>
<div class="card order-list-card">
    <div class="card-header">
        <h4 class="card-title" id="relation-order-info">{{ trans('plugins-order::order.general_info_order') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <h2 class="header-order text-center text-bold-600">{{ trans('plugins-order::order.order') }} - {{ $order->order_code }}</h2>
            @include('plugins-order::tables.info-general-order')
            @include('plugins-order::tables.product-order-detail-table')
            @include('plugins-order::tables.conditions-order-detail')
        </div>
    </div>
</div>
