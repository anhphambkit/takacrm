<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 09:48
 */
?>
@extends('layouts.master')
@section('content')
    <div class="row top-header-customer">
        <div class="col-md-12">
            @include('plugins-customer::partials.info-header-customer')
        </div>
    </div>
    <div class="row box-customer-info">
        <div class="col-md-3 left-info-customer">
            @include('plugins-customer::partials.customer-relation-card')
            @include('plugins-customer::partials.customer-progress')
            @include('plugins-customer::partials.customer-contacts')
            @include('plugins-customer::partials.info-detail-customer')
        </div>
        <div class="col-md-6 middle-info-customer">
            @include('plugins-customer::partials.customer-info-tabs')
        </div>
        <div class="col-md-3 right-info-customer">
            @include('plugins-customer::partials.info-log-history-customer')
        </div>
    </div>
@stop

@section('variable-scripts')
    <script>
        const API = {
            LIST_CUSTOMER_URL : "{{ route('admin.customer.list') }}",
            UPDATE_CUSTOMER : "{{ route('ajax.admin.update_data_relation_of_customer') }}",
        }
        const CUSTOMER_RELATION_LIST = {!! json_encode($customerRelationshipIds) !!};
        const CUSTOMER_ID = {!! $customer->id !!};
        const CUSTOMER_RELATION_ID = {!! $customer->customer_relationship_id !!};
    </script>
@stop

@section('master-footer')
@stop
