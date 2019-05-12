<?php
namespace Core\User\Requests;
use Core\Master\Requests\CoreRequest;

class PostAssignRoleRequest extends CoreRequest
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pk' => 'required|numeric|exists:users,id',
            'value' => 'required|numeric|exists:roles,id',
        ];
    }
}
