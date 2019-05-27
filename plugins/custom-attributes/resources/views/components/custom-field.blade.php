<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-27
 * Time: 08:11
 */
$classFieldWrapper = (!empty($classFieldWrapper)) ? $classFieldWrapper : 'form-group col-md-12 mb-2';
?>
<div class="{{ $classFieldWrapper }} @if ($errors->has($customAttributeEntity->slug)) has-error @endif">
    <label class="control-label {{ ($customAttributeEntity->is_required) ? 'required' : '' }}" for="custom-attribute-{{$customAttributeEntity->slug}}">{{ $customAttributeEntity->name }}</label>
    @switch($customAttributeEntity->type_render)
        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT, '_'))
            {!! Form::text($customAttributeEntity->slug, old($customAttributeEntity->slug), ['class' => 'form-control', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT, '_'))
            {!! Form::number($customAttributeEntity->slug, old($customAttributeEntity->slug), ['class' => 'form-control', 'type' => 'number', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'))
            {!! Form::text($customAttributeEntity->slug, old($customAttributeEntity->slug), ['class' => 'form-control minicolors color-picker-custom', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name, 'data-counter' => 10, 'data-control' => "hue"]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA, '_'))
            {!! render_editor($customAttributeEntity->slug, old($customAttributeEntity->slug), true) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT, '_'))
            {!! Form::text($customAttributeEntity->slug, old($customAttributeEntity->slug), ['class' => 'form-control', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => 'http://example.com' ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT, '_'))
            {!! Form::text($customAttributeEntity->slug, old($customAttributeEntity->slug), ['class' => 'form-control pickadate pick-date-time-custom-field', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name ]) !!}
            @break

    @endswitch
    @if($customAttributeEntity->is_required)
        {!! Form::error($customAttributeEntity->slug, $errors) !!}
    @endif
</div>
