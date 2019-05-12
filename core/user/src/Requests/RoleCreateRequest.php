<?php
namespace Core\User\Requests;
use Core\Master\Requests\CoreRequest;

class RoleCreateRequest extends CoreRequest
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:60|min:3',
            'description' => 'required|max:255',
        ];
    }
}
