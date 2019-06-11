<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-11
 * Time: 20:48
 */
?>
<div class="card detail-info-product">
    <div class="card-header">
        <h4 class="card-title" id="relation-product-info">{{ trans('plugins-product::product.general') }}</h4>
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
                    {{ trans('core-base::forms.name') }}:
                </span>
                <span class="value-info">
                    {{ $product->name }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.sku') }}:
                </span>
                <span class="value-info">
                    {{ $product->sku }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('core-base::forms.parent_category') }}:
                </span>
                <span class="value-info">
                    {{ $product->category_name }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.manufacturer') }}:
                </span>
                <span class="value-info">
                    {{ $product->manufacturer_name }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.units') }}:
                </span>
                <span class="value-info">
                    {{ $product->unit_name }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.origins') }}:
                </span>
                <span class="value-info">
                    {{ $product->origin_name }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.short_description') }}:
                </span>
                <span class="value-info">
                    {!! $product->short_description !!}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('plugins-product::product.form.long_desc') }}:
                </span>
                <span class="value-info">
                    {!! $product->long_desc !!}
                </span>
            </div>
        </div>
    </div>
</div>
