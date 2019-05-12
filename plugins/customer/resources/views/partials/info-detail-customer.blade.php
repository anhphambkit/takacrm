<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 13:43
 */
?>
<div class="card detail-info-customer">
    <div class="card-header">
        <h4 class="card-title" id="relation-customer-info">{{ trans('plugins-customer::customer.form.customer_relation') }}</h4>
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
                    {{ trans('plugins-customer::customer.form.full_name') }}:
                </span>
                <span class="value-info">
                    {{ $customer->full_name }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.gender') }}:
                </span>
                <span class="value-info">
                    {{ $customer->gender }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.phone') }}:
                </span>
                <span class="value-info">
                    {{ $customer->phone }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.email') }}:
                </span>
                <span class="value-info">
                    {{ $customer->email }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.facebook') }}:
                </span>
                <span class="value-info">
                    {{ $customer->facebook }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.address') }}:
                </span>
                <span class="value-info">
                    {{ $customer->address }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.ward') }}:
                </span>
                <span class="value-info">
                    {{ $customer->ward }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.district') }}:
                </span>
                <span class="value-info">
                    {{ $customer->district }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.province_city') }}:
                </span>
                <span class="value-info">
                    {{ $customer->province_city }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.dob') }}:
                </span>
                <span class="value-info">
                    {{ $customer->dob }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.customer_code') }}:
                </span>
                <span class="value-info">
                    {{ $customer->customer_code }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.note') }}:
                </span>
                <span class="value-info">
                    {{ $customer->note }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.customer_relation') }}:
                </span>
                <span class="value-info">
                    @if($customer->customerRelationData)
                        <span class=minicolor-preview>
                           <span class="minicolor-square-box" style="background-color: {{ $customer->customerRelationData->color_code }};"></span>
                       </span>
                       <span class="customer-color-attr">{{$customer->customerRelationData->name}}</span>
                    @endif
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.customer_group') }}:
                </span>
                <span class="value-info">
                   {{ $customer->getCustomerGroupsDataRender() }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.jobs') }}:
                </span>
                <span class="value-info">
                   {{ $customer->getCustomerJobsDataRender() }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.customer_source') }}:
                </span>
                <span class="value-info">
                    {{ $customer->getCustomerSourcesDataRender() }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.website') }}:
                </span>
                <span class="value-info">
                    {{ $customer->website }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.fax') }}:
                </span>
                <span class="value-info">
                    {{ $customer->fax }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-customer::customer.form.tax_code') }}:
                </span>
                <span class="value-info">
                    {{ $customer->tax_code }}
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
