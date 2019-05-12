@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.product.coupon.create', 'id' => 'coupon-form']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_COUPON_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::coupon.create') }}</h4>
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
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('start_date')) has-error @endif">
                                        <label for="start_date">{{ trans('Start Date') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <span class="far fa-calendar-alt"></span>
                                                </span>
                                            </div>
                                            {!! Form::text('start_date', old('start_date'), ['class' => 'form-control pickadate', 'id' => 'start_date', 'placeholder' => '1993-03-23']) !!}
                                        </div>
                                        {!! Form::error('start_date', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('end_date')) has-error @endif">
                                        <label for="end_date">{{ trans('End Date') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <span class="far fa-calendar-alt"></span>
                                                </span>
                                            </div>
                                            {!! Form::text('end_date', old('end_date'), ['class' => 'form-control pickadate', 'id' => 'end_date', 'placeholder' => '1993-03-23']) !!}
                                        </div>
                                        {!! Form::error('end_date', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('number')) has-error @endif">
                                        <label for="number">{{ trans('Numbers use') }}</label>
                                        {!! Form::text('number', old('number',1), ['class' => 'form-control mask-number-mask-input-discount', 'id' => 'number', 'placeholder' => trans('Numbers'), 'data-counter' => 120]) !!}
                                        {!! Form::error('number', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('number_coupon')) has-error @endif">
                                        <label for="number_coupon">{{ trans('Numbers Coupon') }}</label>
                                        {!! Form::text('number_coupon', old('number',1), ['class' => 'form-control mask-number-mask-input-discount', 'id' => 'number_coupon', 'placeholder' => trans('Numbers'), 'data-counter' => 120]) !!}
                                        {!! Form::error('number_coupon', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('product_category')) has-error @endif">
                                        <label class="control-label required" for="role">Product Category</label>
                                        {!! Form::select('product_category', $categories, null, ['class' => 'form-control', 'id' => 'product_category']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.name') }}</label>
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-6">
                                        <label class="control-label required" for="role">Apply All Categories</label>
                                        {!! Form::onOffPretty('is_all_product', old('is_all_product'), ['id' => 'is_all_product']) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="number">{{ trans('Coupon Type') }}</label>
                                        <div class="clearfix"></div>
                                        {!! Form::radioPretty('coupon_type', old('coupon_type'), 'Money', ['icon' => 'fas fa-dollar-sign']) !!}
                                        {!! Form::radioPretty('coupon_type', old('coupon_type'), 'Percent',['icon' => 'fas fa-percent'], 1) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4 @if ($errors->has('coupon_value')) has-error @endif">
                                        <label for="coupon_value">{{ trans('Coupon Value') }}</label>
                                        {!! Form::text('coupon_value', old('coupon_value'), ['class' => 'form-control', 'id' => 'coupon_value', 'placeholder' => trans('Numbers'), 'data-counter' => 120]) !!}
                                        {!! Form::error('coupon_value', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_COUPON_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_COUPON_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_COUPON_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop

@push('js-stack')
    <script>
        var changeUI = function(checked){
            if (checked) {
                $('#product_category').closest('.form-group').css("display","none");
                $('#number_coupon').closest('.form-group').removeClass('col-md-6').addClass('col-md-12');
                $('#product_category').val(0);
            } else {
                $('#number_coupon').closest('.form-group').removeClass('col-md-12').addClass('col-md-6');
                $('#product_category').closest('.form-group').css("display","block");
            }
        }

        $("#coupon-form").submit(function() {
            $('#coupon_value').unmask();
        });

        var changeCouponValue = function(type){
            $('#coupon_value').unmask();
            var regex = '00 %';
            if(!type) regex = '#,##0 $';
            $('#coupon_value').mask(regex,{
                reverse: true    
            });
        }

        $(document).ready(function(){

            const is_all_product = document.getElementById('is_all_product')
            is_all_product.addEventListener('change', (event) => {
                changeUI(event.target.checked)
            })
            changeUI(is_all_product.checked);

            var couponType = $('input[name="coupon_type"]:checked').val();
            changeCouponValue(parseInt(couponType));

            $(document).on('click', '[name="coupon_type"]', function () {
                $('#coupon_value').val('');
                lastSelected = $(this).val();
                changeCouponValue(parseInt(lastSelected));
            });
        })
    </script>
@endpush