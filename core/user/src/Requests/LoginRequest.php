<?php
namespace Core\User\Requests;
use Core\Master\Requests\CoreRequest;

class LoginRequest extends CoreRequest
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
