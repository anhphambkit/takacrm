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

    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER                        = 'TYPE_RENDER_CUSTOM_ATTRIBUTE';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING                 = 'String';
    const REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER           = 'Color Picker';
}