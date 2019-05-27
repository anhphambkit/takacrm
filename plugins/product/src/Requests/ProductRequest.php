<?php

namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class ProductRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author AnhPham
     */
    public function rules()
    {
        $customAttributeRequest = app()->make(CustomAttributeServices::class)->parseRequestForCustomAttributeByConditions(
            [
                [
                    'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT)
                ]
            ]
        );
        return array_merge([
            'name' => 'required',
            'sku' => 'required',
            'category_id' => 'required',
            'manufacturer_id' => 'required',
            'image_gallery' => 'required',
            'image_feature' => 'required',
        ], $customAttributeRequest);
    }
}
