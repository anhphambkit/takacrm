<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-08
 * Time: 21:43
 */
$orderConditions = !empty($orderConditions) ? $orderConditions : (old('order_conditions') ? old('order_conditions') : [
    'Time to ship: ',
    'Address shipping: '
]);
?>
<script>
    let indexConditions = {{ sizeof($orderConditions) + 1 }};
</script>
<div class="condition-order-area">
    @foreach($orderConditions as $indexCondition => $orderCondition)
        @php
            $indexCondition += 1;
        @endphp
        <div class="row row-condition-order row-condition-order-{{ $indexCondition }}" id="row-condition-order-{{ $indexCondition }}" data-condition-index="{{ $indexCondition }}">
            <div class="form-group col-md-1 mb-2">
                <label for="order-condition-{{ $indexCondition }}">{{ $indexCondition }}</label>
            </div>
            <div class="form-group col-md-10 mb-2">
                <textarea rows=2 class="form-control order-condition order-condition-{{ $indexCondition }}" data-condition-index="{{ $indexCondition }}" id="order-condition-{{ $indexCondition }}" placeholder="Conditions" name="order_conditions[{{ $indexCondition }}]">{{ $orderCondition }}</textarea>
            </div>
            @if($indexCondition > 1)
                <div class="form-group col-md-1 mb-2 action-condition-order">
                    <button type="button" class="btn btn-sm btn-danger btn-delete-condition-order btn-delete-condition-order-{{ $indexCondition }}" id="btn-delete-condition-order-{{ $indexCondition }}" data-order-index="{{ $indexCondition }}"><i class="fa fa-trash"></i></button>
                </div>
            @endif
        </div>
    @endforeach
</div>
<button type="button" class="btn btn-sm btn-primary btn-add-condition-order">
    <i class="fa fa-plus"></i> {{ trans('plugins-order::order.add_note') }}
</button>
