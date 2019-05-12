<?php

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;

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
        return [
            'email'      => 'required|max:60|min:6|email|unique:customers',
            'full_name'   => 'required|max:120',
            'customer_contact.*.full_name'   => 'required|max:120',
        ];
    }

    public function messages()
    {
        return [
            'customer_contact.*.full_name'   => 'The Full Name of contact is required field!'
        ];
    }
}
