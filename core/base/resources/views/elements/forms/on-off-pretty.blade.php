<div class="onoffswitch pretty p-icon p-round p-pulse {{ $classSwitch }}" style="display: block;">
    <input type="checkbox" name="{{ $name }}" class="onoffswitch-checkbox" id="{{ $name }}" value="1" @if ($value) checked @endif {!! html_attributes_builder($attributes) !!}>
    <div class="state p-success">
        <i class="icon fas fa-check"></i>
        <label class="onoffswitch-label" for="{{ $name }}"></label>
    </div>
</div>