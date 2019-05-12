<?php

namespace Core\Slug\Requests;

use Core\Master\Requests\CoreRequest;

class SlugRequest extends CoreRequest
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
            'name'    => 'required',
        ];
    }
}