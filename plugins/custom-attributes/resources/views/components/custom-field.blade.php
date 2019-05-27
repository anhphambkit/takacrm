<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-27
 * Time: 08:11
 */
$classFieldWrapper = (!empty($classFieldWrapper)) ? $classFieldWrapper : 'form-group col-md-12 mb-2';
$methodAttributeRelation = "{$customAttributeEntity->type_value}ValueAttributes";
$typeValue = ucfirst($customAttributeEntity->type_value);
$entityId = !empty($entityId) ? $entityId : 0;
$customAttributeEntityValues = $customAttributeEntity->$methodAttributeRelation()->select('*')->where('entity_id', (int)$entityId)->get();
?>
<div class="{{ $classFieldWrapper }} @if ($errors->has($customAttributeEntity->slug)) has-error @endif">
    <label class="control-label {{ ($customAttributeEntity->is_required) ? 'required' : '' }}" for="custom-attribute-{{$customAttributeEntity->slug}}">{{ $customAttributeEntity->name }}</label>
    @switch($customAttributeEntity->type_render)
        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT, '_'))
            {!! Form::text("cf_$customAttributeEntity->slug", !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null), ['class' => 'form-control', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT, '_'))
            {!! Form::number("cf_$customAttributeEntity->slug", !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null), ['class' => 'form-control', 'type' => 'number', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'))
            {!! Form::text("cf_$customAttributeEntity->slug", !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null), ['class' => 'form-control minicolors color-picker-custom', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name, 'data-counter' => 10, 'data-control' => "hue"]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA, '_'))
            {!! render_editor("cf_$customAttributeEntity->slug", !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null), true) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT, '_'))
            {!! Form::text("cf_$customAttributeEntity->slug", !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null), ['class' => 'form-control', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => 'http://example.com' ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT, '_'))
            {!! Form::text("cf_$customAttributeEntity->slug", !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? ($customAttributeEntityValues->first()->value ? format_date_time($customAttributeEntityValues->first()->value, "Asia/Ho_Chi_Minh", "Y-m-d", "d/m/Y") : '') : null),
            ['class' => 'form-control pickadate pick-date-time-custom-field', 'id' => "custom-attribute-{$customAttributeEntity->slug}", 'placeholder' => $customAttributeEntity->name ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_SINGLE_SELECT, '_'))
            @php
                $customAttributeEntityOptions = $customAttributeEntity->attributeOptions()->pluck('option_text', 'id')->toArray();
                $customAttributeEntityOptions = ['' => 'Select an option'] + $customAttributeEntityOptions;
            @endphp
            {!! Form::select("cf_$customAttributeEntity->slug", $customAttributeEntityOptions, !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null),
            ['class' => 'select2-placeholder form-control custom-attribute-select', "id" => "custom-attribute-{$customAttributeEntity->slug}" ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT, '_'))
            {!! Form::select("cf_{$customAttributeEntity->slug}[]", $customAttributeEntity->attributeOptions()->pluck('option_text', 'id'), !empty(old("cf_$customAttributeEntity->slug")) ? : ($customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->pluck('value') : []),
            [ 'class' => 'select2-placeholder-multiple form-control custom-attribute-select', "id" => "custom-attribute-{$customAttributeEntity->slug}", "multiple" => "multiple" ]) !!}
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX, '_'))
            @foreach($customAttributeEntity->attributeOptions()->pluck('option_text', 'id') as $customAttributeOptionId => $customAttributeOption)
                {!! Form::onOffPretty("cf_{$customAttributeEntity->slug}[{$customAttributeOptionId}]", !empty(old("cf_{$customAttributeEntity->slug}[{$customAttributeOptionId}]")) ? :
                ($customAttributeEntityValues->isNotEmpty() ? ($customAttributeEntityValues->where('value', $customAttributeOptionId)->first() ? $customAttributeEntityValues->where('value', $customAttributeOptionId)->first()->value : false) : false),
                ['id' => "checkbox-custom-attribute-{$customAttributeEntity->slug}-{$customAttributeOptionId}" ], "checkbox-custom-attribute-{$customAttributeEntity->slug}-{$customAttributeOptionId} checkbox-custom-attribute checkbox-custom-attribute-{$customAttributeEntity->slug}", $customAttributeOption) !!}
            @endforeach
            @break

        @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_RADIO, '_'))
            @foreach($customAttributeEntity->attributeOptions()->pluck('option_text', 'id') as $customAttributeOptionId => $customAttributeOption)
                {!! Form::radioPretty("cf_{$customAttributeEntity->slug}", !empty(old("cf_$customAttributeEntity->slug")) ? :
                ($customAttributeEntityValues->isNotEmpty() ? ($customAttributeEntityValues->where('value', $customAttributeOptionId)->first() ? $customAttributeEntityValues->where('value', $customAttributeOptionId)->first()->value : false) : false), $customAttributeOption, [], $customAttributeOptionId) !!}
            @endforeach
            @break

    @endswitch
    @if($customAttributeEntity->is_required)
        {!! Form::error("cf_{$customAttributeEntity->slug}", $errors) !!}
    @endif
</div>
