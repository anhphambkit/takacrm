<?php
$optionText = !empty($optionText) ? $optionText : '';
?>

<div class="onoffswitch pretty p-icon p-round p-pulse {{ $classSwitch }} checkbox-on-off-custom mb-1" style="display: block;">
    <input type="checkbox" name="{{ $name }}" class="onoffswitch-checkbox" id="{{ $name }}" value="1" @if ($value) checked @endif {!! html_attributes_builder($attributes) !!}>
    <div class="state p-success">
        <i class="icon fas fa-check"></i>
        <label class="onoffswitch-label on-off-label" for="{{ $name }}">{{ $optionText }}</label>
    </div>
</div>