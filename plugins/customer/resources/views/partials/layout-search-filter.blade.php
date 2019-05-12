<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 21:00
 */
?>

<div class="card customer-list-card">
    <div class="card-header">
        <h4 class="card-title" id="relation-customer-info">{{ trans('plugins-customer::customer.search') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-element-left">
            {!! Form::select('query_customer', $customerQueryList, old('query_customer'), ['class' => 'select2-placeholder-multiple form-control select-query-customer-list', 'id' => 'select-query-customer','data-plugin' => 'select2']) !!}
        </div>
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
            <form class="search-form search-filter-customer" id="search-filter-customer">
                <div class="row">
                    {{--Full Name--}}
                    <div class="form-group col-md-3 mb-2">
                        <label for="full_name">{{ trans('plugins-customer::customer.form.full_name') }}</label>
                        {!! Form::text('full_name', old('full_name'), ['class' => 'form-control', 'id' => 'full_name', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.full_name')]) !!}
                    </div>
                    {{--End Full Name--}}

                    <div class="form-group col-md-2 mb-2">
                        <label class="control-label required" for="select-customer_relationship_id-list">{{ trans('plugins-customer::customer.form.status') }}</label>
                        {!! Form::select('status', [1 => trans('core-base::system.activated'), 0 => trans('core-base::system.disabled')], old('status'), ['class' => 'select2-placeholder-multiple form-control select-status-list', 'id' => 'select-status','data-plugin' => 'select2']) !!}
                    </div>

                    {{--Customer Code--}}
                    <div class="form-group col-md-2 mb-2">
                        <label for="customer_code">{{ trans('plugins-customer::customer.form.customer_code') }}</label>
                        {!! Form::text('customer_code', old('customer_code'), ['class' => 'form-control', 'id' => 'customer_code', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.customer_code')]) !!}
                    </div>
                    {{--End Customer Code--}}

                    {{--Phone--}}
                    <div class="form-group col-md-2 mb-2">
                        <label for="phone">{{ trans('plugins-customer::customer.form.phone') }}</label>
                        {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'id' => 'phone', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.phone')]) !!}
                    </div>
                    {{--End Phone--}}

                    <div class="form-group col-md-3 mb-2">
                        <label class="control-label required" for="select-customer_relationship_id-list">{{ trans('plugins-customer::customer.form.customer_relation') }}</label>
                        {!! Form::select('customer_relationship_id', $customerRelations, old('customer_relationship_id'), ['class' => 'select2-placeholder-multiple form-control customer_relationship_id-list', "id" => "select-customer_relationship_id-list", 'data-plugin' => 'select2' ]) !!}
                    </div>
                </div>
                <div class="row row-advanced-search">
                    <div id="advanced-search-btn" class="form-group col-md-3">
                        <span class="mr-1 title-advanced-search">
                            <i class="fab fa-searchengin"></i>
                            {{ trans('plugins-customer::customer.advanced_search') }}
                        </span>
                        <a class="btn btn-warning btn-sm open-advanced-search text-white">
                            <i class="far fa-caret-square-down"></i>
                            Open
                        </a>
                        <a class="btn btn-danger btn-sm text-white close-advanced-search">
                            <i class="far fa-window-close"></i>
                            Close & Reset
                        </a>
                    </div>
                    <div id="advanced-search-panel" role="tabpanel" aria-labelledby="advanced-search-btn" class="collapse col-md-12">
                        <div class="box-advanced-search">
                            <div class="row">
                                {{--Gender --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.gender') }}</label>
                                    {!! Form::select('gender', $genders, old('gender'), ['class' => 'select2-placeholder-multiple advanced-form form-control select-gender-list', "id" => "select-gender-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Gender--}}

                                {{--Email--}}
                                <div class="form-group col-md-2 mb-2">
                                    <label for="email">{{ trans('plugins-customer::customer.form.email') }}</label>
                                    {!! Form::text('email', old('email'), ['class' => 'advanced-form form-control', 'id' => 'email', 'data-counter' => 120, 'placeholder' => trans('plugins-customer::customer.form.email')]) !!}
                                </div>
                                {{--End Email--}}

                                {{--DOB--}}
                                <div class="form-group col-md-2 mb-2">
                                    <label for="dob">{{ trans('plugins-customer::customer.form.dob') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <span class="la la-calendar-o"></span>
                                            </span>
                                        </div>
                                        {!! Form::text('dob', old('dob'), ['class' => 'form-control advanced-form pickadate', 'id' => 'dob', 'placeholder' => trans('plugins-customer::customer.form.dob')]) !!}
                                    </div>
                                </div>
                                {{--End DOB--}}

                                {{--Fax--}}
                                <div class="form-group col-md-2 mb-2">
                                    <label for="fax">{{ trans('plugins-customer::customer.form.fax') }}</label>
                                    {!! Form::text('fax', old('fax'), ['class' => 'advanced-form form-control', 'id' => 'fax', 'data-counter' => 50, 'placeholder' => trans('plugins-customer::customer.form.fax')]) !!}
                                </div>
                                {{--End Fax--}}

                                {{--Website--}}
                                <div class="form-group col-md-2 mb-2">
                                    <label for="website">{{ trans('plugins-customer::customer.form.website') }}</label>
                                    {!! Form::text('website', old('website'), ['class' => 'advanced-form form-control', 'id' => 'website', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.website')]) !!}
                                </div>
                                {{--End Website--}}

                                {{--Facebook--}}
                                <div class="form-group col-md-2 mb-2">
                                    <label for="facebook">{{ trans('plugins-customer::customer.form.facebook') }}</label>
                                    {!! Form::text('facebook', old('facebook'), ['class' => 'advanced-form form-control', 'id' => 'facebook', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.facebook')]) !!}
                                </div>
                                {{--End Facebook--}}
                            </div>
                            <div class="row">
                                {{--Address--}}
                                <div class="form-group col-md-2 mb-2">
                                    <label for="address">{{ trans('plugins-customer::customer.form.address') }}</label>
                                    {!! Form::text('address', old('address'), ['class' => 'advanced-form form-control', 'id' => 'address', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.form.address')]) !!}
                                </div>
                                {{--End Address--}}

                                {{-- Province City --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.province_city') }}</label>
                                    {!! Form::select('province_city_code', $provincesCities, old('province_city_code'), ['class' => 'select2-placeholder-multiple advanced-form form-control province_city_code-list', "id" => "select-province_city_code-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Province City --}}

                                {{-- District --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.district') }}</label>
                                    {!! Form::select('district_code', [], old('district_code'), ['class' => 'select2-placeholder-multiple advanced-form form-control district_code-list', "id" => "select-district_code-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End District--}}

                                {{-- Ward --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="role">{{ trans('plugins-customer::customer.form.ward') }}</label>
                                    {!! Form::select('ward_code', [], old('ward_code'), ['class' => 'select2-placeholder-multiple advanced-form form-control ward_code-list', "id" => "select-ward_code-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Ward --}}

                                {{--Type Source Data --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="select-type_reference_data-list">{{ trans('plugins-customer::customer.form.type_reference_data') }}</label>
                                    {!! Form::select('type_reference_data', $typeReferenceData, old('type_reference_data'), ['class' => 'select2-placeholder-multiple advanced-form form-control type_reference_data-list', "id" => "select-type_reference_data-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Type Source Data--}}

                                {{-- Introduce Person --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="select-introduce_person_id-list">{{ trans('plugins-customer::customer.form.introduce_person') }}</label>
                                    {!! Form::select('introduce_person_id', $introducePersonIds, old('introduce_person_id'), ['class' => 'select2-placeholder-multiple advanced-form form-control introduce_person_id-list', "id" => "select-introduce_person_id-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Introduce Person--}}
                            </div>
                            <div class="row">
                                {{-- Group Customer --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="select-customer_group-list">{{ trans('plugins-customer::customer.form.customer_group') }}</label>
                                    {!! Form::select('customer_group_id', $customerGroups, old('customer_group_id'), ['class' => 'select2-placeholder-multiple advanced-form form-control customer_group-list', "id" => "select-customer_group-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Group Customer--}}

                                {{-- Source Customer --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="select-customer_source-list">{{ trans('plugins-customer::customer.form.customer_source') }}</label>
                                    {!! Form::select('customer_source_id', $customerSources, old('customer_source_id'), ['class' => 'select2-placeholder-multiple advanced-form form-control customer_source-list', "id" => "select-customer_source-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Source Customer--}}

                                {{-- Job Customer --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="select-job_id-list">{{ trans('plugins-customer::customer.form.jobs') }}</label>
                                    {!! Form::select('customer_job_id', $customerGroups, old('customer_job_id'), ['class' => 'select2-placeholder-multiple advanced-form form-control customer_job-list', "id" => "select-job_id-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{-- End Job Customer --}}

                                {{-- Assign Person Manage --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="select-user_manage_id-list">{{ trans('plugins-customer::customer.form.user_manage') }}</label>
                                    {!! Form::select('user_manage_id', $users, old('user_manage_id'), ['class' => 'select2-placeholder-multiple advanced-form form-control user_manage_id-list', "id" => "select-user_manage_id-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Assign Person Manage--}}

                                {{-- Created By --}}
                                <div class="form-group col-md-2 mb-2">
                                    <label class="control-label required" for="select-created_by-list">{{ trans('plugins-customer::customer.form.created_by') }}</label>
                                    {!! Form::select('created_by', $users, old('created_by'), ['class' => 'select2-placeholder-multiple advanced-form form-control created_by-list', "id" => "select-created_by-list", 'data-plugin' => 'select2' ]) !!}
                                </div>
                                {{--End Created By--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-btn-search">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-info mr-1" data-search-control="search">
                            <i class="fas fa-search"></i> {{ trans('plugins-customer::customer.search') }}
                        </button>
                        <button type="button" class="btn btn-secondary mr-1" data-search-control="clear">
                            <i class="fas fa-undo-alt"></i> {{ trans('plugins-customer::customer.clear') }}
                        </button>
                        <span class="title-custom">
                            Or
                        </span>
                        <button type="button" class="ml-1 btn btn-success mr-1 btn-create-query" data-toggle="modal" data-target="#new-query-modal">
                            <i class="far fa-plus-square"></i> {{ trans('plugins-customer::customer.create_query') }}
                        </button>
                        <button type="button" class="btn btn-info btn-update-query mr-1" data-toggle="modal" data-target="#update-query-modal">
                            <i class="far fa-save"></i> {{ trans('plugins-customer::customer.update_query') }}
                        </button>
                        <button type="button" class="btn btn-danger btn-delete-query mr-1" data-toggle="modal" data-target="#delete-query-customer-modal">
                            <i class="far fa-trash-alt"></i> {{ trans('plugins-customer::customer.delete_query') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('plugins-customer::partials.modal.new-customer-query-list-modal')
@include('plugins-customer::partials.modal.update-customer-query-list-modal')
{!! Form::modalAction('delete-query-customer-modal', null , 'danger',  __('Do you want delete this item?'), 'delete-query-customer-entry', __('Delete')) !!}
