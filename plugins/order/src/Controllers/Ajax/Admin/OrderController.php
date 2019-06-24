<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 14:53
 */

namespace Plugins\Order\Controllers\Ajax\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Plugins\Order\Services\OrderServices;

class OrderController extends BaseAdminController
{
    /**
     * @var UserInterface
     */
    protected $orderServices;

    /**
     * CustomerController constructor.
     * @param OrderServices $orderServices
     */
    public function __construct(OrderServices $orderServices)
    {
        $this->orderServices = $orderServices;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOrder(Request $request) {
        $result = $this->orderServices->searchListOrder($request->all());
        return response()->json($result);
    }
}