<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 14:08
 */

namespace Plugins\CustomAttributes\Requests;

use Core\Master\Requests\CoreRequest;

class AttributeValueRequest extends CoreRequest
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
            'name' => 'required',
            'value' => 'required_if:type_render,color_picker',
        ];
    }
}