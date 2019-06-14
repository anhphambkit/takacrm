<?php

namespace Plugins\Order\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Customer\Contracts\CustomerConfig;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Order\Requests\OrderLandingPageRequest;
use Plugins\Order\Services\OrderServices;

class OrderController extends BasePublicController
{
    /**
     * @var OrderServices
     */
    protected $orderServices;

    /**
     * @var CustomerRepositories
     */
    protected $customerRepositories;

    /**
     * OrderController constructor.
     * @param OrderServices $orderServices
     */
    public function __construct(
        OrderServices $orderServices, CustomerRepositories $customerRepositories
    )
    {
        $this->orderServices = $orderServices;
        $this->customerRepositories = $customerRepositories;
    }

    /**
     * @param OrderLandingPageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function postCreateNewOrderFromLandingPage(OrderLandingPageRequest $request) {
        $data = $request->all();
        $maxCustomerId = (int)$this->customerRepositories->getMaxColumn() + 1;
        $dataCustomer = [
            'full_name' => $data['customer_name'],
            'email' => $data['customer_email'],
            'phone' => $data['customer_phone'],
            'address' => $data['customer_address'],
            'customer_code' => !empty($data['customer_code']) ? $data['customer_code'] : CustomerConfig::CUSTOMER . "-{$maxCustomerId}",
        ];

        $customer = $this->customerRepositories->createOrUpdate($dataCustomer, [
            [
                'email', '=', $data['customer_email']
            ]
        ]);
        $data['customer_id'] = $customer->id;
        $order = $this->orderServices->createNewOrUpdateOrder($data);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.order.edit', $order->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }
}