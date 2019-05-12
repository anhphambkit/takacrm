<?php

namespace Plugins\Newsletter\Requests;

use Core\Master\Requests\CoreRequest;

class UpdateLetterRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        $letterId = $this->route()->parameter('id');

        return [
            'email' => "required|email|unique:newsletter,email,{$letterId}",
        ];
    }
}
