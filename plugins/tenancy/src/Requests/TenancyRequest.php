<?php

namespace Plugins\Tenancy\Requests;

use Core\Master\Requests\CoreRequest;

class TenancyRequest extends CoreRequest
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
            'tenancy_name' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
