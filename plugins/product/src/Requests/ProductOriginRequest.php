<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-15
 * Time: 05:33
 */
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class ProductOriginRequest extends CoreRequest
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
//            'logo' => 'required',
        ];
    }
}