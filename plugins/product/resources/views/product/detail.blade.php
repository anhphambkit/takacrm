@extends('layouts.master')
@section('content')
    <div class="row top-header-product">
        <div class="col-md-12">
            @include('plugins-product::partials.info-header-product')
        </div>
    </div>
    <div class="row box-product-info">
        <div class="col-md-3 left-info-product">
            @include('plugins-product::partials.gallery-slider-card')
            @include('plugins-product::partials.general-product-info')
            @include('plugins-product::partials.price-product-info')
            @include('plugins-product::partials.custom-attribute-product-info')
        </div>
        <div class="col-md-6 middle-info-product">
            @include('plugins-product::partials.product-info-tabs')
        </div>
        <div class="col-md-3 right-info-product">
            @include('plugins-product::partials.info-log-history-product')
        </div>
    </div>
@stop

@section('variable-scripts')
    <script>
        const API = {
            {{--LIST_CUSTOMER_URL : "{{ route('admin.product.list') }}",--}}
            {{--UPDATE_CUSTOMER : "{{ route('ajax.admin.update_data_relation_of_product') }}",--}}
        }
    </script>

@stop

@section('master-footer')
<script type="text/javascript">
    $(document).ready(function(){
        //TODO HERE
        var historyHeight = $('#log-history-product').height();
        if(historyHeight > 600){
            $('#log-history-product').css({
                "max-height":'600px',
                "overflow": 'scroll'
            });
        }
    })
</script>
@stop
