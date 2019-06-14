<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-15
 * Time: 00:07
 */

namespace Plugins\Order\Requests;

use Core\Master\Requests\CoreRequest;

class OrderLandingPageRequest extends CoreRequest
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
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'order_products' => 'required',
        ];
    }
}