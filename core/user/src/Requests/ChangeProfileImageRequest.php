<?php
namespace Core\User\Requests;
use Core\Master\Requests\CoreRequest;

class ChangeProfileImageRequest extends CoreRequest
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar_file' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
