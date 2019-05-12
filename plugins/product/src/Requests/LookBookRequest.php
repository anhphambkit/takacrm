<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-22
 * Time: 00:15
 */

namespace Plugins\Product\Requests;


use Core\Master\Requests\CoreRequest;

class LookBookRequest extends CoreRequest
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
            'image' => 'required',
            'tag' => 'required',
            'all_space' => 'required_without:space_business',
            'space_business' => 'required_without:all_space',
        ];
    }
}