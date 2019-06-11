<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-11
 * Time: 20:59
 */
?>
<div class="card detail-info-product">
    <div class="card-header">
        <h4 class="card-title" id="relation-product-info">{{ trans('plugins-product::product.price_info') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collpase show">
        <div class="card-body">
            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.purchase_price') }}:
                </span>
                <span class="value-info">
                    {{ $product->purchase_price }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.retail_price') }}:
                </span>
                <span class="value-info">
                    {{ $product->retail_price }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.wholesale_price') }}:
                </span>
                <span class="value-info">
                    {{ $product->wholesale_price }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.online_price') }}:
                </span>
                <span class="value-info">
                    {{ $product->online_price }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.discount_percent') }}:
                </span>
                <span class="value-info">
                    {{ $product->discount_percent }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.wholesale_discount') }}:
                </span>
                <span class="value-info">
                    {!! $product->wholesale_discount !!}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.purchase_discount') }}:
                </span>
                <span class="value-info">
                    {!! $product->purchase_discount !!}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.online_discount') }}:
                </span>
                <span class="value-info">
                    {!! $product->online_discount !!}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.vat') }}:
                </span>
                <span class="value-info">
                    {{ $product->vat }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.is_feature') }}:
                </span>
                <span class="value-info">
                    {{ $product->is_feature ? 'True' : 'False' }}
                </span>
            </div>
        </div>
    </div>
</div>
