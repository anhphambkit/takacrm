<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-11
 * Time: 21:15
 */
$methodAttributeRelation = "{$customAttributeEntity->type_value}ValueAttributes";
$typeValue = ucfirst($customAttributeEntity->type_value);
$entityId = !empty($entityId) ? $entityId : 0;
$customAttributeEntityValues = $customAttributeEntity->{$methodAttributeRelation}->where('entity_id', (int)$entityId);
?>
<div class="info-item mb-2">
    <span class="info-title">
        {{ $customAttributeEntity->name }}:
    </span>
    <span class="value-info">
        @switch($customAttributeEntity->type_render)
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT, '_'))
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT, '_'))
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA, '_'))
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_SINGLE_SELECT, '_'))
                {{ $customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null }}
            @break

            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'))
                @if($customAttributeEntityValues->isNotEmpty())
                    <span class="minicolor-preview">
                        <span class="minicolor-square-box" style="background-color: {{ $customAttributeEntityValues->first()->value }};"></span>
                    </span>
                    <span class="customer-color-attr">{{ $customAttributeEntityValues->first()->value }}</span>
                @endif
            @break

            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT, '_'))
                <a href="{{ $customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : "#" }}" class="link-custom-attribute">{{ $customAttributeEntityValues->isNotEmpty() ? $customAttributeEntityValues->first()->value : null }}</a>
            @break

            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT, '_'))
                {{ $customAttributeEntityValues->isNotEmpty() ? ($customAttributeEntityValues->first()->value ? format_date_time($customAttributeEntityValues->first()->value, "Asia/Ho_Chi_Minh", "Y-m-d", "d/m/Y") : '') : null }}
            @break

            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT, '_'))
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX, '_'))
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_RADIO, '_'))
                @php
                    $customAttributeOptions = $customAttributeEntity->attributeOptions()->pluck('option_text', 'id');
                    $selectedOptions = [];
                    foreach ($customAttributeOptions as $customAttributeOptionId => $customAttributeOption) {
                        $customAttributeOptionValue = $customAttributeEntityValues->where('value', $customAttributeOptionId)->first();
                        if ($customAttributeOptionValue && $customAttributeOptionValue->value)
                            array_push($selectedOptions, $customAttributeOption);
                    }
                @endphp
                {{ implode(", ", $selectedOptions) }}
            @break
        @endswitch
    </span>
</div>
