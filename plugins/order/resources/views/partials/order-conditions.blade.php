<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-08
 * Time: 21:43
 */
$orderConditions = !empty($orderConditions) ? array_values($orderConditions) : (old('order_conditions') ? old('order_conditions') : [
    'Time to ship: ',
    'Address shipping: '
]);
?>
<script>
    let indexConditions = {{ sizeof($orderConditions) + 1 }};
</script>
<div class="condition-order-area">
    @foreach($orderConditions as $indexOrderCondition => $orderCondition)
        @php
            $indexOrderCondition++;
        @endphp
        <div class="row row-condition-order row-condition-order-{{ $indexOrderCondition }}" id="row-condition-order-{{ $indexOrderCondition }}" data-condition-index="{{ $indexOrderCondition }}">
            <div class="form-group col-md-1 mb-2">
                <label for="order-condition-{{ $indexOrderCondition }}">{{ $indexOrderCondition }}</label>
            </div>
            <div class="form-group col-md-10 mb-2">
                <textarea rows=2 class="form-control order-condition order-condition-{{ $indexOrderCondition }}" data-condition-index="{{ $indexOrderCondition }}" id="order-condition-{{ $indexOrderCondition }}" placeholder="Conditions" name="order_conditions[{{ $indexOrderCondition }}]">{{ $orderCondition }}</textarea>
            </div>
            @if($indexOrderCondition > 1)
                <div class="form-group col-md-1 mb-2 action-condition-order">
                    <button type="button" class="btn btn-sm btn-danger btn-delete-condition-order btn-delete-condition-order-{{ $indexOrderCondition }}" id="btn-delete-condition-order-{{ $indexOrderCondition }}" data-order-index="{{ $indexOrderCondition }}"><i class="fa fa-trash"></i></button>
                </div>
            @endif
        </div>
    @endforeach
</div>
<button type="button" class="btn btn-sm btn-primary btn-add-condition-order">
    <i class="fa fa-plus"></i> {{ trans('plugins-order::order.add_note') }}
</button>
