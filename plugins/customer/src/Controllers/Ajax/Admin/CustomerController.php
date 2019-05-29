<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-30
 * Time: 14:20
 */

namespace Plugins\Customer\Controllers\Ajax\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Setting\Contracts\ReferenceConfig;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\Repositories\Interfaces\CustomerQueryListRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Services\CustomerServices;


class CustomerController extends BaseAdminController
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var CustomerRepositories
     */
    protected $customerRepositories;

    /**
     * @var CustomerServices
     */
    protected $customerServices;

    /**
     * @var CustomerQueryListRepositories
     */
    protected $customerQueryListRepositories;

    /**
     * CustomerController constructor.
     * @param UserInterface $userRepository
     * @param CustomerRepositories $customerRepositories
     * @param CustomerServices $customerServices
     * @param CustomerQueryListRepositories $customerQueryListRepositories
     */
    public function __construct(UserInterface $userRepository, CustomerRepositories $customerRepositories,
                                CustomerServices $customerServices, CustomerQueryListRepositories $customerQueryListRepositories)
    {
        $this->userRepository = $userRepository;
        $this->customerRepositories = $customerRepositories;
        $this->customerServices = $customerServices;
        $this->customerQueryListRepositories = $customerQueryListRepositories;
    }

    /**
     * Description
     * @param Request $request
     * @return type
     */
    public function getIntroducePersonsByReference(Request $request)
    {
        $typeData = $request->get('type_reference_data');
        $persons = [];
        switch ($typeData) {
            case ReferenceConfig::REFERENCE_USER_DATA:
                $persons = $this->userRepository->getAllUsers();
                break;
            case ReferenceConfig::REFERENCE_CUSTOMER_DATA:
                $persons = $this->customerRepositories->getAllCustomers();
                break;
        }
        return response()->json($persons);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDataRelationCustomer(Request $request) {
        $customerId = $request->get('customer_id');
        $customer = $this->customerRepositories->findById($customerId);
        if (empty($customer)) {
            abort(404);
        }

        $data['customer_relationship_id'] = (int)$request->get('customer_relationship_id');

        $data['updated_by'] = Auth::id();

        $customer->fill($data);

        $this->customerRepositories->createOrUpdate($customer);

        return response()->json([]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListCustomer(Request $request) {
        $customers = $this->customerServices->searchListCustomer($request->all());
        return response()->json(['data' => $customers]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerQueryList() {
        $result = $this->customerQueryListRepositories->pluck('name', 'id');
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataCustomerQueryList(Request $request) {
        $customerQueryList = $this->customerQueryListRepositories->findOrFail((int)$request->query_customer);
        if (empty($customerQueryList)) {
            abort(404);
        }
        return response()->json($customerQueryList->conditions);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCustomerQueryList(Request $request) {
        $data['name'] = $request->name;
        $data['slug'] = str_slug($data['name']);
        $data['conditions'] = json_encode($request->conditions);
        $data['user_id'] = Auth::id();
        $newQuery = $this->customerQueryListRepositories->createOrUpdate($data);
        $customerQueryList = $this->customerQueryListRepositories->getListCustomerForSelect2(Auth::id());
        return response()->json(['id' => $newQuery->id, 'list' => $customerQueryList]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCustomerQueryList(Request $request) {
        $customerQueryList = $this->customerQueryListRepositories->findById($request->query_customer);
        if (empty($customerQueryList)) {
            abort(404);
        }

        $data['id'] = $request->query_customer;
        $data['name'] = $request->name;
        $data['slug'] = str_slug($data['name']);
        $data['conditions'] = json_encode($request->conditions);
        $data['user_id'] = Auth::id();
        $customerQueryList->fill($data);

        $this->customerQueryListRepositories->createOrUpdate($customerQueryList);
        $customerQueryList = $this->customerQueryListRepositories->getListCustomerForSelect2(Auth::id());
        return response()->json($customerQueryList);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCustomerQueryList(Request $request, $id) {
        try {
            $customerQueryList = $this->customerQueryListRepositories->findById($id);
            if (empty($customerQueryList)) {
                abort(404);
            }
            $this->customerQueryListRepositories->delete($customerQueryList);
            $customerQueryList = $this->customerQueryListRepositories->getListCustomerForSelect2(Auth::id());
            return response()->json([
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
                'list' => $customerQueryList,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAjaxCustomer(Request $request)
    {
        $result = $this->customerServices->searchAjaxCustomer($request->all());
        return response()->json($result);
    }
}