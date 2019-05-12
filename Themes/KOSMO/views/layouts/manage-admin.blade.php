<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 9/1/18
 * Time: 23:21
 */
?>
@extends('layouts.master')
@section('styles')
    @yield('styles-manage')
@stop
@section('content')
    @include('layouts.partials.list-with-search',
        [
        'idTable_DTS' => $idTable_DTS,
        ]
    )
@stop

@section('plugin-scripts')
    <script src="{{ asset('packages/theme/vendors/js/jquery.serializejson.min.js')}}"></script>
@endsection

@section('scripts')
    @yield('scripts-manage')
@stop

