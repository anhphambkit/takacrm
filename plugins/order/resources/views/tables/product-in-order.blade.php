<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-29
 * Time: 07:49
 */
$orderProducts = !empty($orderProducts) ? $orderProducts : (old('order_products') ? old('order_products') : []);
?>
<script>
    let index = {{ sizeof($orderProducts) + 1 }};
</script>
<table class="table table-products-order">
    <thead>
    <tr>
        <th class="width-2-per text-center">#</th>
        <th class="width-40-per">{{ trans('plugins-order::order.table.product') }}</th>
        <th class="width-7-per">{{ trans('plugins-order::order.table.product_code') }}</th>
        <th class="width-7-per">{{ trans('plugins-order::order.table.unit') }}</th>
        <th class="width-2-per">{{ trans('plugins-order::order.table.quantity') }}</th>
        <th class="width-15-per">{{ trans('plugins-order::order.table.price') }}</th>
        <th class="width-2-per">{{ trans('plugins-order::order.table.vat_percent') }}</th>
        <th class="width-2-per">{{ trans('plugins-order::order.table.discount_percent') }}</th>
        <th class="width-10-per">{{ trans('plugins-order::order.table.discount') }}</th>
        <th class="width-15-per">{{ trans('plugins-order::order.table.total_price') }}</th>
        <th class="width-2-per">{{ trans('plugins-order::order.table.actions') }}</th>
    </tr>
    </thead>
    <tbody class="table-body-order-product">
       @foreach($orderProducts as $index => $orderProduct)
           <tr class="row-product-order row-product-order-{{ $index }}" id="row-product-order-{{ $index }}" data-product-index="{{ $index }}">
               <td scope="row" class="text-center">{{ $index + 1 }}</td>
               <td class="product-basic-info product-basic-info-{{ $index }}" id="product-basic-info-{{ $index }}">
                   <div class="input-group select-order-product select-order-product-{{ $index }}" data-product-index="{{ $index }}">
                       <select class='custom-select select2-placeholder-single form-control product-order-list product-order-list-{{ $index }}' name='order_products[{{ $index }}][id]' data-product-index="{{ $index }}" data-value="{{ $orderProduct['id'] }}">
                            @php
                                $optionProductListHtml = "";
                                foreach($products as $product) {
                                    $categoryName = ($product->productCategory) ? $product->productCategory->name : '';
                                    $selected = ($orderProduct['id'] === $product->id) ? 'selected' : '';
                                    $optionProductListHtml .= "<option {$selected} value='{$product->id}' data-name='{$product->name}' data-short-description='{$product->short_description}' data-id='{$product->id}' data-sku='{$product->sku}' data-image='{$product->image_feature}' data-retail-price='{$product->retail_price}' data-category='{$categoryName}' data-unit='{$product->unit}'>{$product->name}</option>";
                                }
                            @endphp
                           {!! $optionProductListHtml !!}
                       </select>
                       <div class="input-group-prepend">
                           <button class="btn btn-outline-secondary btn-add-short-description-for-product btn-add-short-description-for-product-{{ $index }}" type="button" data-toggle="collapse" data-target="#collapse-product-short-description-{{ $index }}" aria-expanded="false" aria-controls="collapse-product-short-description-{{ $index }}">
                               <i class="fa fa-plus"></i>
                           </button>
                       </div>
                   </div>
                   <div class="collapse collapse-product-short-description" id="collapse-product-short-description-{{ $index }}">
                       <textarea class="product-short-description form-control product-short-description-{{ $index }}" placeholder="Note" id="product-short-description-{{ $index }}" name="order_products[{{ $index }}][short_description]">{{ $orderProduct['short_description'] }}</textarea>
                   </div>
               </td>
               <td>
                   <input type="text" class="form-control product-sku product-sku-{{ $index }}" value="{{ $orderProduct['sku'] }}" data-product-index="{{ $index }}" readonly="readonly" id="product-sku-{{ $index }}" placeholder="SKU" name="order_products[{{ $index }}][sku]" />
               </td>
               <td>
                   <input type="text" class="form-control product-unit product-unit-{{ $index }}" data-product-index="{{ $index }}" value="{{ $orderProduct['unit_name'] }}" readonly="readonly" id="product-unit-{{ $index }}" placeholder="Unit" name="order_products[{{ $index }}][unit_name]" />
               </td>
               <td>
                   <input type="text" class="form-control product-quantity product-quantity-{{ $index }}" data-product-index="{{ $index }}" value="{{ $orderProduct['quantity'] }}" id="product-quantity-{{ $index }}" placeholder="Quantity" name="order_products[{{ $index }}][quantity]" />
               </td>
               <td>
                   <input type="text" class="form-control product-price product-retail-price-{{ $index }}" data-product-index="{{ $index }}" value="{{ $orderProduct['retail_price'] }}" id="product-retail-price-{{ $index }}" placeholder="Price" name="order_products[{{ $index }}][retail_price]" />
               </td>
               <td>
                   <input type="text" class="form-control product-vat product-vat-{{ $index }}" data-product-index="{{ $index }}" value="{{ $orderProduct['vat'] }}" id="product-vat-{{ $index }}" placeholder="VAT" name="order_products[{{ $index }}][vat]" />
               </td>
               <td>
                   <input type="text" class="form-control product-discount-percent product-discount-percent-{{ $index }}" value="{{ $orderProduct['discount_percent'] }}" data-product-index="{{ $index }}" id="product-discount-percent-{{ $index }}" placeholder="Discount percent" name="order_products[{{ $index }}][discount_percent]" />
               </td>
               <td>
                   <input type="text" class="form-control product-discount product-discount-{{ $index }}" value="{{ $orderProduct['discount'] }}" data-product-index="{{ $index }}" id="product-discount-{{ $index }}" placeholder="Discount" name="order_products[{{ $index }}][discount]" />
               </td>
               <td>
                   <input type="text" class="form-control product-total-price product-total-price-{{ $index }}" value="{{ $orderProduct['total_price'] }}" data-product-index="{{ $index }}" readonly="readonly" id="product-total-price-{{ $index }}" placeholder="Total price" name="order_products[{{ $index }}][total_price]" />
               </td>
               <td>
                   <button type="button" class="btn btn-sm btn-danger btn-delete-row-product btn-delete-row-product-{{ $index }}" id="btn-delete-row-product-{{ $index }}" data-product-index="{{ $index }}"><i class="fa fa-trash"></i></button>
               </td>
           </tr>
       @endforeach
    </tbody>
</table>
<button type="button" class="btn btn-sm btn-primary btn-add-order-product">
    <i class="fa fa-plus"></i> {{ trans('plugins-order::order.add_product') }}
</button>
