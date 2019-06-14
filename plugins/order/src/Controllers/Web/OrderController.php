<?php

namespace Plugins\Order\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Order\Requests\OrderLandingPageRequest;
use Plugins\Order\Services\OrderServices;

class OrderController extends BasePublicController
{
    /**
     * @var OrderServices
     */
    protected $orderServices;

    /**
     * OrderController constructor.
     * @param OrderServices $orderServices
     */
    public function __construct(
        OrderServices $orderServices
    )
    {
        $this->orderServices = $orderServices;
    }

    /**
     * @param OrderLandingPageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function postCreateNewOrderFromLandingPage(OrderLandingPageRequest $request) {
        $data = $request->all();

        $order = $this->orderServices->createNewOrUpdateOrder($data);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.order.edit', $order->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }
}