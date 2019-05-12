<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:34
 */
?>
<div class="card log-info-customer">
    <div class="card-header">
        <h4 class="card-title" id="relation-customer-info">{{ trans('plugins-customer::customer.log_info') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collpase show">
        <div class="card-body">
            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.created_by') }}:
                </span>
                <span class="value-info">
                    {{ $customer->createdByUser ? $customer->createdByUser->getFullName() : "" }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.created_at') }}:
                </span>
                <span class="value-info">
                    {{ $customer->created_at }}
                </span>
            </div>
        </div>
    </div>
</div>

