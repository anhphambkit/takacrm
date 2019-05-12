@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.customer.group_customer.edit', $customerGroup->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, CUSTOMER_MODULE_SCREEN_NAME, request(), $customerGroup) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::group-customer.edit') }}</h4>
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
                                        {!! Form::text('name', $customerGroup->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('parent_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('core-base::forms.parent_category') }}</label>
                                        {!! Form::select('parent_id', $customerGroups, $customerGroup->parent_id, ['class' => 'select2-placeholder-multiple form-control group-customer-list', "id" => "select-group-customer-list" ]) !!}
                                        {!! Form::error('parent_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('order')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.order') }}</label>
                                        {!! Form::number('order', $customerGroup->order, ['class' => 'form-control', 'id' => 'order', 'type' => 'number', 'min' => 0, 'placeholder' => trans('core-base::forms.name_placeholder')]) !!}
                                        {!! Form::error('order', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.description') }}</label>
                                        {!! render_editor('description', $customerGroup->description, true) !!}
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status', ['selected' => $customerGroup->status])
                @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'top', $customerGroup) @endphp
                @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'side', $customerGroup) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop