<?php

namespace Plugins\Order\Requests;

use Core\Master\Requests\CoreRequest;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class OrderRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        $customAttributeRequest = app()->make(CustomAttributeServices::class)->parseRequestForCustomAttributeByConditions(
            [
                [
                    'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER)
                ]
            ]
        );
        return array_merge([
            'user_performed_id' => 'required',
            'order_products' => 'required',
        ], $customAttributeRequest);
    }
}
