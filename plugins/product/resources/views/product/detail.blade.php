@extends('layouts.master')
@section('content')
    <div class="product-detail">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <div class="row">
                        <div class="col-4">
                            <div class="product-img d-flex align-items-center slider slider-for">
                                <div>
                                    <img alt="Card image cap" class="img-fluid mb-1" src="{{ asset($product->image_feature) }}">
                                </div>
                                @if($product->galleries)
                                    @foreach($product->galleries as $galery)
                                        <div>
                                            <img class="img-fluid" src="{{ asset($galery->media) }}" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="slider slider-nav">
                                <div>
                                    <img alt="Card image cap" class="img-fluid mb-1" src="{{ asset($product->image_feature) }}">
                                </div>
                                @if($product->galleries)
                                    @foreach($product->galleries as $galery)
                                        <div>
                                            <img class="img-fluid" src="{{ asset($galery->media) }}" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="title-area clearfix">
                                <h2 class="product-title float-left">
                                    {{ $product->name }}
                                </h2>

                            </div>
                            <div class="price-reviews clearfix">
                            <!--span class="price-box">
                                <span class="price h4">
                                    $250
                                </span>
                                <span class="old-price h4">
                                    $500
                                </span>
                            </span-->

                            </div>
                            <!-- Product Information -->
                            <div class="product-info">
                                {!! $product->short_description !!}
                            </div>
                            <!-- Product Information Ends-->
                            <!-- Color Options -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-options color-options mb-2">
                                        <dl class="row">
                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.sku') }}: </dt>
                                            <dd class="col-sm-9">{{ $product->sku }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.category') }}: </dt>
                                            <dd class="col-sm-9">{{ $product->productCategory->name }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.origins') }}: </dt>
                                            <dd class="col-sm-9">{{ $product->productOrigin->name }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.manufacturer') }}: </dt>
                                            <dd class="col-sm-9">{{ $product->productManufacturer->name }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.retail_price') }}</dt>
                                            <dd class="col-sm-9">{{ number_format($product->retail_price, 0, ',','.') }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.vat') }}: </dt>
                                            <dd class="col-sm-9">{{ $product->vat.'%' }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.wholesale_price') }}:</dt>
                                            <dd class="col-sm-9">{{ number_format($product->wholesale_price, 0, ',','.') }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.online_price') }}: </dt>
                                            <dd class="col-sm-9">{{ number_format($product->online_price, 0, ',','.') }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.purchase_price') }}:</dt>
                                            <dd class="col-sm-9">{{ number_format($product->purchase_price, 0, ',','.') }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.discount') }}:</dt>
                                            <dd class="col-sm-9">{{ $product->discount.'%' }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.wholesale_discount') }}:</dt>
                                            <dd class="col-sm-9">{{ $product->wholesale_discount.'%' }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.purchase_discount') }}:</dt>
                                            <dd class="col-sm-9">{{ $product->purchase_discount.'%' }}</dd>

                                            <dt class="col-sm-3">{{ trans('plugins-product::product.form.online_discount') }}:</dt>
                                            <dd class="col-sm-9">{{ $product->online_discount.'%' }}</dd>


                                        </dl>

                                    </div>
                                </div>

                            </div>
                            <!-- Color Options Ends-->
                            <!-- Size Options Ends-->

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <ul class="product-tabs nav nav-tabs nav-underline no-hover-bg">
                            <li class="nav-item">
                                <a aria-controls="desc" aria-expanded="true" class="nav-link active" data-toggle="tab" href="#desc" id="description">
                                    Description
                                </a>
                            </li>


                        </ul>
                        <div class="product-content tab-content px-1 pt-1">
                            <div aria-expanded="true" aria-labelledby="description" class="tab-pane active" id="desc" role="tabpanel">
                                <h2 class="my-1">
                                    {{ $product->name }}
                                </h2>
                                {!! $product->long_desc !!}
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
