@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.order.source.method.edit', $sourceOrder->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, ORDER_MODULE_SCREEN_NAME, request(), $sourceOrder) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::source.edit') }}</h4>
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
                                        {!! Form::text('name', $sourceOrder->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="name">{{ trans('plugins-order::source.form.description') }}</label>
                                        {!! Form::textarea('description', (!empty(old('description')) ? old('description') : $sourceOrder->description), ['class' => 'form-control description-source', 'id' => 'description-source']) !!}
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status', ['selected' => $sourceOrder->status])
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'top', $sourceOrder) @endphp
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'side', $sourceOrder) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop