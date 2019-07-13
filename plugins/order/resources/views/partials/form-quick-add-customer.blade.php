<!-- The Modal -->
<div class="modal" id="modQuickAddCustomer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm nhanh khách hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" style="height: 500px; overflow-x: auto">
                    <ul class="nav nav-tabs border-0">
                        <li class="active"><a data-toggle="tab" href="#customer" class="active">Khách Hàng</a></li>
                        <li><a data-toggle="tab" href="#contact">Liên Hệ</a></li>
                    </ul>

                    <div class="tab-content mt-1">
                        <div id="customer" class="tab-pane fade in active show form-order-crud">
                            {{--Gender --}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('gender')) has-error @endif">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.gender') }}</label>
                                    {!! Form::select('gender', $genders, old('gender'), ['class' => 'select2-placeholder-multiple form-control gender-list', "id" => "select-gender-list" ]) !!}
                                    {!! Form::error('gender', $errors) !!}
                                </div>
                            </div>
                            {{--End Gender--}}
                            {{--Full Name--}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('full_name')) has-error @endif">
                                    <label for="full_name">{{ trans('plugins-customer::customer.form.full_name') }}</label>
                                    {!! Form::text('full_name', old('full_name'), ['class' => 'form-control', 'id' => 'full_name', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.full_name')]) !!}
                                    {!! Form::error('full_name', $errors) !!}
                                </div>
                            </div>
                            {{--End Full Name--}}
                            {{--Phone--}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('phone')) has-error @endif">
                                    <label for="phone">{{ trans('plugins-customer::customer.form.phone') }}</label>
                                    {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'id' => 'phone', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.phone')]) !!}
                                    {!! Form::error('phone', $errors) !!}
                                </div>
                            </div>
                            {{--End Phone--}}
                            {{--Facebook--}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('facebook')) has-error @endif">
                                    <label for="facebook">{{ trans('plugins-customer::customer.form.facebook') }}</label>
                                    {!! Form::text('facebook', old('facebook'), ['class' => 'form-control', 'id' => 'facebook', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.facebook')]) !!}
                                    {!! Form::error('facebook', $errors) !!}
                                </div>
                            </div>
                            {{--End Facebook--}}

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

                            {{-- Assign Person Manage --}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('user_manage_id')) has-error @endif">
                                    <label class="control-label required" for="select-user_manage_id-list">{{ trans('plugins-customer::customer.form.user_manage') }}</label>
                                    {!! Form::select('user_manage_id', $users, old('user_manage_id'), ['class' => 'select2-placeholder-multiple form-control user_manage_id-list', "id" => "select-user_manage_id-list" ]) !!}
                                    {!! Form::error('user_manage_id', $errors) !!}
                                </div>
                            </div>
                            {{--End Assign Person Manage--}}

                            {{-- Job Customer --}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_job_id')) has-error @endif">
                                    <label class="control-label required" for="select-job_id-list">{{ trans('plugins-customer::customer.form.jobs') }}</label>
                                    {!! Form::select('customer_job_id[]', $customerJobs, old('customer_job_id'), ['class' => 'select2-placeholder-multiple form-control job_id-list', "id" => "select-job_id-list", "multiple" => "multiple" ]) !!}
                                    {!! Form::error('customer_job_id', $errors) !!}
                                </div>
                            </div>
                            {{-- End Job Customer --}}


                            {{-- Group Customer --}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_group_id')) has-error @endif">
                                    <label class="control-label required" for="select-customer_group-list">{{ trans('plugins-customer::customer.form.customer_group') }}</label>

                                        <div class="row">
                                            <div class="col-md-11 pr-0">
                                                {!! Form::select('customer_group_id[]', $customerGroups, old('customer_group_id'), ['class' => 'select2-placeholder-multiple form-control customer_group-list', "id" => "select-customer_group-list", "multiple" => "multiple" ]) !!}
                                            </div>
                                            <div class="col-md-1 pl-0">
                                                <div class="input-group-append">
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown">
                                                            <i class="fa fa-plus m-0"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-modal">
                                                            <div class="panel" id="pnQuickAddCustomerGroup">
                                                                <div class="panel-body">
                                                                    <label>@lang('plugins-customer::customer.form.customer_group')</label>
                                                                    <input type="text" name="name" id="resourceName" class="form-control"/>
                                                                </div>
                                                                <div class="panel-footer mt-1">
                                                                    <button type="button" class="btn btn-primary btn-sm" id="btnQuickAddCustomerGroup">Thêm</button>
                                                                    <button type="button" data-toggle="dismiss" class="btn btn-danger btn-sm mr5">Đóng</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    {!! Form::error('customer_group_id', $errors) !!}
                                </div>
                            </div>
                            {{--End Group Customer--}}

                            {{-- Source Customer --}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_source_id')) has-error @endif">
                                    <label class="control-label required" for="select-customer_source-list">{{ trans('plugins-customer::customer.form.customer_source') }}</label>
                                    <div class="row">
                                        <div class="col-md-11 pr-0">
                                            {!! Form::select('customer_source_id[]', $customerSources, old('customer_source_id'), ['class' => 'select2-placeholder-multiple form-control customer_source-list', "id" => "select-customer_source-list", "multiple" => "multiple" ]) !!}
                                        </div>
                                        <div class="col-md-1 pl-0">
                                            <div class="input-group-append">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown">
                                                        <i class="fa fa-plus m-0"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-modal">
                                                        <div class="panel" id="pnQuickAddCustomerGroup">
                                                            <div class="panel-body">
                                                                <label>@lang('plugins-customer::customer.form.customer_source')</label>
                                                                <input type="text" name="name" id="resourceName" class="form-control"/>
                                                            </div>
                                                            <div class="panel-footer mt-1">
                                                                <button type="button" class="btn btn-primary btn-sm" id="btnQuickAddCustomerGroup">Thêm</button>
                                                                <button type="button" data-toggle="dismiss" class="btn btn-danger btn-sm mr5">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::error('customer_source_id', $errors) !!}
                                </div>
                            </div>
                            {{--End Source Customer--}}

                            {{-- Job Customer --}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_job_id')) has-error @endif">
                                    <label class="control-label required" for="select-job_id-list">{{ trans('plugins-customer::customer.form.jobs') }}</label>

                                    <div class="row">
                                        <div class="col-md-11 pr-0">
                                            {!! Form::select('customer_job_id[]', $customerJobs, old('customer_job_id'), ['class' => 'select2-placeholder-multiple form-control job_id-list', "id" => "select-job_id-list", "multiple" => "multiple" ]) !!}
                                        </div>
                                        <div class="col-md-1 pl-0">
                                            <div class="input-group-append">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown">
                                                        <i class="fa fa-plus m-0"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-modal">
                                                        <div class="panel" id="pnQuickAddCustomerGroup">
                                                            <div class="panel-body">
                                                                <label>@lang('plugins-customer::customer.form.jobs')</label>
                                                                <input type="text" name="name" id="resourceName" class="form-control"/>
                                                            </div>
                                                            <div class="panel-footer mt-1">
                                                                <button type="button" class="btn btn-primary btn-sm" id="btnQuickAddCustomerGroup">Thêm</button>
                                                                <button type="button" data-toggle="dismiss" class="btn btn-danger btn-sm mr5">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::error('customer_job_id', $errors) !!}
                                </div>
                            </div>
                            {{-- End Job Customer --}}

                            {{-- Relation Of Customer --}}
                            <div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_relationship_id')) has-error @endif">
                                    <label class="control-label required" for="select-customer_relationship_id-list">{{ trans('plugins-customer::customer.form.customer_relation') }}</label>
                                    {!! Form::select('customer_relationship_id', $customerRelationships, old('customer_relationship_id'), ['class' => 'select2-placeholder-multiple form-control customer_relationship_id-list', "id" => "select-customer_relationship_id-list" ]) !!}
                                    {!! Form::error('customer_relationship_id', $errors) !!}
                                </div>
                            </div>
                            {{--End Relation Of Customer--}}


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
                            <!--div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('address')) has-error @endif">
                                    <label for="address">{{ trans('plugins-customer::customer.form.address') }}</label>
                                    {!! Form::textarea('address', old('address'), ['class' => 'form-control', 'id' => 'address', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.address')]) !!}
                                    {!! Form::error('address', $errors) !!}
                                </div>
                            </div-->
                            {{--End Address--}}

                            {{-- Province City --}}
                            <!--div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('province_city_code')) has-error @endif">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.province_city') }}</label>
                                    {!! Form::select('province_city_code', $provincesCities, old('province_city_code'), ['class' => 'select2-placeholder-multiple form-control province_city_code-list', "id" => "select-province_city_code-list" ]) !!}
                                    {!! Form::error('province_city_code', $errors) !!}
                                </div>
                            </div-->
                            {{--End Province City --}}

                            {{-- District --}}
                            <!--div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('district_code')) has-error @endif">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.district') }}</label>
                                    {!! Form::select('district_code', [], old('district_code'), ['class' => 'select2-placeholder-multiple form-control district_code-list', "id" => "select-district_code-list" ]) !!}
                                    {!! Form::error('district_code', $errors) !!}
                                </div>
                            </div-->
                            {{--End District--}}

                            {{-- Ward --}}
                            <!--div class="row">
                                <div class="form-group col-md-12 mb-2 @if ($errors->has('ward_code')) has-error @endif">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.ward') }}</label>
                                    {!! Form::select('ward_code', [], old('ward_code'), ['class' => 'select2-placeholder-multiple form-control ward_code-list', "id" => "select-ward_code-list" ]) !!}
                                    {!! Form::error('ward_code', $errors) !!}
                                </div>
                            </div-->
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
                        <div id="contact" class="tab-pane fade">
                            <h3>Menu 1</h3>
                            <p>Some content in menu 1.</p>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
