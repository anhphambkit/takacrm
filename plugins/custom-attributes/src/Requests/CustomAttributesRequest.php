<?php

namespace Plugins\CustomAttributes\Requests;

use Core\Master\Requests\CoreRequest;

class CustomAttributesRequest extends CoreRequest
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
            'name' => 'required',
            'type_render' => 'required',
        ];
    }
}
