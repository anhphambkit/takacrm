<?php

namespace Plugins\Newsletter\Requests;

use Core\Master\Requests\CoreRequest;

class NewsletterRequest extends CoreRequest
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
            'email' => 'required|email|unique:newsletter,email',
        ];
    }
}
