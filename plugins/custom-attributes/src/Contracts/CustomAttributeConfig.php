<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 07:34
 */

namespace Plugins\CustomAttributes\Contracts;


interface CustomAttributeConfig
{
    /* Reference custom attribute */
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY                        = 'TYPE_ENTITY_CUSTOM_ATTRIBUTE';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT                = 'Product';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER               = 'Customer';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER                  = 'Order';

    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER                        = 'TYPE_RENDER_CUSTOM_ATTRIBUTE';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT             = 'Text Input';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA               = 'Text Area';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT           = 'Number Input';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX               = 'Checkbox';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_RADIO                  = 'Radio';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_SINGLE_SELECT          = 'Single Select';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT        = 'Multiple Select';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT              = 'Url Input';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT        = 'Date Input';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER           = 'Color Picker';

    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_STRING                  = 'string';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_TEXT                    = 'text';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_NUMBER                  = 'number';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_DATE                    = 'date';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_OPTION                  = 'option';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUES                        = [
        'string',
        'text',
        'number',
        'date',
        'option',
    ];
}