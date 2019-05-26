@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.custom-attributes.entity.edit', 'typeEntity' => $typeEntity, $customAttribute->id ]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, request(), $customAttribute) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-custom-attributes::custom-attributes.edit') }}</h4>
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
                                        {!! Form::text('name', empty(old('name')) ? $customAttribute->name : old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group hidden col-md-3 mb-2 @if ($errors->has('type_entity')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-custom-attributes::custom-attributes.form.type_entity') }}</label>
                                        {!! Form::select('type_entity', $typeEntities, empty(old('type_entity')) ? $customAttribute->type_entity : old('type_entity'), ['class' => 'select2-placeholder-multiple form-control type-entity-list', "id" => "select-type-entity-list" ]) !!}
                                        {!! Form::error('type_entity', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 @if ($errors->has('type_render')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-custom-attributes::custom-attributes.form.type_render') }}</label>
                                        {!! Form::select('type_render', $typeRenders, empty(old('type_render')) ? $customAttribute->type_render : old('type_render'), ['class' => 'select2-placeholder-multiple form-control type-render-list', "id" => "select-type-render-list" ]) !!}
                                        {!! Form::error('type_render', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 is-main-form">
                                        <label class="control-label required" for="role">{{ trans('plugins-custom-attributes::custom-attributes.form.is_required') }}</label>
                                        {!! Form::onOffPretty('is_required', empty(old('is_required')) ? $customAttribute->is_required : old('is_required'), ['id' => 'is_required' ], 'is-main-switch checkbox-large') !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 is-main-form">
                                        <label class="control-label required" for="role">{{ trans('plugins-custom-attributes::custom-attributes.form.is_unique') }}</label>
                                        {!! Form::onOffPretty('is_unique', empty(old('is_unique')) ? $customAttribute->is_unique : old('is_unique'), ['id' => 'is_unique' ], 'is-main-switch checkbox-large') !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.description') }}</label>
                                        {!! render_editor('description', empty(old('description')) ? $customAttribute->description : old('description'), true) !!}
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status', ['selected' => $customAttribute->status])
                @php do_action(BASE_ACTION_META_BOXES, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, 'top', $customAttribute) @endphp
                @php do_action(BASE_ACTION_META_BOXES, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME, 'side', $customAttribute) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop