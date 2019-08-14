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
        $tenantId = $this->route()->parameter('id');
        if (!empty($tenantId)) {
            return [
                'host_name' => "required|string|unique_tenant:tenants,db_name,{$tenantId}",
            ];
        }
        else return [
            'host_name' => "required|string|unique_tenant:tenants,db_name",
            'username' => 'required|string',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
