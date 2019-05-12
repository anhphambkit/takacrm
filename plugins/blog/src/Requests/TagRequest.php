<?php

namespace Plugins\Blog\Requests;

use Core\Master\Requests\CoreRequest;

class TagRequest extends CoreRequest
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
            'name'        => 'required|max:120',
            'slug'        => 'required|max:120',
            'description' => 'max:400',
        ];
    }
}
