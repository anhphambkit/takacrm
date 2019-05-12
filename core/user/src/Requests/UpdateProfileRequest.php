<?php
namespace Core\User\Requests;
use Core\Master\Requests\CoreRequest;

class UpdateProfileRequest extends CoreRequest
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->route()->parameter('id');
        
        return [
            'username'          => "required|max:30|min:4|unique:users,username,{$userId}",
            'first_name'        => 'required|max:60|min:2',
            'last_name'         => 'required|max:60|min:2',
            'email'             => "required|max:60|min:6|email|unique:users,email,{$userId}",
            'dob'               => 'date',
            'address'           => 'max:255',
            'secondary_address' => 'max:255',
            'job_position'      => 'max:255',
            'phone'             => 'max:15',
            'secondary_phone'   => 'max:15',
            'secondary_email'   => 'max:255',
            'gender'            => 'max:255',
            'website'           => 'max:255',
            'skype'             => 'max:255',
            'facebook'          => 'max:255',
            'twitter'           => 'max:255',
            'google_plus'       => 'max:255',
            'youtube'           => 'max:255',
            'github'            => 'max:255',
            'interest'          => 'max:255',
            'about'             => 'max:400',
        ];
    }
}
