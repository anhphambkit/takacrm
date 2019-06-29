<?php
/**
 * Created by PhpStorm.
 * User: Tu Nguyen
 * Date: 2019-05-24
 * Time: 23:04
 */

namespace Plugins\Order\Requests;

use Core\Master\Requests\CoreRequest;

class PaymentMethodRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Tu Nguyen
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
