@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.product.look_book.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::look-book.create') }}</h4>
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
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('type_layout')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::look-book.form.type_layout') }}</label>
                                        {!! Form::select('type_layout', $typeLayouts, old('type_layout'), ['class' => 'select2-placeholder-multiple form-control type-layout-list', "id" => "select-type-layout-list" ]) !!}
                                        {!! Form::error('type_layout', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 is-main-form">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::look-book.form.is_main') }}</label>
                                        {!! Form::onOffPretty('is_main', old('is_main'), ['id' => 'is_main' ], 'is-main-switch checkbox-large') !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-7 mb-2 @if ($errors->has('image')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::look-book.form.look_book_image') }}</label>
                                        {!! Form::lookBookImage('image', old('image'), (!empty(old('tag')) ? old('tag') : []), old('type_layout')) !!}
                                    </div>
                                </div>
                                @include('plugins-product::look-book.partials.list-space-business-selected')
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('short_description')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.short_description') }}</label>
                                        {!! render_editor('short_description', old('short_description'), true) !!}
                                        {!! Form::error('short_description', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.description') }}</label>
                                        {!! render_editor('description', old('description'), true) !!}
                                        {!! Form::error('description', $errors) !!}
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
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
    @include('plugins-product::look-book.partials.modal-look-book-tag')
@stop

@section('variable-scripts')
    <script>
        const API = {
            GET_PRODUCTS_BY_CATEGORY : "{{ route('ajax.admin.get_products_by_category') }}",
            GET_SPACES_BY_BUSINESS_TYPE : "{{ route('ajax.admin.get_spaces_by_business_type') }}",
            GET_ALL_SPACES : "{{ route('ajax.admin.get_all_spaces') }}",
            GET_DEFAULT_BUSINESS_TYPE : "{{ route('ajax.admin.get_default_business_type') }}",
        };
        const START_INDEX = 0;
        const BUSINESS_SPACE_INDEX = 1;
        const ALL_SPACE_INDEX = 1;
        const ALL_SPACES = {!! json_encode($spaces) !!};
    </script>
@stop