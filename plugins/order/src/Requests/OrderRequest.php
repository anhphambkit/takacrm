<?php

namespace Plugins\Order\Requests;

use Core\Master\Requests\CoreRequest;

class OrderRequest extends CoreRequest
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
            'user_performed_id' => 'required',
            'order_products' => 'required',
        ];
    }
}
