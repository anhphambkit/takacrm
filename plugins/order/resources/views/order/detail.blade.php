<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-10
 * Time: 07:28
 */
?>
@extends('layouts.master')
@section('content')
    <div class="row box-order-info">
        <div class="col-md-9 left-info-order">
            @include('plugins-order::partials.info-detail-order')
        </div>
        <div class="col-md-3 right-info-order">
            {{--@include('plugins-order::partials.info-detail-order')--}}
        </div>
    </div>
@stop

@section('variable-scripts')
    <script>
        {{--const API = {--}}
            {{--LIST_CUSTOMER_URL : "{{ route('admin.order.list') }}",--}}
            {{--UPDATE_CUSTOMER : "{{ route('ajax.admin.update_data_relation_of_order') }}",--}}
        {{--}--}}
        {{--const CUSTOMER_RELATION_LIST = {!! json_encode($orderRelationshipIds) !!};--}}
        {{--const CUSTOMER_ID = {!! $order->id !!};--}}
        {{--const CUSTOMER_RELATION_ID = {!! $order->order_relationship_id !!};--}}
    </script>
@stop

@section('master-footer')
@stop
