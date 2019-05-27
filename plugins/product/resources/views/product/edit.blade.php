@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.product.edit', $product->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_SCREEN_NAME, request(), $product) @endphp
        <div class="row">
            <div class="col-md-9 row">
                <div class="col-md-6">
                    {{--General--}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.general') }}</h4>
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
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('name')) has-error @endif">
                                            <label for="name">{{ trans('core-base::forms.name') }}</label>
                                            {!! Form::text('name', !empty(old('name')) ? old('name') : $product->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name'), 'data-counter' => 120]) !!}
                                            {!! Form::error('name', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('sku')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.sku') }}</label>
                                            {!! Form::text('sku', !empty(old('sku')) ? old('sku') : $product->sku, ['class' => 'form-control', 'id' => 'sku', 'placeholder' => trans('plugins-product::product.form.sku'), 'data-counter' => 12]) !!}
                                            {!! Form::error('sku', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('category_id')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('core-base::forms.parent_category') }}</label>
                                            {!! Form::select('category_id', $categories, !empty(old('category_id')) ? old('category_id') : $product->category_id, ['class' => 'select2-placeholder-multiple form-control category-list', "id" => "select-category-list" ]) !!}
                                            {!! Form::error('category_id', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('manufacturer_id')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.manufacturer') }}</label>
                                            {!! Form::select('manufacturer_id', $manufacturer, !empty(old('manufacturer_id')) ? old('manufacturer_id') : $product->manufacturer_id, ['class' => 'select2-placeholder-multiple form-control manufacturer-list', "id" => "select-manufacturer-list" ]) !!}
                                            {!! Form::error('manufacturer_id', $errors) !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('unit_id')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.units') }}</label>
                                            {!! Form::select('unit_id', $units, !empty(old('unit_id')) ? old('unit_id') : $product->unit_id, ['class' => 'select2-placeholder-multiple form-control units-list', "id" => "select-units-list" ]) !!}
                                            {!! Form::error('unit_id', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('origin_id')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.origins') }}</label>
                                            {!! Form::select('origin_id', $origins, !empty(old('origin_id')) ? old('origin_id') : $product->origin_id, ['class' => 'select2-placeholder-multiple form-control origins-list', "id" => "select-origins-list" ]) !!}
                                            {!! Form::error('origin_id', $errors) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--End General--}}

                    {{--Description--}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.description_info') }}</h4>
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
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('short_description')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.short_description') }}</label>
                                            {!! render_editor('short_description', !empty(old('short_description')) ? old('short_description') : $product->short_description, true) !!}
                                            {!! Form::error('short_description', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('long_desc')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.long_desc') }}</label>
                                            {!! render_editor('long_desc', !empty(old('long_desc')) ? old('long_desc') : $product->long_desc, true) !!}
                                            {!! Form::error('long_desc', $errors) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--End Description--}}
                </div>
                <div class="col-md-6">
                    {{--Price--}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.price_info') }}</h4>
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
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('purchase_price')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.purchase_price') }}</label>
                                            {!! Form::number('purchase_price', !empty(old('purchase_price')) ? old('purchase_price') : $product->purchase_price, ['class' => 'form-control', 'id' => 'purchase_price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.purchase_price')]) !!}
                                            {!! Form::error('purchase_price', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('retail_price')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.retail_price') }}</label>
                                            {!! Form::number('retail_price', !empty(old('retail_price')) ? old('retail_price') : $product->retail_price, ['class' => 'form-control', 'id' => 'retail_price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.retail_price')]) !!}
                                            {!! Form::error('retail_price', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('wholesale_price')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.wholesale_price') }}</label>
                                            {!! Form::number('wholesale_price', !empty(old('wholesale_price')) ? old('wholesale_price') : $product->wholesale_price, ['class' => 'form-control', 'id' => 'wholesale_price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.wholesale_price')]) !!}
                                            {!! Form::error('wholesale_price', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('online_price')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.online_price') }}</label>
                                            {!! Form::number('online_price', !empty(old('online_price')) ? old('online_price') : $product->online_price, ['class' => 'form-control', 'id' => 'online_price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.online_price')]) !!}
                                            {!! Form::error('online_price', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('discount')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.discount') }}</label>
                                            {!! Form::number('discount', !empty(old('discount')) ? old('discount') : $product->discount, ['class' => 'form-control', 'id' => 'discount', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.discount')]) !!}
                                            {!! Form::error('discount', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('wholesale_discount')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.wholesale_discount') }}</label>
                                            {!! Form::number('wholesale_discount', !empty(old('wholesale_discount')) ? old('wholesale_discount') : $product->wholesale_discount, ['class' => 'form-control', 'id' => 'wholesale_discount', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.wholesale_discount')]) !!}
                                            {!! Form::error('wholesale_discount', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('purchase_discount')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.purchase_discount') }}</label>
                                            {!! Form::number('purchase_discount', !empty(old('purchase_discount')) ? old('purchase_discount') : $product->purchase_discount, ['class' => 'form-control', 'id' => 'purchase_discount', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.purchase_discount')]) !!}
                                            {!! Form::error('purchase_discount', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('online_discount')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.online_discount') }}</label>
                                            {!! Form::number('online_discount', !empty(old('online_discount')) ? old('online_discount') : $product->online_discount, ['class' => 'form-control', 'id' => 'online_discount', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.online_discount')]) !!}
                                            {!! Form::error('online_discount', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('vat')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-product::product.form.vat') }}</label>
                                            {!! Form::number('vat', !empty(old('vat')) ? old('vat') : $product->vat, ['class' => 'form-control', 'id' => 'vat', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.vat')]) !!}
                                            {!! Form::error('vat', $errors) !!}
                                        </div>
                                        <div class="form-group col-md-6 mb-2 @if ($errors->has('is_feature')) has-error @endif">
                                            <label for="name">{{ trans('plugins-product::product.form.is_feature') }}</label>
                                            {!! Form::onOffPretty('is_feature', !empty(old('is_feature')) ? old('is_feature') : $product->is_feature, ['id' => 'is_feature' ], 'is-feature-switch checkbox-large') !!}
                                            {!! Form::error('is_feature', $errors) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--End Price--}}

                    {{--Custom Attribute--}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.custom_attributes') }}</h4>
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
                                    @foreach($allProductCustomAttributes as $allProductCustomAttribute)
                                        <div class="row">
                                            @component('plugins-custom-attributes::components.custom-field')
                                                @slot('customAttributeEntity', $allProductCustomAttribute)
                                                @slot('entityId', $product->id)
                                            @endcomponent
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--End Custom Attribute--}}
                </div>
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'advanced') @endphp
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')
                {{-- Image--}}
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <div class="widget meta-boxes meta-box-custom">
                            <div class="widget-title">
                                <h4>
                                <span class="required @if ($errors->has('image_feature')) has-error @endif">
                                    <label class="control-label required" for="image_feature">{{ trans('plugins-product::product.form.image_feature') }}</label>
                                </span>
                                </h4>
                            </div>
                            <div class="widget-body">
                                {!! Form::mediaImage('image_feature', !empty(old('image_feature')) ? old('image_feature') : $product->image_feature) !!}
                                {!! Form::error('image_feature', $errors) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--End Image--}}

                {{-- Gallery--}}
                <div class="row">
                    <div class="form-group col-md-12 mb-2 @if ($errors->has('image_gallery')) has-error @endif">
                        <div class="widget meta-boxes gallery-box meta-box-custom">
                            <div class="widget-title">
                                <h4><span class="required">{{ trans('plugins-product::product.form.image_gallery') }}</span></h4>
                            </div>
                            <div class="widget-body">
                                {!! Form::mediaGallery('image_gallery', !empty(old('image_gallery')) ? old('image_gallery') : $galleries) !!}
                                {!! Form::error('image_gallery', $errors) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--End Gallery--}}

                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop