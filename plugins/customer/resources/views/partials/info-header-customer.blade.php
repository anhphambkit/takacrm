<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:04
 */
?>
<div class="card info-header-customer">
    <div class="card-header">
        <div class="card-title row" id="from-actions-bottom-right">
            <div class="col-md-4">
                <div class="customer-avatar-info">
                            <span class="customer-avatar">
                                <img src="{{ get_object_image($customer->avatar, 'mediumThumb') }}" alt="avatar">
                            </span>
                    <span class="customer-name-info">
                                    <span class="customer-name text-bold-700">{{ $customer->full_name }}</span>
                                    <span class="edit-action btn-action-customer-custom ">
                                        <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-icon btn-pure success tip" data-original-title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </span>
                                    <span class="delete-action btn-action-customer-custom ">
                                        <button type="button" class="btn btn-icon btn-pure danger deleteDialog tip" data-toggle="modal" data-section="{{ route('admin.customer.delete', $customer->id) }}" role="button" data-original-title="{{ __('Delete') }}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </span>
                            </span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12 border-left-lighten-3 border-left-success border-right-success border-right-lighten-3">
                                <div class="card-body">
                                                <span class="customer-avatar">
                                                    <img src="{{ get_object_image($customer->userManage ? $customer->userManage->profile_image : "", 'mediumThumb') }}" alt="avatar">
                                                </span>
                                    <span class="customer-manage-info">
                                                    <div class="customer-name text-bold-700">{{ $customer->userManage ? $customer->userManage->getFullName() : "" }}</div>
                                                    <div class="customer-name">{{ trans('plugins-customer::customer.manage_person') }}</div>
                                                </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-12 border-right-success border-right-lighten-3">
                                <div class="card-body text-center">
                                    <h1 class="display-4 "><i class="icon-user font-large-2"></i> 1</h1>
                                    <span class="">{{ trans('plugins-customer::customer.last_contact') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-12 border-right-success border-right-lighten-3">
                                <div class="card-body text-center">
                                    <h1 class="display-4 "><i class="icon-bulb font-large-2"></i> 3</h1>
                                    <span class="">{{ trans('plugins-customer::customer.reaction') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="card-body text-center">
                                    <h1 class="display-4 "><i class="icon-wallet font-large-2"></i> {{ $customer->value }}</h1>
                                    <span class="">{{ trans('plugins-customer::customer.form.value') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
