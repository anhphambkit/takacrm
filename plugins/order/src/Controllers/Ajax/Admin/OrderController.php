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
use Illuminate\Support\Facades\DB;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Services\CustomAttributeServices;
use Plugins\Customer\Contracts\CustomerConfig;
use Plugins\Customer\Repositories\Interfaces\CustomerJobRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerSourceRepositories;
use Plugins\Customer\Repositories\Interfaces\GroupCustomerRepositories;
use Plugins\Order\Services\OrderServices;
use Plugins\Order\Requests\SourceOrderRequest;
use Plugins\Order\Repositories\Interfaces\OrderSourceRepositories;
use Plugins\Order\Requests\GroupCustomerRequest;
use Plugins\Order\Requests\CustomerSourceRequest;
use Plugins\Order\Requests\CustomerJobRequest;
use Plugins\Order\Requests\CustomerRequest;

class OrderController extends BaseAdminController
{
    /**
     * @var UserInterface
     */
    protected $orderServices;

    protected $orderSourceRepositories;

    protected $groupCustomerRepositories;

    protected $customerSourceRepositories;

    protected $customerJobRepositories;

    protected $customerRepository;

    protected $customAttributeServices;
    /**
     * CustomerController constructor.
     * @param OrderServices $orderServices
     */
    public function __construct(OrderServices $orderServices, OrderSourceRepositories $orderSourceRepositories, GroupCustomerRepositories $groupCustomerRepositories, CustomerSourceRepositories $customerSourceRepositories, CustomerJobRepositories $customerJobRepositories, CustomerRepositories $customerRepository, CustomAttributeServices $customAttributeServices)
    {
        $this->orderServices = $orderServices;
        $this->orderSourceRepositories = $orderSourceRepositories;
        $this->groupCustomerRepositories = $groupCustomerRepositories;
        $this->customerSourceRepositories = $customerSourceRepositories;
        $this->customerJobRepositories   = $customerJobRepositories;
        $this->customerRepository = $customerRepository;
        $this->customAttributeServices = $customAttributeServices;

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

    /**
     * @param GroupCustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickAddCustomerGroup(GroupCustomerRequest $request){
        $data = $request->all();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();
        $result = $this->groupCustomerRepositories->createOrUpdate($data);
        return response()->json($result);
    }

    /**
     * @param CustomerSourceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickAddCustomerSource(CustomerSourceRequest $request){
        $data = $request->all();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();
        $result = $this->customerSourceRepositories->createOrUpdate($data);
        return response()->json($result);
    }

    /**
     * @param CustomerJobRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickAddCustomerJob(CustomerJobRequest $request){
        $data = $request->all();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();
        $result = $this->customerJobRepositories->createOrUpdate($data);
        return response()->json($result);
    }

    public function quickAddCustomer(CustomerRequest $request){
        $data = $request->input();
        $maxCustomerId = (int)$this->customerRepository->getMaxColumn() + 1;
        $data['created_by'] = Auth::id();
        $data['customer_code'] = !empty($data['customer_code']) ? $data['customer_code'] : CustomerConfig::CUSTOMER . "-{$maxCustomerId}";

        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER)
            ]
        ], ['stringValueAttributes', 'numberValueAttributes', 'textValueAttributes', 'dateValueAttributes', 'optionValueAttributes']);

        $customer = DB::transaction(function () use ($data, $request, $allCustomAttributes) {
            $customer = $this->customerRepository->createOrUpdate($data, [
                [
                    'email', '=', $data['email']
                ]
            ]);

            $customerGroups = $request->input('customer_group_id', []);
            $customer->customerGroups()->attach($customerGroups);

            $customerSources = $request->input('customer_source_id', []);
            $customer->customerSources()->attach($customerSources);

            $customerJobs = $request->input('customer_job_id', []);
            $customer->customerJobs()->attach($customerJobs);

            $customerContacts = $data['customer_contact'];
            foreach ($customerContacts as $customerContact) {
                $customer->customerContacts()->create(array_merge($customerContact, ['created_by' => Auth::id()]));
            }

            $this->customAttributeServices->createOrUpdateDataEntityCustomAttributes($customer, $allCustomAttributes, $data);

            $customer->save();
            return $customer;
        }, 3);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customer);
        return response()->json($customer);
    }

}
