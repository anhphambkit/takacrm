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
use Illuminate\Support\Facades\Auth;
use Plugins\Order\Services\OrderServices;
use Plugins\Order\Requests\SourceOrderRequest;
use Plugins\Order\Repositories\Interfaces\OrderSourceRepositories;

class OrderController extends BaseAdminController
{
    /**
     * @var UserInterface
     */
    protected $orderServices;

    protected $orderSourceRepositories;

    /**
     * CustomerController constructor.
     * @param OrderServices $orderServices
     */
    public function __construct(OrderServices $orderServices, OrderSourceRepositories $orderSourceRepositories)
    {
        $this->orderServices = $orderServices;
        $this->orderSourceRepositories = $orderSourceRepositories;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOrder(Request $request) {
        $result = $this->orderServices->searchListOrder($request->all());
        return response()->json($result);
    }

    /**
     * @param SourceOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickAddOrderSource(SourceOrderRequest $request){
        $data = $request->all();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();
        $result = $this->orderSourceRepositories->createOrUpdate($data);
        return response()->json($result);
    }

    public function quickAddJobGroup(){

    }

}
