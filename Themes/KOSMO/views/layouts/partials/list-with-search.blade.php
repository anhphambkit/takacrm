<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 9/1/18
 * Time: 23:21
 */
$extendLayout = isset($extendLayout) ? $extendLayout : true;
?>
<style>
    .row-search-form {
        margin-bottom: 0 !important;
        margin-top: 0 !important;
    }
</style>
@if($extendLayout)
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>@yield('titlePage')</h3>
        </section>
    </div>
    <div class="ks-page-content">
        <div class="ks-page-content-body ">
            <div class="ks-nav-body-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 ks-panels-column-section">
                            @include('layouts.partials.search-filter')
                        </div>
                    </div>
                    <div class="row">
                        @section('btn-others')
                        @show
                    </div>
                    <div class="row">
                        <div class="col-lg-12 ks-panels-column-section">
                            <div class="ks-user-list-view-table">
                                    @component('components.data-table-standard', ['idTable_DTS' => $idTable_DTS])
                                    @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="">
        <div class="row">
            <div class="col-lg-12 ks-panels-column-section">
                @include('layouts.partials.search-filter')
            </div>
        </div>
        <div class="row">
            @section('btn-others')
            @show
        </div>
        <div class="row">
            <div class="col-lg-12 ks-panels-column-section">
                <div class="ks-user-list-view-table">
                    @component('components.data-table-standard', ['idTable_DTS' => $idTable_DTS])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endif
@section('area-modals')
@show

