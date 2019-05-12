<?php
namespace Core\User\Requests;
use Core\Master\Requests\CoreRequest;

class UpdatePasswordRequest extends CoreRequest
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (auth()->user()->isSuperUser()) {
            return [
                'password'              => 'required|min:6|max:60',
                'password_confirmation' => 'same:password',
            ];
        } else {
            return [
                'old_password'          => 'required|min:6|max:60',
                'password'              => 'required|min:6|max:60',
                'password_confirmation' => 'same:password',
            ];
        }
    }
}
