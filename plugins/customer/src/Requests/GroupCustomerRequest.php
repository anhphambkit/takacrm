<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-24
 * Time: 15:58
 */

namespace Plugins\Customer\Requests;


use Core\Master\Requests\CoreRequest;

class GroupCustomerRequest extends CoreRequest
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
//            'slug' => 'unique:group_customers,slug'
        ];
    }
}