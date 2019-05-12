<?php
namespace Core\User\Requests;
use Core\Master\Requests\CoreRequest;

class CreateUserRequest extends CoreRequest
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'            => 'required|max:60|min:2',
            'last_name'             => 'required|max:60|min:2',
            'email'                 => 'required|max:60|min:6|email|unique:users',
            'role_id'               => 'required',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'username'              => 'required|min:4|max:30|unique:users',
        ];
    }
}
