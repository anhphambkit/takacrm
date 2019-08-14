@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.tenant.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, TENANT_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-tenant::tenant.create') }}</h4>
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
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('host_name')) has-error @endif">
                                        <label for="name">{{ trans('plugins-tenant::tenant.form.tenancy_name') }}</label>
                                        {!! Form::text('host_name', old('host_name'), ['class' => 'form-control', 'id' => 'host_name', 'placeholder' => trans('plugins-tenant::tenant.form.tenancy_name'), 'data-counter' => 120]) !!}
                                        {!! Form::error('host_name', $errors) !!}
                                    </div>
                                </div>
                                {{--<div class="row">--}}
                                    {{--<div class="form-group col-md-6 mb-2 @if ($errors->has('redirect_to')) has-error @endif">--}}
                                        {{--<label for="redirect_to">{{ trans('plugins-tenant::tenant.form.redirect_to') }}</label>--}}
                                        {{--{!! Form::text('redirect_to', old('redirect_to'), ['class' => 'form-control', 'id' => 'redirect_to', 'placeholder' => trans('plugins-tenant::tenant.form.redirect_to'), 'data-counter' => 250]) !!}--}}
                                        {{--{!! Form::error('redirect_to', $errors) !!}--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group col-md-6 mb-2 @if ($errors->has('force_https')) has-error @endif">--}}
                                        {{--<label for="force_https">{{ trans('plugins-tenant::tenant.form.force_https') }}</label>--}}
                                        {{--{!! Form::onOffPretty('force_https', old('force_https'), ['id' => 'force_https' ], 'force_https-switch checkbox-large') !!}--}}
                                        {{--{!! Form::error('force_https', $errors) !!}--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, TENANT_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')
                @php do_action(BASE_ACTION_META_BOXES, TENANT_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, TENANT_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-tenant::tenant.user_info') }}</h4>
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
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('username')) has-error @endif">
                                        <label for="name">{{ trans('plugins-tenant::tenant.form.username') }}</label>
                                        {!! Form::text('username', old('username'), ['class' => 'form-control', 'id' => 'username', 'placeholder' => trans('plugins-tenant::tenant.form.username'), 'data-counter' => 120]) !!}
                                        {!! Form::error('username', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('password')) has-error @endif">
                                        <label for="name">{{ trans('plugins-tenant::tenant.form.password') }}</label>
                                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'data-counter' => 60]) !!}
                                        <div class="pwstrength_viewport_progress"></div>
                                        {!! Form::error('password', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('email')) has-error @endif">
                                        <label for="name">{{ trans('plugins-tenant::tenant.form.email') }}</label>
                                        {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'placeholder' => trans('plugins-tenant::tenant.form.email'), 'data-counter' => 120]) !!}
                                        {!! Form::error('email', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('first_name')) has-error @endif">
                                        <label for="first_name">{{ trans('plugins-tenant::tenant.form.first_name') }}</label>
                                        {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => trans('plugins-tenant::tenant.form.first_name'), 'data-counter' => 250]) !!}
                                        {!! Form::error('first_name', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('last_name')) has-error @endif">
                                        <label for="last_name">{{ trans('plugins-tenant::tenant.form.last_name') }}</label>
                                        {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'id' => 'last_name', 'placeholder' => trans('plugins-tenant::tenant.form.last_name'), 'data-counter' => 250]) !!}
                                        {!! Form::error('last_name', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, TENANT_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@stop

{{--@if($hostname->force_https && empty($hostname->redirect_to))--}}
{{--return 301 https://{{ $hostname->fqdn }}:{{ array_get($config, 'ports.https', 443) }}$request_uri;--}}
{{--@elseif($hostname->redirect_to)--}}
{{--return 301 {{ $hostname->redirect_to }}$request_uri;--}}
{{--@endif--}}