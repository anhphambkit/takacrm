@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.product.manufacturer.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::manufacturer.create') }}</h4>
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
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('policy')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::manufacturer.form.policy') }}</label>
                                        {!! render_editor('policy', old('policy'), true) !!}
                                        {!! Form::error('policy', $errors) !!}
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
                            <span class="required @if ($errors->has('manufacturer_image')) has-error @endif">
                                <label class="control-label required" for="role">{{ trans('plugins-product::manufacturer.form.manufacturer_image') }}</label>
                            </span>
                        </h4>
                    </div>
                    <div class="widget-body">
                        {!! Form::mediaImage('manufacturer_image', old('manufacturer_image'), [ 'action' => 'select-image' ]) !!}
                        {!! Form::error('manufacturer_image', $errors) !!}
                    </div>
                </div>
                {{--End Image--}}
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop