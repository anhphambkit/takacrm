@extends('layouts.master')
@section('content')
{!! Form::open() !!}
<div class="row">
	<div class="col-md-9">
	    <div class="card">
	        <div class="card-header">
	            <h4 class="card-title" id="from-actions-bottom-right">{{ __('Create User') }}</h4>
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
                		<h4 class="form-section"><i class="la la-eye"></i> About User</h4>
                		<div class="row">
	                        <div class="form-group col-md-6 mb-2 @if ($errors->has('first_name')) has-error @endif">
	                        	<label for="userinput1">Fist Name</label>
	                        	{!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'id' => 'first_name', 'data-counter' => 30, 'placeholder' => 'first name']) !!}
                            	{!! Form::error('first_name', $errors) !!}
	                        </div>
	                        <div class="form-group col-md-6 mb-2 @if ($errors->has('last_name')) has-error @endif">
	                        	<label for="userinput2">Last Name</label>
	                        	{!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'id' => 'last_name', 'data-counter' => 30, 'placeholder' => 'last name']) !!}
                            	{!! Form::error('last_name', $errors) !!}
	                        </div>
                        </div>
                        <div class="row">
	                        <div class="form-group col-md-6 mb-2 @if ($errors->has('username')) has-error @endif">
	                        	<label for="userinput3">Username</label>
	                        	 {!! Form::text('username', old('username'), ['class' => 'form-control', 'id' => 'username', 'data-counter' => 30, 'placeholder' => 'username']) !!}
                            	 {!! Form::error('username', $errors) !!}
	                        </div>
	                        <div class="form-group col-md-6 mb-2 @if ($errors->has('email')) has-error @endif">
	                        	<label for="userinput4">Email</label>
	                        	{!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'data-counter' => 30, 'placeholder' => 'email']) !!}
                            	{!! Form::error('email', $errors) !!}
	                        </div>
                        </div>

                        <div class="row">
	                        <div class="form-group col-md-6 mb-2 @if ($errors->has('password')) has-error @endif">
	                        	<label for="userinput3">Password</label>
	                        	 {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'data-counter' => 60, 'placeholder' => 'password']) !!}
                            	 <div class="pwstrength_viewport_progress"></div>
                            	 {!! Form::error('password', $errors) !!}
	                        </div>
	                        <div class="form-group col-md-6 mb-2">
	                        	<label for="userinput4">Re-type password</label>
	                        	{!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'data-counter' => 60, 'placeholder' => 're-type']) !!}
                            	{!! Form::error('password_confirmation', $errors) !!}
	                        </div>
                        </div>
                        <div class="form-group">
	                        <label class="control-label required" for="role">Role</label>
	                        {!! Form::select('role_id', $roles, null, ['class' => 'form-control roles-list']) !!}
	                    </div>
					</div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-3">
		@include('core-base::elements.form-actions')
		@include('core-base::elements.forms.status')
	</div>
</div>
{!! Form::close() !!}
@endsection