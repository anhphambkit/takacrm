<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-29
 * Time: 07:49
 */
?>
<table class="table table-products-order">
    <thead>
    <tr>
        <th class="width-5-per">#</th>
        <th class="width-30-per">{{ trans('plugins-order::order.table.product') }}</th>
        <th class="width-5-per">{{ trans('plugins-order::order.table.product_code') }}</th>
        <th class="width-5-per">{{ trans('plugins-order::order.table.unit') }}</th>
        <th class="width-5-per">{{ trans('plugins-order::order.table.quantity') }}</th>
        <th class="width-15-per">{{ trans('plugins-order::order.table.price') }}</th>
        <th class="width-5-per">{{ trans('plugins-order::order.table.vat_percent') }}</th>
        <th class="width-15-per">{{ trans('plugins-order::order.table.discount') }}</th>
        <th class="width-5-per">{{ trans('plugins-order::order.table.discount_percent') }}</th>
        <th class="width-15-per">{{ trans('plugins-order::order.table.total_price') }}</th>
        <th class="width-5-per">{{ trans('plugins-order::order.table.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td scope="row">1</td>
        <td>
            <div class="input-group">
                {!! Form::select('product_in_order[]', [], old('product_in_order'), ['class' => 'custom-select select2-placeholder-single form-control product-order-list', "id" => "select-product-order-list" ]) !!}
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </td>
        <td>
            ----
        </td>
        <td>--</td>
        <td>
            {!! Form::text('quantity', old('quantity'), ['class' => 'form-control', 'id' => 'quantity', 'placeholder' => trans('plugins-order::order.table.quantity')]) !!}
        </td>
        <td>
            {!! Form::text('price', old('price'), ['class' => 'form-control', 'id' => 'price', 'placeholder' => trans('plugins-order::order.table.price')]) !!}
        </td>
        <td>
            {!! Form::text('vat_percent', old('vat_percent'), ['class' => 'form-control', 'id' => 'vat_percent', 'placeholder' => trans('plugins-order::order.table.vat_percent')]) !!}
        </td>
        <td>
            {!! Form::text('discount', old('discount'), ['class' => 'form-control', 'id' => 'discount', 'placeholder' => trans('plugins-order::order.table.discount')]) !!}
        </td>
        <td>
            {!! Form::text('discount_percent', old('discount_percent'), ['class' => 'form-control', 'id' => 'discount_percent', 'placeholder' => trans('plugins-order::order.table.discount_percent')]) !!}
        </td>
        <td>
            {!! Form::text('total_price', old('total_price'), ['class' => 'form-control', 'id' => 'total_price', 'placeholder' => trans('plugins-order::order.table.total_price')]) !!}
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <th>
            <button type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Thêm sản phẩm
            </button>
        </th>
    </tr>
    </tfoot>
</table>
