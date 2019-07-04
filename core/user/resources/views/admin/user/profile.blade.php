@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="row match-height">
			<div class="col-lg-4 col-md-4 col-sm-12 crop-avatar">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{ __('User Avatar') }}</h4>
					</div>
					<div class="card-body text-center mt-element-card mt-card-round mt-element-overlay">
                        <div class="profile-userpic mt-card-item">
                            <div class="avatar-view mt-card-avatar mt-overlay-1">
                                <img src="{{ url($user->getProfileImage()) }}" class="img-responsive" alt="avatar" h>
                                <div class="mt-overlay">
                                    <ul class="mt-info">
                                        <li>
                                            <a class="btn default btn-outline" href="javascript:;">
                                            	<i class="far fa-edit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                            	<h3 class="mt-card-name">{{ $user->getFullName() }}</h3>
                                <p class="mt-card-desc font-grey-mint">{{ $user->job_position }}</p>
							    <div class="text-center">
							        <a href="{{ $user->facebook }}" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="la la-facebook"></span></a>
							        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="la la-twitter"></span></a>
							        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span class="la la-linkedin font-medium-4"></span></a>
							        <a href="{{ $user->github }}" class="btn btn-social-icon mr-1 mb-1 btn-outline-github"><span class="la la-github font-medium-4"></span></a>
							    </div>
							</div>
                        </div>
					</div>
				</div>
				@include("core-user::partials.cropper-modal")
			</div>

			<div class="col-lg-8 col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{ __('User Profile') }}</h4>
					</div>
					<div class="card-content">
						<div class="card-body">
							<ul class="nav nav-tabs nav-justified">
								<li class="nav-item">
									<a class="nav-link active" id="tab-user-profile" data-toggle="tab" href="#user-profile" aria-controls="user-profile" aria-expanded="true">{{ __('Personal Info') }}</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab-user-password" data-toggle="tab" href="#user-password" aria-controls="user-password" aria-expanded="false">{{ __('Change Password') }}</a>
								</li>
							</ul>
							<div class="tab-content px-1 pt-1">
								<div role="tabpanel" class="tab-pane active" id="user-profile" aria-labelledby="tab-user-profile" aria-expanded="true">
									{!! Form::open(['route' => ['admin.user.update-profile', $user->id]]) !!}
										<div class="form-body">
											<h4 class="form-section"><i class="la la-eye"></i> About User</h4>
					                		<div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('first_name')) has-error @endif">
						                        	<label for="userinput1">First Name</label>
						                        	{!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'first name', 'data-counter' => 60]) !!}
					                            	{!! Form::error('first_name', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('last_name')) has-error @endif">
						                        	<label for="userinput2">Last Name</label>
						                        	{!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'id' => 'last_name', 'placeholder' => 'Smith', 'data-counter' => 60]) !!}
					                            	{!! Form::error('last_name', $errors) !!}
						                        </div>
					                        </div>
					                        <div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('username')) has-error @endif">
						                        	<label for="userinput3">Username</label>
						                        	 {!! Form::text('username', $user->username, ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Username', 'data-counter' => 30]) !!}
					                            	 {!! Form::error('username', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('email')) has-error @endif">
						                        	<label for="userinput4">Email</label>
						                        	{!! Form::text('email', $user->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'contact@example.com', 'data-counter' => 60]) !!}
					                            	{!! Form::error('email', $errors) !!}
						                        </div>
					                        </div>

					                        <div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('address')) has-error @endif">
						                        	<label for="userinput1">Address</label>
						                        	{!! Form::text('address', $user->address, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Address', 'data-counter' => 255]) !!}
					                            	{!! Form::error('address', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('secondary_address')) has-error @endif">
						                        	<label for="userinput2">Secondary Address</label>
						                        	{!! Form::text('secondary_address', $user->secondary_address, ['class' => 'form-control', 'id' => 'secondary_address', 'placeholder' => 'Address', 'data-counter' => 255]) !!}
					                            	{!! Form::error('secondary_address', $errors) !!}
						                        </div>
					                        </div>
					                        <div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('dob')) has-error @endif">
						                        	<label for="userinput3">Day of birth</label>
						                        	 {!! Form::text('dob', $user->dob, ['class' => 'form-control datepicker', 'id' => 'dob', 'placeholder' => '1993-03-23', 'data-counter' => 30]) !!}
					                            	 {!! Form::error('dob', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('job_position')) has-error @endif">
						                        	<label for="userinput4">Job</label>
						                        	{!! Form::text('job_position', $user->job_position, ['class' => 'form-control', 'id' => 'job_position', 'placeholder' => 'PHP Developer', 'data-counter' => 255]) !!}
					                            	{!! Form::error('job_position', $errors) !!}
						                        </div>
					                        </div>

					                        <div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('phone')) has-error @endif">
						                        	<label for="userinput3">Phone</label>
						                        	 {!! Form::text('phone', $user->phone, ['class' => 'form-control us-phone-mask-input', 'id' => 'phone', 'data-counter' => 15, 'placeholder' => '(123) 456-7890']) !!}
					                            	 {!! Form::error('phone', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('secondary_phone')) has-error @endif">
						                        	<label for="userinput4">Secondary Phone</label>
						                        	{!! Form::text('secondary_phone', $user->secondary_phone, ['class' => 'form-control us-phone-mask-input', 'id' => 'secondary_phone', 'data-counter' => 15, 'placeholder' => '(123) 456-7890']) !!}
					                            	{!! Form::error('secondary_phone', $errors) !!}
						                        </div>
					                        </div>
											<div class="row">
												<div class="form-group col-md-6">
													<label class="control-label required" for="role">Role</label>
													{!! Form::select('role_id', $roles, $user->roles->first()->id, ['class' => 'form-control roles-list']) !!}
												</div>
											</div>
										</div>
										<div class="form-body">
											<h4 class="form-section"><i class="la la-eye"></i> Social media</h4>
											<div class="row">
						                        <div class="form-group col-md-12 mb-2 @if ($errors->has('about')) has-error @endif">
						                        	<label for="userinput2">About</label>
						                        	{!! Form::textarea('about', $user->about, ['class' => 'form-control', 'rows' => 3, 'id' => 'about', 'placeholder' => 'We are PHP Team!!!', 'data-counter' => 400]) !!}
					                            	{!! Form::error('about', $errors) !!}
						                        </div>
					                        </div>
					                		<div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('interest')) has-error @endif">
						                        	<label for="userinput1">Interest</label>
						                        	{!! Form::text('interest', $user->interest, ['class' => 'form-control', 'id' => 'interest', 'placeholder' => 'Design, Web etc.', 'data-counter' => 255]) !!}
						                        	{!! Form::error('interest', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('website')) has-error @endif">
						                        	<label for="userinput1">Website</label>
						                        	{!! Form::text('website', $user->website, ['class' => 'form-control', 'id' => 'website', 'placeholder' => 'http://www.example.com', 'data-counter' => 255]) !!}
					                            	{!! Form::error('website', $errors) !!}
						                        </div>
						                        
					                        </div>
					                        <div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('skype')) has-error @endif">
						                        	<label for="userinput3">Skype</label>
						                        	 {!! Form::text('skype', $user->skype, ['class' => 'form-control', 'id' => 'skype', 'data-counter' => 60, 'placeholder' => 'https://www.skype.com']) !!}
					                            	 {!! Form::error('skype', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('facebook')) has-error @endif">
						                        	<label for="userinput4">Facebook</label>
						                        	{!! Form::text('facebook', $user->facebook, ['class' => 'form-control', 'id' => 'facebook', 'placeholder' => 'https://facebook.com', 'data-counter' => 255]) !!}
					                            	{!! Form::error('facebook', $errors) !!}
						                        </div>
					                        </div>
					                        <div class="form-actions clearfix">
					                            <div class="buttons-group float-right">
					                            	<a href="{{ route('admin.user.index') }}" class="btn btn-light" id="cancelButton">{{ __('Cancel') }}</a>
								                    <input type="submit" value="{{ __('Update') }}" class="btn btn-info">
					                            </div>
					                        </div>
										</div>
									{!! Form::close() !!}
								</div>
								<div class="tab-pane" id="user-password" role="tabpanel" aria-labelledby="tab-user-password" aria-expanded="false">
									{!! Form::open(['route' => ['admin.user.change-password', $user->id]]) !!}
										<div class="form-body">
											@if(!auth()->user()->isSuperUser())
											<div class="row">
					                        	<div class="form-group col-md-6 mb-2 @if ($errors->has('old_password')) has-error @endif">
						                        	<label for="userinput3">Old Password</label>
						                        	 {!! Form::password('old_password', ['class' => 'form-control', 'id' => 'old_password', 'data-counter' => 60, 'placeholder' => 'old password', 'autocomplete' => true]) !!}
					                            	 {!! Form::error('old_password', $errors) !!}
						                        </div>
					                        </div>
					                        @endif
					                        <div class="row">
						                        <div class="form-group col-md-6 mb-2 @if ($errors->has('password')) has-error @endif">
						                        	<label for="userinput3">Password</label>
						                        	 {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'data-counter' => 60, 'placeholder' => 'password', 'autocomplete' => true]) !!}
					                            	 <div class="pwstrength_viewport_progress"></div>
					                            	 {!! Form::error('password', $errors) !!}
						                        </div>
						                        <div class="form-group col-md-6 mb-2">
						                        	<label for="userinput4">Re-type password</label>
						                        	{!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'data-counter' => 60, 'placeholder' => 're-type', 'autocomplete' => true]) !!}
					                            	{!! Form::error('password_confirmation', $errors) !!}
						                        </div>
					                        </div>
					                        <div class="form-actions clearfix">
					                            <div class="buttons-group float-right">
					                            	<a href="{{ route('admin.user.index') }}" class="btn btn-light" id="cancelButton">{{ __('Cancel') }}</a>
								                    <input type="submit" value="{{ __('Change') }}" class="btn btn-info">
					                            </div>
					                        </div>
										</div>
									{!! Form::close() !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
