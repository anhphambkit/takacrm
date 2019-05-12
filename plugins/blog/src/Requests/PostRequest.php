<?php

namespace Plugins\Blog\Requests;

use Core\Master\Requests\CoreRequest;

class PostRequest extends CoreRequest
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
            'name'        => 'required|max:255',
            'description' => 'max:400',
            'categories'  => 'required',
            'slug'        => 'required|max:255',
        ];
    }
}
