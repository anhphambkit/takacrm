<?php

namespace Plugins\Tenant\Requests;

use Core\Master\Requests\CoreRequest;

class TenantRequest extends CoreRequest
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
            'host_name' => 'required|string|unique:tenants',
            'username' => 'required|string',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
