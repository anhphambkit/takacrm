<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-26
 * Time: 23:44
 */

namespace Plugins\Product\Requests;


use Core\Master\Requests\CoreRequest;

class ProductSpaceRequest extends CoreRequest
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