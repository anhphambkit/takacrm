<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-24
 * Time: 16:52
 */

namespace Plugins\Customer\Requests;


use Core\Master\Requests\CoreRequest;

class CustomerJobRequest extends CoreRequest
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
        ];
    }
}