<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-30
 * Time: 11:11
 */

$customerContacts = !empty($customerContacts) ? $customerContacts : [
    [
        'index' => 0,
        'full_name' => '',
        'job_position' => '',
        'gender' => '',
        'dob' => '',
        'phone' => '',
        'email' => '',
        'note' => '',
    ]
];
?>
@foreach($customerContacts as $customerContact)
    <div class="card card-contact">
        <div class="card-header">
            <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-customer::customer.contact') }}</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="remove"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collpase show">
            <div class="card-body">
                <div class="form-body">
                    <div class="contact-customer contact-customer-{{ $customerContact['index'] }}">
                        {{--Full Name--}}
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('full_name')) has-error @endif">
                                <label for="full_name">{{ trans('plugins-customer::customer.form.full_name') }}</label>
                                {!! Form::text("customer_contact[{$customerContact['index']}][full_name]", $customerContact['full_name'], ['class' => 'form-control', 'id' => "full-name-contact-{$customerContact['index']}", 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.full_name')]) !!}
                                {!! Form::error("customer_contact.{$customerContact['index']}.full_name", $errors) !!}
                            </div>
                        </div>
                        {{--End Full Name--}}

                        {{--Job Position--}}
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('job_position')) has-error @endif">
                                <label for="job_position">{{ trans('plugins-customer::customer.form.job_position') }}</label>
                                {!! Form::text("customer_contact[{$customerContact['index']}][job_position]", $customerContact['job_position'], ['class' => 'form-control', 'id' => "job-position-contact-{$customerContact['index']}", 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.job_position')]) !!}
                                {!! Form::error("customer_contact.{$customerContact['index']}.job_position", $errors) !!}
                            </div>
                        </div>
                        {{--End Job Position--}}

                        <div class="row">
                            <div class="form-group col-md-4 mb-2 @if ($errors->has('gender')) has-error @endif">
                                <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.gender') }}</label>
                                {!! Form::select("customer_contact[{$customerContact['index']}][gender]", $genders, $customerContact['gender'], ['class' => 'select2-placeholder-multiple form-control gender-list', "id" => "select-gender-list-contact-{$customerContact['index']}" ]) !!}
                                {!! Form::error("customer_contact.{$customerContact['index']}.gender", $errors) !!}
                            </div>

                            <div class="form-group col-md-8 mb-2 @if ($errors->has('dob')) has-error @endif">
                                <label for="dob">{{ trans('plugins-customer::customer.form.dob') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <span class="la la-calendar-o"></span>
                                        </span>
                                    </div>
                                    {!! Form::text("customer_contact[{$customerContact['index']}][dob]", $customerContact['dob'] ? format_date_time($customerContact['dob'], "Asia/Ho_Chi_Minh", "Y-m-d", "d/m/Y") : "", ['class' => 'form-control pickadate', 'id' => "dob-contact-{$customerContact['index']}", 'placeholder' => trans('plugins-customer::customer.form.dob')]) !!}
                                    {!! Form::error("customer_contact.{$customerContact['index']}.dob", $errors) !!}
                                </div>
                            </div>
                        </div>

                        {{--Phone--}}
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('phone')) has-error @endif">
                                <label for="phone">{{ trans('plugins-customer::customer.form.phone') }}</label>
                                {!! Form::text("customer_contact[{$customerContact['index']}][phone]", $customerContact['phone'], ['class' => 'form-control', 'id' => "phone-contact-{$customerContact['index']}", 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.phone')]) !!}
                                {!! Form::error("customer_contact.{$customerContact['index']}.phone", $errors) !!}
                            </div>
                        </div>
                        {{--End Phone--}}

                        {{--Email--}}
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('email')) has-error @endif">
                                <label for="email">{{ trans('plugins-customer::customer.form.email') }}</label>
                                {!! Form::text("customer_contact[{$customerContact['index']}][email]", $customerContact['email'], ['class' => 'form-control', 'id' => "email-contact-{$customerContact['index']}", 'data-counter' => 120, 'placeholder' => trans('plugins-customer::customer.form.email')]) !!}
                                {!! Form::error("customer_contact.{$customerContact['index']}.email", $errors) !!}
                            </div>
                        </div>
                        {{--End Email--}}

                        {{--Note--}}
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('note')) has-error @endif">
                                <label for="note">{{ trans('plugins-customer::customer.form.note') }}</label>
                                {!! Form::textarea("customer_contact[{$customerContact['index']}][note]", $customerContact['note'], ['class' => 'form-control', 'id' => "note-contact-{$customerContact['index']}", 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.note')]) !!}
                                {!! Form::error("customer_contact.{$customerContact['index']}.note", $errors) !!}
                            </div>
                        </div>
                        {{--End Note--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

