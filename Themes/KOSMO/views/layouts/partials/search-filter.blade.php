<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 9/2/18
 * Time: 08:27
 */
$classWrapSearch_SF = isset($classWrapSearch_SF) ? $classWrapSearch_SF : '';
$idSearchFilter_SF = isset($idSearchFilter_SF) ? $idSearchFilter_SF : '';
$classSearchForm_SF = isset($classSearchForm_SF) ? $classSearchForm_SF : '';
$idSearchForm_SF = isset($idSearchForm_SF) ? $idSearchForm_SF : '';
?>
<div class="card {{ $classWrapSearch_SF }}" id="{{ $idSearchFilter_SF }}">
    <div class="card-block">
        <h5 class="card-title">@yield('titleSearchFilter')</h5>
        <form class="search-form {{ $classSearchForm_SF }}" id="{{ $idSearchForm_SF }}">
            @section('contentSearchFilter')
            @show
            <div class="row row-search-form">
                @section('btnSearchFilter')
                    <fieldset class="col-sm-5 btn-search">
                        @component('theme::components.button')
                            @slot('id', 'btn-search-standard')
                            @slot('type', 'button')
                            @slot('class','btn-primary')
                            @slot('label', trans('theme::theme.default_title.search'))
                            @slot('attributes', ['data-search-control' => 'search'])
                        @endcomponent
                        @component('theme::components.button')
                            @slot('id', 'btn-clear-standard')
                            @slot('type', 'button')
                            @slot('class','btn-cancel')
                            @slot('label', trans('theme::theme.default_title.clear'))
                            @slot('attributes', ['data-search-control' => 'clear'])
                        @endcomponent
                    </fieldset>
                @show
            </div>
        </form>
    </div>
</div>
