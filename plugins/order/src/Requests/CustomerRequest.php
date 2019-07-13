<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-06
 * Time: 04:03
 */

namespace Plugins\Order\Requests;

use Core\Master\Requests\CoreRequest;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class CustomerRequest extends CoreRequest
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
                    'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER)
                ]
            ]
        );

        return array_merge([
            'email'      => 'required|max:60|min:6|email|unique:customers',
            'full_name'   => 'required|max:120',
            'customer_contact.*.full_name'   => 'required|max:120',
            'customer_contact.*.email'   => 'required|max:120',
        ], $customAttributeRequest);
    }

    public function messages()
    {
        return [
            'customer_contact.*.full_name'   => 'The Full Name of contact is required field!'
        ];
    }
}
