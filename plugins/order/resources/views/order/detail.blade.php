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
            @include('plugins-custom-attributes::partials.custom-attribute-detail-info', [ 'entityId' => $order->id, 'classFieldWrapper' => 'form-group col-md-4 mb-2' ])
            @include('plugins-history::history-logs')
        </div>
        <div class="col-md-3 right-info-order">
            {{--@include('plugins-order::partials.info-detail-order')--}}
        </div>
    </div>
    <div class="form-actions-area">
        <div class="row">
            <div class="col-md-12">
                @include('plugins-order::partials.form-detail-order-action', [ 'routeEdit' => route('admin.order.edit', [ 'id' => $order->id ]) ])
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
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
    <script type="text/javascript">
        $(document).ready(function(){
            //TODO HERE
            var historyHeight = $('#log-history-order').height();
            if(historyHeight > 600){
                $('#log-history-order').css({
                    "max-height":'600px',
                    "overflow": 'scroll'
                });
            }
        })
    </script>
@stop

