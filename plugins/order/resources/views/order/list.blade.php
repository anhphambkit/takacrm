<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 14:06
 */
?>
@extends('layouts.master')
@section('content')
    <form class="search-form search-filter-order" id="search-filter-order">
        <div class="row list-search-filter">
            <div class="col-md-12">
                {{--@include('plugins-order::partials.layout-search-filter')--}}
            </div>
        </div>
        <div class="row table-order-area">
            <div class="col-md-12">
                @include('plugins-order::partials.order-table')
            </div>
        </div>
    </form>
@stop

@section('variable-scripts')
    <script>
        const API = {
            {{--LIST_CUSTOMER_URL : "{{ route('admin.order.list') }}",--}}
            GET_LIST_ORDER : "{{ route('ajax.admin.get_list_order') }}",
            DETAIL_ORDER : "{{ route('admin.order.detail', [ 'id' => '' ]) }}",
        }
    </script>
@stop

@section('master-footer')
@stop