<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-29
 * Time: 15:36
 */

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;

class CustomerRelationRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author AnhPham
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'color_code' => 'required',
        ];
    }
}