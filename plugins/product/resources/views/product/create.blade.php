@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.product.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.create') }}</h4>
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
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.name') }}</label>
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('sku')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.sku') }}</label>
                                        {!! Form::text('sku', old('sku'), ['class' => 'form-control', 'id' => 'sku', 'placeholder' => trans('plugins-product::product.form.sku_placeholder'), 'data-counter' => 2]) !!}
                                        {!! Form::error('sku', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('category_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('core-base::forms.parent_category') }}</label>
                                        {!! Form::select('category_id[]', $categories, null, ['class' => 'select2-placeholder-multiple form-control category-list', "id" => "select-category-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('category_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('manufacturer_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.manufacturer') }}</label>
                                        {!! Form::select('manufacturer_id', $manufacturer, null, ['class' => 'select2-placeholder-multiple form-control manufacturer-list', "id" => "select-manufacturer-list" ]) !!}
                                        {!! Form::error('manufacturer_id', $errors) !!}
                                    </div>
                                </div>

                                {{-- Gallery--}}
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('image_gallery')) has-error @endif">
                                        <div class="widget meta-boxes gallery-box">
                                            <div class="widget-title">
                                                <h4><span class="required">{{ trans('plugins-product::product.form.image_gallery') }}</span></h4>
                                            </div>
                                            <div class="widget-body">
                                                {!! Form::mediaGallery('image_gallery', null) !!}
                                                {!! Form::error('image_gallery', $errors) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--End Gallery--}}
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('price')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.price') }}</label>
                                        {!! Form::number('price', old('price'), ['class' => 'form-control', 'id' => 'price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.price_placeholder')]) !!}
                                        {!! Form::error('price', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('sale_price')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.sale_price') }}</label>
                                        {!! Form::number('sale_price', old('sale_price'), ['class' => 'form-control', 'id' => 'sale_price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.sale_price_placeholder')]) !!}
                                        {!! Form::error('sale_price', $errors) !!}
                                    </div>
                                </div>
                                {{--category--}}

                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('short_description')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.short_description') }}</label>
                                        {!! render_editor('short_description', old('short_description'), true) !!}
                                        {!! Form::error('short_description', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('long_desc')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.long_desc') }}</label>
                                        {!! render_editor('long_desc', old('long_desc'), true) !!}
                                        {!! Form::error('long_desc', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')
                {{-- Image--}}
                <div class="widget meta-boxes">
                    <div class="widget-title">
                        <h4>
                            <span class="required @if ($errors->has('image_feature')) has-error @endif">
                                <label class="control-label required" for="role">{{ trans('plugins-product::product.form.image_feature') }}</label>
                            </span>
                        </h4>
                    </div>
                    <div class="widget-body">
                        {!! Form::mediaImage('image_feature', old('image_feature')) !!}
                        {!! Form::error('image_feature', $errors) !!}
                    </div>
                </div>
                {{--End Image--}}
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop