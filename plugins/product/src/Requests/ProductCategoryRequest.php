<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-22
 * Time: 00:16
 */

namespace Plugins\Product\Requests;


use Core\Master\Requests\CoreRequest;

class ProductCategoryRequest extends CoreRequest
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
            'image_feature' => 'required',
        ];
    }
}