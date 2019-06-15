@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.customer.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, CUSTOMER_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9 row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-customer::customer.info_customer') }}</h4>
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
                                    {{--Full Name--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('full_name')) has-error @endif">
                                            <label for="full_name">{{ trans('plugins-customer::customer.form.full_name') }}</label>
                                            {!! Form::text('full_name', old('full_name'), ['class' => 'form-control', 'id' => 'full_name', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.full_name')]) !!}
                                            {!! Form::error('full_name', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Full Name--}}

                                    {{--Gender --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('gender')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.gender') }}</label>
                                            {!! Form::select('gender', $genders, old('gender'), ['class' => 'select2-placeholder-multiple form-control gender-list', "id" => "select-gender-list" ]) !!}
                                            {!! Form::error('gender', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Gender--}}

                                    {{--Phone--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('phone')) has-error @endif">
                                            <label for="phone">{{ trans('plugins-customer::customer.form.phone') }}</label>
                                            {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'id' => 'phone', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.phone')]) !!}
                                            {!! Form::error('phone', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Phone--}}

                                    {{--Customer Code--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_code')) has-error @endif">
                                            <label for="customer_code">{{ trans('plugins-customer::customer.form.customer_code') }}</label>
                                            {!! Form::text('customer_code', old('customer_code'), ['class' => 'form-control', 'id' => 'customer_code', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.customer_code')]) !!}
                                            {!! Form::error('customer_code', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Customer Code--}}

                                    {{--Tax Code--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('tax_code')) has-error @endif">
                                            <label for="tax_code">{{ trans('plugins-customer::customer.form.tax_code') }}</label>
                                            {!! Form::text('tax_code', old('tax_code'), ['class' => 'form-control', 'id' => 'tax_code', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.tax_code')]) !!}
                                            {!! Form::error('tax_code', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Tax Code--}}

                                    {{--Tax--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('fax')) has-error @endif">
                                            <label for="fax">{{ trans('plugins-customer::customer.form.fax') }}</label>
                                            {!! Form::text('fax', old('fax'), ['class' => 'form-control', 'id' => 'fax', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.fax')]) !!}
                                            {!! Form::error('fax', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Tax--}}

                                    {{--Email--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('email')) has-error @endif">
                                            <label for="email">{{ trans('plugins-customer::customer.form.email') }}</label>
                                            {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'data-counter' => 120, 'placeholder' => trans('plugins-customer::customer.form.email')]) !!}
                                            {!! Form::error('email', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Email--}}

                                    {{--Value--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('value')) has-error @endif">
                                            <label for="value">{{ trans('plugins-customer::customer.form.value') }}</label>
                                            {!! Form::text('value', old('value'), ['class' => 'form-control', 'id' => 'value', 'data-counter' => 120, 'placeholder' => trans('plugins-customer::customer.form.value')]) !!}
                                            {!! Form::error('value', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Value--}}

                                    {{-- Job Customer --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_job_id')) has-error @endif">
                                            <label class="control-label required" for="select-job_id-list">{{ trans('plugins-customer::customer.form.jobs') }}</label>
                                            {!! Form::select('customer_job_id[]', $customerJobs, old('customer_job_id'), ['class' => 'select2-placeholder-multiple form-control job_id-list', "id" => "select-job_id-list", "multiple" => "multiple" ]) !!}
                                            {!! Form::error('customer_job_id', $errors) !!}
                                        </div>
                                    </div>
                                    {{-- End Job Customer --}}

                                    {{--Description--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                            <label for="name">{{ trans('core-base::forms.description') }}</label>
                                            {!! render_editor('description', old('description'), true) !!}
                                            {!! Form::error('description', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Description--}}

                                    {{--DOB--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('dob')) has-error @endif">
                                            <label for="dob">{{ trans('plugins-customer::customer.form.dob') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <span class="la la-calendar-o"></span>
                                                    </span>
                                                </div>
                                                {!! Form::text('dob', old('dob'), ['class' => 'form-control pickadate', 'id' => 'dob', 'placeholder' => trans('plugins-customer::customer.form.dob')]) !!}
                                                {!! Form::error('dob', $errors) !!}
                                            </div>
                                        </div>
                                    </div>
                                    {{--End DOB--}}

                                    {{--Address--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('address')) has-error @endif">
                                            <label for="address">{{ trans('plugins-customer::customer.form.address') }}</label>
                                            {!! Form::textarea('address', old('address'), ['class' => 'form-control', 'id' => 'address', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.address')]) !!}
                                            {!! Form::error('address', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Address--}}

                                    {{-- Province City --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('province_city_code')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.province_city') }}</label>
                                            {!! Form::select('province_city_code', $provincesCities, old('province_city_code'), ['class' => 'select2-placeholder-multiple form-control province_city_code-list', "id" => "select-province_city_code-list" ]) !!}
                                            {!! Form::error('province_city_code', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Province City --}}

                                    {{-- District --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('district_code')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.district') }}</label>
                                            {!! Form::select('district_code', [], old('district_code'), ['class' => 'select2-placeholder-multiple form-control district_code-list', "id" => "select-district_code-list" ]) !!}
                                            {!! Form::error('district_code', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End District--}}

                                    {{-- Ward --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('ward_code')) has-error @endif">
                                            <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.ward') }}</label>
                                            {!! Form::select('ward_code', [], old('ward_code'), ['class' => 'select2-placeholder-multiple form-control ward_code-list', "id" => "select-ward_code-list" ]) !!}
                                            {!! Form::error('ward_code', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Ward --}}

                                    {{--Website--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('website')) has-error @endif">
                                            <label for="website">{{ trans('plugins-customer::customer.form.website') }}</label>
                                            {!! Form::text('website', old('website'), ['class' => 'form-control', 'id' => 'website', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.website')]) !!}
                                            {!! Form::error('website', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Website--}}

                                    {{--Facebook--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('facebook')) has-error @endif">
                                            <label for="facebook">{{ trans('plugins-customer::customer.form.facebook') }}</label>
                                            {!! Form::text('facebook', old('facebook'), ['class' => 'form-control', 'id' => 'facebook', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.facebook')]) !!}
                                            {!! Form::error('facebook', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Facebook--}}

                                    {{--Note--}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('note')) has-error @endif">
                                            <label for="note">{{ trans('plugins-customer::customer.form.note') }}</label>
                                            {!! Form::textarea('note', old('note'), ['class' => 'form-control', 'id' => 'note', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.note')]) !!}
                                            {!! Form::error('note', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Note--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-contacts">
                        @include('plugins-customer::partials.customer-contact')
                    </div>
                    <div class="action-add-contact">
                        <i class="fas fa-id-card"></i>
                        <h6 class="add-new-contact">
                            {{ trans('plugins-customer::customer.new_contact') }}
                        </h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-customer::customer.introduce_person') }}</h4>
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
                                    {{--Type Source Data --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('type_reference_data')) has-error @endif">
                                            <label class="control-label required" for="select-type_reference_data-list">{{ trans('plugins-customer::customer.form.type_reference_data') }}</label>
                                            {!! Form::select('type_reference_data', $typeReferenceData, old('type_reference_data'), ['class' => 'select2-placeholder-multiple form-control type_reference_data-list', "id" => "select-type_reference_data-list" ]) !!}
                                            {!! Form::error('type_reference_data', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Type Source Data--}}

                                    {{-- Introduce Person --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('introduce_person_id')) has-error @endif">
                                            <label class="control-label required" for="select-introduce_person_id-list">{{ trans('plugins-customer::customer.form.introduce_person') }}</label>
                                            {!! Form::select('introduce_person_id', $introducePersonIds, old('introduce_person_id'), ['class' => 'select2-placeholder-multiple form-control introduce_person_id-list', "id" => "select-introduce_person_id-list" ]) !!}
                                            {!! Form::error('introduce_person_id', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Introduce Person--}}

                                    {{-- Assign Person Manage --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('user_manage_id')) has-error @endif">
                                            <label class="control-label required" for="select-user_manage_id-list">{{ trans('plugins-customer::customer.form.user_manage') }}</label>
                                            {!! Form::select('user_manage_id', $users, old('user_manage_id'), ['class' => 'select2-placeholder-multiple form-control user_manage_id-list', "id" => "select-user_manage_id-list" ]) !!}
                                            {!! Form::error('user_manage_id', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Assign Person Manage--}}

                                    {{-- Group Customer --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_group_id')) has-error @endif">
                                            <label class="control-label required" for="select-customer_group-list">{{ trans('plugins-customer::customer.form.customer_group') }}</label>
                                            {!! Form::select('customer_group_id[]', $customerGroups, old('customer_group_id'), ['class' => 'select2-placeholder-multiple form-control customer_group-list', "id" => "select-customer_group-list", "multiple" => "multiple" ]) !!}
                                            {!! Form::error('customer_group_id', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Group Customer--}}

                                    {{-- Source Customer --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_source_id')) has-error @endif">
                                            <label class="control-label required" for="select-customer_source-list">{{ trans('plugins-customer::customer.form.customer_source') }}</label>
                                            {!! Form::select('customer_source_id[]', $customerSources, old('customer_source_id'), ['class' => 'select2-placeholder-multiple form-control customer_source-list', "id" => "select-customer_source-list", "multiple" => "multiple" ]) !!}
                                            {!! Form::error('customer_source_id', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Source Customer--}}

                                    {{-- Relation Of Customer --}}
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_relationship_id')) has-error @endif">
                                            <label class="control-label required" for="select-customer_relationship_id-list">{{ trans('plugins-customer::customer.form.customer_relation') }}</label>
                                            {!! Form::select('customer_relationship_id', $customerRelationships, old('customer_relationship_id'), ['class' => 'select2-placeholder-multiple form-control customer_relationship_id-list', "id" => "select-customer_relationship_id-list" ]) !!}
                                            {!! Form::error('customer_relationship_id', $errors) !!}
                                        </div>
                                    </div>
                                    {{--End Relation Of Customer--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Custom Attribute--}}
                    @include('plugins-custom-attributes::partials.card-custom-attributes')
                    {{--End Custom Attribute--}}
                </div>
                @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'advanced') @endphp
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')
                {{-- Image--}}
                <div class="widget meta-boxes">
                    <div class="widget-title">
                        <h4>
                            <span class="required @if ($errors->has('avatar')) has-error @endif">
                                <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.avatar') }}</label>
                            </span>
                        </h4>
                    </div>
                    <div class="widget-body">
                        {!! Form::mediaImage('avatar', old('avatar')) !!}
                        {!! Form::error('avatar', $errors) !!}
                    </div>
                </div>
                {{--End Image--}}
                @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop

@section('variable-scripts')
    <script>
        const API_ADDRESS = {
            REFRESH_DISTRICTS : "{{ route('ajax.address.refresh_districts') }}",
            REFRESH_WARDS : "{{ route('ajax.address.refresh_wards') }}",
        };

        const API = {
            GET_INTRODUCE_PERSON : "{{ route('ajax.admin.get_introduce_persons_by_type_reference') }}",
        };
        const CARD_CONTACT_INDEX = 1;
        const LIST_GENDER = {!! json_encode($genders) !!};
        const CUSTOMER_RELATION_LIST = {!! json_encode($customerRelationships) !!};
        let mode = "CREATE";
        const CUSTOMER_RELATION_ID = "";
        const USER_LIST = {!! json_encode($users) !!};
        const WARD_CODE_DEFAULT = null;
        const DISTRICT_CODE_DEFAULT = null;
    </script>
@stop
