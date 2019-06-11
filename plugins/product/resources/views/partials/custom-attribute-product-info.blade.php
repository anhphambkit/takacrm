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
        <h4 class="card-title" id="relation-product-info">{{ trans('plugins-product::product.custom_attributes') }}</h4>
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
            @foreach($allProductCustomAttributes as $allProductCustomAttribute)
                @component('plugins-custom-attributes::components.info-custom-attribute')
                    @slot('customAttributeEntity', $allProductCustomAttribute)
                    @slot('entityId', $product->id)
                @endcomponent
            @endforeach
        </div>
    </div>
</div>
