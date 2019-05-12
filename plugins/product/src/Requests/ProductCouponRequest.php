<?php
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;
use Carbon\Carbon;

class ProductCouponRequest extends CoreRequest
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
            'name'             => 'required',
            'product_category' => 'required_if:is_all_product,0|min:1',
            'coupon_type'      => 'required|in:0,1',
            'coupon_value'     => 'required|numeric|min:0',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after:start_date',
            'number_coupon'    => 'nullable|numeric|min:1',
        ];
    }
}