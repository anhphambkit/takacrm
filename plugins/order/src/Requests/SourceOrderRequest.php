<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-06
 * Time: 04:03
 */

namespace Plugins\Order\Requests;

use Core\Master\Requests\CoreRequest;

class SourceOrderRequest extends CoreRequest
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
            'name' => 'required|unique:order_sources',
        ];
    }
}
