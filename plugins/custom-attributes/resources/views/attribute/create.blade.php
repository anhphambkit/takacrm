@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.custom-attributes.manage-attribute.create', $attributeId]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-custom-attributes::custom-attributes.create') }}</h4>
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
                                <div class="row hidden ">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('type_render')) has-error @endif">
                                        <label for="type_render">{{ trans('core-base::forms.type_render') }}</label>
                                        {!! Form::text('type_render', $typeRender, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.type_render'), 'data-counter' => 120]) !!}
                                        {!! Form::error('type_render', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    @if($typeRender === str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'))
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                            <label for="code">{{ trans('core-base::forms.value') }}</label>
                                            {!! Form::text('value', old('value'), ['class' => 'form-control minicolors color-picker-custom', 'id' => 'value',
                                                'placeholder' => trans('core-base::forms.value'), 'data-counter' => 10, 'data-control' => "hue"]) !!}
                                            {!! Form::error('value', $errors) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, 'advanced') @endphp
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
                                <label class="control-label required" for="role">{{ trans('core-base::forms.image_feature') }}</label>
                            </span>
                        </h4>
                    </div>
                    <div class="widget-body">
                        {!! Form::mediaImage('image_feature', old('image_feature'), [ 'action' => 'select-image' ]) !!}
                        {!! Form::error('image_feature', $errors) !!}
                    </div>
                </div>
                {{--End Image--}}
                @php do_action(BASE_ACTION_META_BOXES, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop