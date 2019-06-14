<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-11
 * Time: 22:16
 */
?>
@extends('layouts.front-end')
@section('content')
    <div class="product-detail container">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <div class="info-product">
                        <span class="product-avatar">
                            <img src="{{ asset($product->image_feature) }}" alt="avatar" class="thumbnail-product">
                        </span>
                        <span class="product-name-info ml-2">
                            <span class="product-name text-bold-700">{{ $product->name }}</span>
                        </span>
                    </div>
                    <div class="info-product mt-2">
                        <span class="price-title">{{ trans('plugins-product::product.form.online_price') }}: </span>
                        <span class="online-price">{{ $product->online_price ? $product->online_price : trans('core-base::base.contact') }}</span>
                    </div>
                </div>
            </div>

            <div class="card card-form-order">
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(['route' => 'public.order.new']) !!}
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_name')) has-error @endif">
                                <label for="name">{{ trans('core-base::forms.name') }}</label>
                                {!! Form::text('customer_name', old('customer_name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name'), 'data-counter' => 120]) !!}
                                {!! Form::error('customer_name', $errors) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_email')) has-error @endif">
                                <label for="email">{{ trans('core-base::forms.email') }}</label>
                                {!! Form::text('customer_email', old('customer_email'), ['class' => 'form-control', 'id' => 'email', 'type' => 'email', 'placeholder' => trans('core-base::forms.email'), 'data-counter' => 120]) !!}
                                {!! Form::error('customer_email', $errors) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_phone')) has-error @endif">
                                <label for="phone">{{ trans('core-base::forms.phone') }}</label>
                                {!! Form::text('customer_phone', old('customer_phone'), ['class' => 'form-control', 'id' => 'phone', 'placeholder' => trans('core-base::forms.phone'), 'data-counter' => 120]) !!}
                                {!! Form::error('customer_phone', $errors) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 mb-2 @if ($errors->has('customer_address')) has-error @endif">
                                <label for="address">{{ trans('core-base::forms.address') }}</label>
                                {!! Form::text('customer_address', old('customer_address'), ['class' => 'form-control', 'id' => 'address', 'placeholder' => trans('core-base::forms.address'), 'data-counter' => 120]) !!}
                                {!! Form::error('customer_address', $errors) !!}
                            </div>
                        </div>
                        @include('plugins-product::tables.product-landing-page')
                        <div class="row">
                            <div class="col-md-12 text-center mt-2">
                                <button type="submit" name="submit" value="save" class="btn btn-info btn-submit-order">
                                    <i class="fa fa-save"></i> {{ trans('core-base::forms.order') }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop