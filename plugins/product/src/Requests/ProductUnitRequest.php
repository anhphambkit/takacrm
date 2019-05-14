<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-12
 * Time: 23:04
 */

namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class ProductUnitRequest extends CoreRequest
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