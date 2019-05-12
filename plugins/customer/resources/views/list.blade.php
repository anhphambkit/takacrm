<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 20:58
 */
?>
@extends('layouts.master')
@section('content')
    <div class="row list-search-filter">
        <div class="col-md-12">
            @include('plugins-customer::partials.layout-search-filter')
        </div>
    </div>
    <div class="row table-customer-area">
        {{--<div class="col-md-2">--}}
            {{--@include('plugins-customer::partials.filter-relation')--}}
        {{--</div>--}}
        <div class="col-md-12">
            @include('plugins-customer::partials.customer-table')
        </div>
    </div>
@stop

@section('variable-scripts')
    <script>
        const API_ADDRESS = {
            REFRESH_DISTRICTS : "{{ route('ajax.address.refresh_districts') }}",
            REFRESH_WARDS : "{{ route('ajax.address.refresh_wards') }}",
        };

        const API = {
            LIST_CUSTOMER_URL : "{{ route('admin.customer.list') }}",
            GET_LIST_CUSTOMER : "{{ route('ajax.admin.get_list_customer') }}",
            GET_INTRODUCE_PERSON : "{{ route('ajax.admin.get_introduce_persons_by_type_reference') }}",
        }

        const API_QUERY_LIST = {
            GET_LIST_QUERY : "{{ route('ajax.admin.get_customer_query_list') }}",
            GET_DATA_QUERY : "{{ route('ajax.admin.get_data_customer_query_list') }}",
            CREATE_QUERY : "{{ route('ajax.admin.create_customer_query_list') }}",
            UPDATE_QUERY : "{{ route('ajax.admin.update_customer_query_list') }}",
            DELETE_QUERY : "{{ route('ajax.admin.delete_customer_query_list', [ 'id' => "" ]) }}",
        }

        const CUSTOMER_RELATION_LIST = {!! json_encode($customerRelations) !!};
        const USER_LIST = {!! json_encode($users) !!};
    </script>
@stop

@section('master-footer')
@stop

