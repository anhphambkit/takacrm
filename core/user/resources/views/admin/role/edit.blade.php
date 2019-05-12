@extends('layouts.master')
@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="from-actions-top-bottom-center">{{ __('Edit Role') }}</h4>
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
                        {!! Form::open() !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                        <label for="eventInput1">{{ __('Role Name') }}</label>
                                        {!! Form::text('name', $role->name, ['class' => 'form-control', 'placeholder' => __('Name')]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>

                                @if($role->parent_id)
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('parent_id')) has-error @endif">
                                        <label class="control-label required" for="role">Parent</label>
                                        {!! Form::select('parent_id', $roles, $role->parent_id, ['class' => 'form-control roles-list']) !!}
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="form-group col-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="eventInput2">{{ __('Description') }}</label>
                                        {!! Form::textarea('description', $role->description, ['class' => 'form-control', 'rows' => 4, 'placeholder' => __('Description')]) !!}
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="widget form-group col-12 mb-2">
                                        <div class="widget-title">
                                            <h4>
                                                <i class="box_img_sale"></i><span> {{ __('Permissions') }}</span>
                                            </h4>
                                        </div>
                                        <div class="widget-body">
                                            @include('core-user::admin.role.role-permissions')
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="form-actions clearfix">
                                <div class="buttons-group float-right">
                                    <a href="{{ route('admin.role.index') }}" class="btn btn-light" id="cancelButton">{{ __('Cancel') }}</a>
                                    <input type="submit" value="{{ __('Update') }}" class="btn btn-info">
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection