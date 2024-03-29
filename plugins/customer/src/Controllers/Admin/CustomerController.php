<?php

namespace Plugins\Customer\Controllers\Admin;

use Core\Setting\Contracts\ReferenceConfig;
use Core\Setting\Services\AddressGeneralInfoService;
use Core\Setting\Services\ReferenceServices;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Services\CustomAttributeServices;
use Plugins\Customer\Contracts\CustomerConfig;
use Plugins\Customer\Repositories\Interfaces\CustomerJobRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerQueryListRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRelationRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerSourceRepositories;
use Plugins\Customer\Repositories\Interfaces\GroupCustomerRepositories;
use Plugins\Customer\Requests\CustomerRequest;
use Plugins\Customer\Requests\UpdateCustomerRequest;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\DataTables\CustomerDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Base\Responses\BaseHttpResponse;
use AssetManager;
use AssetPipeline;

class CustomerController extends BaseAdminController
{
    /**
     * @var CustomerRepositories
     */
    protected $customerRepository;

    /**
     * @var GroupCustomerRepositories
     */
    protected $groupCustomerRepositories;

    /**
     * @var CustomerSourceRepositories
     */
    protected $customerSourceRepositories;

    /**
     * @var CustomerRelationRepositories
     */
    protected $customerRelationRepositories;

    /**
     * @var CustomerJobRepositories
     */
    protected $customerJobRepositories;

    /**
     * @var AddressGeneralInfoService
     */
    protected $addressGeneralInfoService;

    /**
     * @var ReferenceServices
     */
    protected $referenceServices;

    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var CustomerQueryListRepositories
     */
    protected $customerQueryListRepositories;

    /**
     * @var CustomAttributeServices
     */
    protected $customAttributeServices;

    /**
     * CustomerController constructor.
     * @param CustomerRepositories $customerRepository
     * @param AddressGeneralInfoService $addressGeneralInfoService
     * @param ReferenceServices $referenceServices
     * @param GroupCustomerRepositories $groupCustomerRepositories
     * @param CustomerSourceRepositories $customerSourceRepositories
     * @param CustomerRelationRepositories $customerRelationRepositories
     * @param UserInterface $userRepository
     * @param CustomerQueryListRepositories $customerQueryListRepositories
     * @param CustomerJobRepositories $customerJobRepositories
     * @param CustomAttributeServices $customAttributeServices
     */
    public function __construct(CustomerRepositories $customerRepository, AddressGeneralInfoService $addressGeneralInfoService,
                                ReferenceServices $referenceServices, GroupCustomerRepositories $groupCustomerRepositories,
                                CustomerSourceRepositories $customerSourceRepositories, CustomerRelationRepositories $customerRelationRepositories,
                                UserInterface $userRepository, CustomerQueryListRepositories $customerQueryListRepositories,
                                CustomerJobRepositories $customerJobRepositories, CustomAttributeServices $customAttributeServices)
    {
        $this->customerRepository = $customerRepository;
        $this->addressGeneralInfoService = $addressGeneralInfoService;
        $this->referenceServices = $referenceServices;
        $this->groupCustomerRepositories = $groupCustomerRepositories;
        $this->customerSourceRepositories = $customerSourceRepositories;
        $this->customerRelationRepositories = $customerRelationRepositories;
        $this->customerQueryListRepositories = $customerQueryListRepositories;
        $this->customerJobRepositories = $customerJobRepositories;
        $this->userRepository = $userRepository;
        $this->customAttributeServices = $customAttributeServices;
    }

    /**
     * Display all customer
     * @param CustomerDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(CustomerDataTable $dataTable)
    {
        $provincesCities = $this->addressGeneralInfoService->getProvincesCitiesByCountryId()
            ->pluck('name', 'id')
            ->toArray();

        $genders = $this->referenceServices->getReferenceFromAttributeType(ReferenceConfig::REFERENCE_TYPE_GENDER)
            ->pluck('value', 'value')
            ->toArray();

        $typeReferenceData = $this->referenceServices->getReferenceFromAttributeType(ReferenceConfig::REFERENCE_TYPE_CUSTOMER_DATA)
            ->pluck('value', 'value')
            ->toArray();

        $introducePersonIds = [];

        $customerGroups = $this->groupCustomerRepositories->pluck('name', 'id');
        $customerSources = $this->customerSourceRepositories->pluck('name', 'id');
        $customerQueryList = $this->customerQueryListRepositories->getByWhereIn('user_id', [Auth::id()])->pluck('name', 'id');
        $customerRelations = $this->customerRelationRepositories->all();
        $users = $this->userRepository->getAllUsers();
        page_title()->setTitle(trans('plugins-customer::customer.list'));
        $this->addAssets();
        return view('plugins-customer::list', compact('customerRelations', 'genders', 'provincesCities', 'typeReferenceData', 'customerGroups', 'customerSources', 'introducePersonIds', 'users', 'customerQueryList'));
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        $provincesCities = $this->addressGeneralInfoService->getProvincesCitiesByCountryId()
                                                            ->pluck('name', 'id')
                                                            ->toArray();

        $genders = $this->referenceServices->getReferenceFromAttributeType(ReferenceConfig::REFERENCE_TYPE_GENDER)
                                            ->pluck('value', 'value')
                                            ->toArray();

        $typeReferenceData = $this->referenceServices->getReferenceFromAttributeType(ReferenceConfig::REFERENCE_TYPE_CUSTOMER_DATA)
                                            ->pluck('value', 'value')
                                            ->toArray();

        $introducePersonIds = [];

        $customerJobs = $this->customerJobRepositories->pluck('name', 'id');
        $customerGroups = $this->groupCustomerRepositories->pluck('name', 'id');
        $customerSources = $this->customerSourceRepositories->pluck('name', 'id');
        $customerRelationships = $this->customerRelationRepositories->all();
        $users = $this->userRepository->getAllUsers();

        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER)
            ]
        ], ['attributeOptions']);

        page_title()->setTitle(trans('plugins-customer::customer.create'));
        $this->addCustomAttributesAsset();
        $this->addCreateEditAssets();

        return view('plugins-customer::create', compact('provincesCities', 'genders', 'typeReferenceData', 'customerJobs',
            'customerGroups', 'customerSources', 'customerRelationships', 'introducePersonIds', 'users', 'allCustomAttributes'));
    }

    /**
     * @param CustomerRequest $request
     * @return mixed
     */
    public function postCreate(CustomerRequest $request)
    {
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

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.customer.edit', $customer->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetail($id)
    {
        $customer = $this->customerRepository->findOrFail($id);
        $customerContacts = $customer->customerContacts;
        $customerRelationshipIds = $this->customerRelationRepositories->all();
        $customerIntroduces = $this->customerRepository->getListCustomerIntroducedByTypeAndId(ReferenceConfig::REFERENCE_CUSTOMER_DATA, $id);
        page_title()->setTitle(trans('plugins-customer::customer.detail') . ' #' . $id);
        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER)
            ]
        ], ['attributeOptions']);

        $this->addDetailAssets();
        return view('plugins-customer::detail', compact('customer', 'customerRelationshipIds', 'customerContacts', 'customerIntroduces', 'allCustomAttributes'));
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getEdit($id)
    {
        $provincesCities = $this->addressGeneralInfoService->getProvincesCitiesByCountryId()
            ->pluck('name', 'id')
            ->toArray();

        $genders = $this->referenceServices->getReferenceFromAttributeType(ReferenceConfig::REFERENCE_TYPE_GENDER)
            ->pluck('value', 'value')
            ->toArray();

        $typeReferenceData = $this->referenceServices->getReferenceFromAttributeType(ReferenceConfig::REFERENCE_TYPE_CUSTOMER_DATA)
            ->pluck('value', 'value')
            ->toArray();

        $introducePersonIds = [];

        $customerJobs = $this->customerJobRepositories->pluck('name', 'id');
        $customerGroups = $this->groupCustomerRepositories->pluck('name', 'id');
        $customerSources = $this->customerSourceRepositories->pluck('name', 'id');
        $customerRelationshipIds = $this->customerRelationRepositories->all();
        $users = $this->userRepository->getAllUsers();

        $customer = $this->customerRepository->findOrFail($id);

        $selectedCustomerJobs = [];
        if ($customer->customerJobs != null) {
            $selectedCustomerJobs = $customer->customerJobs->pluck('id')->all();
        }

        $selectedCustomerGroups = [];
        if ($customer->customerGroups != null) {
            $selectedCustomerGroups = $customer->customerGroups->pluck('id')->all();
        }

        $selectedCustomerSources = [];
        if ($customer->customerSources != null) {
            $selectedCustomerSources = $customer->customerSources->pluck('id')->all();
        }

        $customerContacts = $customer->customerContacts->toArray();

        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER)
            ]
        ], ['attributeOptions']);

        page_title()->setTitle(trans('plugins-customer::customer.edit') . ' #' . $id);
        $this->addCustomAttributesAsset();
        $this->addCreateEditAssets();
        return view('plugins-customer::edit', compact('customer', 'customerContacts', 'provincesCities',
                                                                    'genders', 'typeReferenceData', 'introducePersonIds',
                                                                    'customerRelationshipIds', 'customerGroups', 'customerSources',
                                                                    'users', 'selectedCustomerJobs', 'selectedCustomerGroups',
                                                                    'selectedCustomerSources', 'customerJobs', 'allCustomAttributes')
        );
    }

    /**
     * @param $id
     * @param UpdateCustomerRequest $request
     * @return mixed
     */
    public function postEdit($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->findById($id);

        if (empty($customer)) {
            abort(404);
        }

        $data = $request->input();

        $data['updated_by'] = Auth::id();

        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER)
            ]
        ], ['stringValueAttributes', 'numberValueAttributes', 'textValueAttributes', 'dateValueAttributes', 'optionValueAttributes']);

        $customer = DB::transaction(function () use ($data, $customer, $request, $allCustomAttributes) {
            $customer->fill($data);

            $this->customerRepository->createOrUpdate($customer);

            $customerSources = $request->input('customer_source_id', []);
            $customer->customerSources()->detach();
            $customer->customerSources()->attach($customerSources);

            $customerGroups = $request->input('customer_group_id', []);
            $customer->customerGroups()->detach();
            $customer->customerGroups()->attach($customerGroups);

            $customerJobs = $request->input('customer_job_id', []);
            $customer->customerJobs()->detach();
            $customer->customerJobs()->attach($customerJobs);

            $customerContacts = $data['customer_contact'];
            $customer->customerContacts()->delete();
            foreach ($customerContacts as $customerContact) {
                $customer->customerContacts()->create(array_merge($customerContact, ['created_by' => Auth::id(), 'updated_by' => Auth::id()]));
            }

            $this->customAttributeServices->createOrUpdateDataEntityCustomAttributes($customer, $allCustomAttributes, $data);

            $customer->save();
            return $customer;
        }, 3);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customer);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.customer.edit', $customer->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $customer = $this->customerRepository->findById($id);
            if (empty($customer)) {
                abort(404);
            }
            $this->customerRepository->delete($customer);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customer);

            return [
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ];
        }
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addCreateEditAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/core/base/css/select2/select2.min.css');
        AssetManager::addAsset('customer-css', 'backend/plugins/customer/assets/css/customer.css');

        AssetManager::addAsset('select2-js', 'libs/core/base/js/select2/select2.full.min.js');
        AssetManager::addAsset('form-select2-js', 'backend/core/base/assets/scripts/form-select2.min.js');
        AssetManager::addAsset('customer-js', 'backend/plugins/customer/assets/js/customer.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('customer-css');
        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('form-select2-js');
        AssetPipeline::requireJs('customer-js');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addCustomAttributesAsset()
    {
        AssetManager::addAsset('select2-css', 'libs/core/base/css/select2/select2.min.css');
        AssetManager::addAsset('bootstrap-switch-css', 'libs/plugins/product/css/toggle/bootstrap-switch.min.css');
        AssetManager::addAsset('switchery-css', 'libs/plugins/product/css/toggle/switchery.min.css');
        AssetManager::addAsset('admin-gallery-css', 'libs/core/base/css/gallery/admin-gallery.css');
        AssetManager::addAsset('mini-colors-css', 'libs/core/base/css/miniColors/jquery.minicolors.css');
        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');

        AssetManager::addAsset('select2-js', 'libs/core/base/js/select2/select2.full.min.js');
        AssetManager::addAsset('bootstrap-switch-js', 'libs/plugins/product/js/toggle/bootstrap-switch.min.js');
        AssetManager::addAsset('bootstrap-checkbox-js', 'libs/plugins/product/js/toggle/bootstrap-checkbox.min.js');
        AssetManager::addAsset('switchery-js', 'libs/plugins/product/js/toggle/switchery.min.js');
        AssetManager::addAsset('form-select2-js', 'backend/core/base/assets/scripts/form-select2.min.js');
        AssetManager::addAsset('switch-js', 'backend/plugins/product/assets/scripts/switch.min.js');
        AssetManager::addAsset('mini-colors-js', 'libs/core/base/js/miniColors/jquery.minicolors.min.js');
        AssetManager::addAsset('spectrum-js', 'libs/core/base/js/spectrum/spectrum.js');
        AssetManager::addAsset('picker-color-js', 'backend/core/base/assets/scripts/picker-color.min.js');
        AssetManager::addAsset('legacy-js', 'libs/core/base/js/date-picker/legacy.js');
        AssetManager::addAsset('custom-field-js', 'backend/core/base/assets/scripts/custom-field.js');

        AssetPipeline::requireCss('mini-colors-css');
        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('bootstrap-switch-css');
        AssetPipeline::requireCss('switchery-css');
        AssetPipeline::requireCss('admin-gallery-css');
        AssetPipeline::requireCss('pretty-checkbox');
        AssetPipeline::requireCss('daterangepicker-css');
        AssetPipeline::requireCss('pickadate-css');
        AssetPipeline::requireCss('cnddaterange-css');

        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('bootstrap-switch-js');
        AssetPipeline::requireJs('bootstrap-checkbox-js');
        AssetPipeline::requireJs('switchery-js');
        AssetPipeline::requireJs('switch-js');
        AssetPipeline::requireJs('mini-colors-js');
        AssetPipeline::requireJs('spectrum-js');
        AssetPipeline::requireJs('picker-color-js');
        AssetPipeline::requireJs('legacy-js');
        AssetPipeline::requireJs('form-select2-js');
        AssetPipeline::requireJs('pickadate-picker-js');
        AssetPipeline::requireJs('pickadate-picker-date-js');
        AssetPipeline::requireJs('daterangepicker-js');
        AssetPipeline::requireJs('datetime-js');
        AssetPipeline::requireJs('custom-field-js');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addAssets() {
        AssetManager::addAsset('pick-date-css', 'libs/core/base/css/date-picker/pickadate.css');
        AssetManager::addAsset('select2-css', 'libs/core/base/css/select2/select2.min.css');
        AssetManager::addAsset('customer-css', 'backend/plugins/customer/assets/css/customer.css');
        AssetManager::addAsset('legacy-js', 'libs/core/base/js/date-picker/legacy.js');
        AssetManager::addAsset('select2-js', 'libs/core/base/js/select2/select2.full.min.js');
        AssetManager::addAsset('customer-table-js', 'backend/plugins/customer/assets/js/customer-table.js');
        AssetManager::addAsset('customer-list-js', 'backend/plugins/customer/assets/js/customer-list.js');

        AssetPipeline::requireCss('daterangepicker-css');
        AssetPipeline::requireCss('pickadate-css');
        AssetPipeline::requireCss('cnddaterange-css');
        AssetPipeline::requireJs('pickadate-picker-js');
        AssetPipeline::requireJs('pickadate-picker-date-js');
        AssetPipeline::requireJs('daterangepicker-js');
        AssetPipeline::requireJs('datetime-js');

        AssetPipeline::requireCss('pick-date-css');
        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('customer-css');
        AssetPipeline::requireJs('legacy-js');
        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('customer-table-js');
        AssetPipeline::requireJs('customer-list-js');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets() {
        AssetManager::addAsset('select2-css', 'libs/core/base/css/select2/select2.min.css');
        AssetManager::addAsset('customer-css', 'backend/plugins/customer/assets/css/customer.css');
        AssetManager::addAsset('detail-customer-css', 'backend/plugins/customer/assets/css/detail-customer.css');
        AssetManager::addAsset('customer-color-css', 'backend/plugins/customer/assets/css/customer-color.css');
        AssetManager::addAsset('select2-js', 'libs/core/base/js/select2/select2.full.min.js');
        AssetManager::addAsset('detail-customer-js', 'backend/plugins/customer/assets/js/detail-customer.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('customer-css');
        AssetPipeline::requireCss('detail-customer-css');
        AssetPipeline::requireCss('customer-color-css');
        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('detail-customer-js');
    }
}
