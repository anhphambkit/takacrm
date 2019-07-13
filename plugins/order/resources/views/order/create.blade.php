@extends('layouts.master')
@section('content')
    @include('plugins-order::partials.form-quick-add-customer')
    {!! Form::open(['route' => 'admin.order.create']) !!}
    @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, ORDER_MODULE_SCREEN_NAME, request(), null) @endphp
    <div class="form-general-info form-order-crud">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::order.form.customer_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('customer_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-order::order.form.search_customer_on_system') }}</label>
                                        <div class="row">
                                            <div class="col-md-10 pr-0">
                                                {!! Form::select('customer_id', [], old('customer_id'), ['class' => 'custom-select select2-placeholder-single form-control customer-list', "id" => "select-customer-list" ]) !!}
                                            </div>
                                            <div class="col-md-2 pl-0">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#modQuickAddCustomer" type="button">
                                                    <i class="fa fa-plus m-0"></i>
                                                </button>
                                            </div>
                                        </div>
                                        {!! Form::error('customer_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('customer_contact_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-order::order.form.customer_contact') }}</label>
                                        {!! Form::select('customer_contact_id', [], old('customer_contact_id'), ['class' => 'custom-select select2-placeholder-single form-control customer-contact-list', "id" => "select-customer-contact-list" ]) !!}
                                        {!! Form::error('customer_contact_id', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('customer_name')) has-error @endif">
                                        <label for="customer_name">{{ trans('plugins-order::order.form.customer_name') }}</label>
                                        {!! Form::text('customer_name', old('customer_name'), ['class' => 'form-control', 'id' => 'customer_name', 'placeholder' => trans('plugins-order::order.form.customer_name'), 'readonly' => "readonly", 'data-counter' => 255]) !!}
                                        {!! Form::error('customer_name', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('customer_code')) has-error @endif">
                                        <label for="customer_code">{{ trans('plugins-order::order.form.customer_code') }}</label>
                                        {!! Form::text('customer_code', old('customer_code'), ['class' => 'form-control', 'id' => 'customer_code', 'placeholder' => trans('plugins-order::order.form.customer_code'), 'readonly' => "readonly", 'data-counter' => 255]) !!}
                                        {!! Form::error('customer_code', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('customer_phone')) has-error @endif">
                                        <label for="customer_phone">{{ trans('plugins-order::order.form.customer_phone') }}</label>
                                        {!! Form::text('customer_phone', old('customer_phone'), ['class' => 'form-control', 'id' => 'customer_phone', 'placeholder' => trans('plugins-order::order.form.customer_phone'), 'readonly' => "readonly", 'data-counter' => 50]) !!}
                                        {!! Form::error('customer_phone', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('customer_email')) has-error @endif">
                                        <label for="customer_email">{{ trans('plugins-order::order.form.customer_email') }}</label>
                                        {!! Form::text('customer_email', old('customer_email'), ['class' => 'form-control', 'id' => 'customer_email', 'placeholder' => trans('plugins-order::order.form.customer_email'), 'readonly' => "readonly", 'data-counter' => 120]) !!}
                                        {!! Form::error('customer_email', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_address')) has-error @endif">
                                        <label for="customer_address">{{ trans('plugins-order::order.form.customer_address') }}</label>
                                        {!! Form::text('customer_address', old('customer_address'), ['class' => 'form-control', 'id' => 'customer_address', 'readonly' => "readonly", 'placeholder' => trans('plugins-order::order.form.customer_address')]) !!}
                                        {!! Form::error('customer_address', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::order.form.order_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('user_performed_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-order::order.form.user_performed') }}</label>
                                        {!! Form::select('user_performed_id', $users, old('user_performed_id'), ['class' => 'custom-select select2-placeholder-single form-control user-performed-list', "id" => "select-user-performed-list" ]) !!}
                                        {!! Form::error('user_performed_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 @if ($errors->has('order_code')) has-error @endif">
                                        <label for="order_code">{{ trans('plugins-order::order.form.order_code') }}</label>
                                        {!! Form::text('order_code', old('order_code'), ['class' => 'form-control', 'id' => 'order_code', 'placeholder' => trans('plugins-order::order.form.order_code')]) !!}
                                        {!! Form::error('order_code', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 @if ($errors->has('lading_code')) has-error @endif">
                                        <label for="lading_code">{{ trans('plugins-order::order.form.lading_code') }}</label>
                                        {!! Form::text('lading_code', old('lading_code'), ['class' => 'form-control', 'id' => 'lading_code', 'placeholder' => trans('plugins-order::order.form.lading_code')]) !!}
                                        {!! Form::error('lading_code', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('payment_method_id')) has-error @endif">
                                        <label for="payment_method_id">{{ trans('plugins-order::order.form.payment_method') }}</label>
                                        {!! Form::select('payment_method_id', $paymentMethods, old('payment_method_id'), ['class' => 'custom-select select2-placeholder-single form-control payment-method-list', "id" => "select-payment-method-list" ]) !!}
                                        {!! Form::error('payment_method_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('order_source_id')) has-error @endif">
                                        <label for="order_source_id">{{ trans('plugins-order::order.form.order_source') }}</label>
                                        <div class="input-group">
                                            {!! Form::select('order_source_id', $orderSources, old('order_source_id'), ['class' => 'custom-select select2-placeholder-single form-control source-order-list', "id" => "select-source-order-list" ]) !!}
                                            <div class="input-group-append">
                                                <div class="dropdown">
                                                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-plus m-0"></i>
                                                  </button>
                                                  <div class="dropdown-menu dropdown-modal">
                                                    <div class="panel" id="pnQuickAddResource">
                                                        <div class="panel-body">
                                                            <label>@lang('plugins-order::order.form.order_source')</label>
                                                            <input type="text" name="name" id="resourceName" class="form-control"/>
                                                        </div>
                                                        <div class="panel-footer mt-1">
                                                            <button type="button" class="btn btn-primary btn-sm" id="btnAddResource">Thêm</button>
                                                            <button type="button" data-toggle="dismiss" class="btn btn-danger btn-sm mr5">Đóng</button>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::error('order_source_id', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('order_date')) has-error @endif">
                                        <label for="order_date">{{ trans('plugins-order::order.form.order_date') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <span class="far fa-calendar-alt"></span>
                                                </span>
                                            </div>
                                            {!! Form::text('order_date', old('order_date'), ['class' => 'form-control pickadate', 'id' => 'order_date', 'placeholder' => trans('plugins-order::order.form.order_date')]) !!}
                                        </div>
                                        {!! Form::error('order_date', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('campaign_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-order::order.form.campaign') }}</label>
                                        {!! Form::select('campaign_id', [], old('campaign_id'), ['class' => 'custom-select select2-placeholder-single form-control campaign-list', "contact" => "select-campaign-list" ]) !!}
                                        {!! Form::error('campaign_id', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{--Custom Attribute--}}
                @include('plugins-custom-attributes::partials.card-custom-attributes', [ 'classFieldWrapper' => 'form-group col-md-4 mb-2' ])
                {{--End Custom Attribute--}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::order.form.order_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2">
                                        <div class="table-responsive table-product-order">
                                            @include('plugins-order::tables.product-in-order')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::order.form.order_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2">
                                        <div class="table-responsive table-product-order">
                                            @include('plugins-order::tables.sale-product-table')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::order.form.order_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                @include('plugins-order::partials.order-conditions')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::order.form.order_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="sub_total">{{ trans('plugins-order::order.form.sub_total') }}</label>
                                    </div>
                                    <div class="form-group col-md-8 mb-2 @if ($errors->has('sub_total')) has-error @endif">
                                        {!! Form::text('sub_total', old('sub_total'), ['class' => 'form-control', 'id' => 'sub_total', 'placeholder' => trans('plugins-order::order.form.sub_total'), 'readonly' => "readonly"]) !!}
                                        {!! Form::error('sub_total', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="fees_ship_percent">{{ trans('plugins-order::order.form.fees_ship_percent') }}</label>
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_ship_percent')) has-error @endif">
                                        {!! Form::text('fees_ship_percent', old('fees_ship_percent'), ['class' => 'form-control order-fee-percent', 'id' => 'fees_ship_percent', 'placeholder' => trans('plugins-order::order.form.fees_ship_percent'), 'data-fee-name' => 'ship']) !!}
                                        {!! Form::error('fees_ship_percent', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_ship')) has-error @endif">
                                        {!! Form::text('fees_ship', old('fees_ship'), ['class' => 'form-control order-fee-price', 'id' => 'fees_ship', 'placeholder' => trans('plugins-order::order.form.fees_ship'), 'data-fee-name' => 'ship']) !!}
                                        {!! Form::error('fees_ship', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="fees_vat_percent">{{ trans('plugins-order::order.form.fees_vat_percent') }}</label>
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_vat_percent')) has-error @endif">
                                        {!! Form::text('fees_vat_percent', old('fees_vat_percent'), ['class' => 'form-control order-fee-percent', 'id' => 'fees_vat_percent', 'placeholder' => trans('plugins-order::order.form.fees_vat_percent'), 'data-fee-name' => 'vat']) !!}
                                        {!! Form::error('fees_vat_percent', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_vat')) has-error @endif">
                                        {!! Form::text('fees_vat', old('fees_vat'), ['class' => 'form-control order-fee-price', 'id' => 'fees_vat', 'placeholder' => trans('plugins-order::order.form.fees_vat'), 'data-fee-name' => 'vat']) !!}
                                        {!! Form::error('fees_vat', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="fees_shipping_percent">{{ trans('plugins-order::order.form.fees_shipping_percent') }}</label>
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_shipping_percent')) has-error @endif">
                                        {!! Form::text('fees_shipping_percent', old('fees_shipping_percent'), ['class' => 'form-control order-fee-percent', 'id' => 'fees_shipping_percent', 'placeholder' => trans('plugins-order::order.form.fees_shipping_percent'), 'data-fee-name' => 'shipping']) !!}
                                        {!! Form::error('fees_shipping_percent', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_shipping')) has-error @endif">
                                        {!! Form::text('fees_shipping', old('fees_shipping'), ['class' => 'form-control order-fee-price', 'id' => 'fees_shipping', 'placeholder' => trans('plugins-order::order.form.fees_shipping'), 'data-fee-name' => 'shipping']) !!}
                                        {!! Form::error('fees_shipping', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="fees_installation_percent">{{ trans('plugins-order::order.form.fees_installation_percent') }}</label>
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_installation_percent')) has-error @endif">
                                        {!! Form::text('fees_installation_percent', old('fees_installation_percent'), ['class' => 'form-control order-fee-percent', 'id' => 'fees_installation_percent', 'placeholder' => trans('plugins-order::order.form.fees_installation_percent'), 'data-fee-name' => 'installation']) !!}
                                        {!! Form::error('fees_installation_percent', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('fees_installation')) has-error @endif">
                                        {!! Form::text('fees_installation', old('fees_installation'), ['class' => 'form-control order-fee-price', 'id' => 'fees_installation', 'placeholder' => trans('plugins-order::order.form.fees_installation'), 'data-fee-name' => 'installation']) !!}
                                        {!! Form::error('fees_installation', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="is_discount_after_tax">{{ trans('plugins-order::order.form.is_discount_after_tax') }}</label>
                                    </div>
                                    <div class="form-group col-md-8 mb-2 @if ($errors->has('is_discount_after_tax')) has-error @endif">
                                        {!! Form::onOffPretty('is_discount_after_tax', old('is_discount_after_tax'), ['id' => 'is_discount_after_tax' ], 'is-feature-switch checkbox-large') !!}
                                        {!! Form::error('is_discount_after_tax', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="total_order">{{ trans('plugins-order::order.form.total_order') }}</label>
                                    </div>
                                    <div class="form-group col-md-8 mb-2 @if ($errors->has('total_order')) has-error @endif">
                                        {!! Form::text('total_order', old('total_order'), ['class' => 'form-control', 'id' => 'total_order', 'placeholder' => trans('plugins-order::order.form.total_order'), 'readonly' => "readonly", 'data-counter' => 50]) !!}
                                        {!! Form::error('total_order', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'advanced') @endphp
    </div>
    <div class="form-actions-area">
        <div class="row">
            <div class="col-md-12">
                @include('plugins-order::partials.form-crud-actions')
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('variable-scripts')
    <script>
        const API = {
            SEARCH_AJAX_CUSTOMER : "{{ route('ajax.admin.search_ajax_customer') }}",
            GET_INFO_WITH_CONTACT_OF_CUSTOMER : "{{ route('ajax.admin.get_info_with_contact_of_customer') }}",
            GET_INFO_PRICE_OF_PRODUCT : "{{ route('ajax.admin.get_info_price_product') }}",

            QUICK_ADD: {
                ORDER_RESOURCE: "{{ route('ajax.admin.order.quick_add_resource') }}"
            }
        };
        const PRODUCTS = {!! json_encode($products) !!};
    </script>
@stop
