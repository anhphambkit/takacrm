<?php

namespace Plugins\Order\Controllers\Admin;

use Core\Setting\Services\ReferenceServices;
use Core\User\Models\User;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Services\CustomAttributeServices;
use Plugins\Order\Contracts\OrderConfigs;
use Plugins\Order\Models\Order;
use Plugins\Order\Repositories\Interfaces\OrderSourceRepositories;
use Plugins\Order\Repositories\Interfaces\PaymentMethodRepositories;
use Plugins\Order\Requests\OrderRequest;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;
use Plugins\Order\DataTables\OrderDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;
use Plugins\Order\Services\OrderServices;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\History\Repositories\Interfaces\HistoryRepositories;
use Plugins\History\Models\ProductOrderHistory;

class OrderController extends BaseAdminController
{
    /**
     * @var OrderRepositories
     */
    protected $orderRepository;

    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var PaymentMethodRepositories
     */
    protected $paymentMethodRepositories;

    /**
     * @var OrderSourceRepositories
     */
    protected $orderSourceRepositories;

    /**
     * @var ProductRepositories
     */
    protected $productRepositories;

    /**
     * @var OrderServices
     */
    protected $orderServices;

    /**
     * @var ReferenceServices
     */
    protected $referenceServices;

    /**
     * [$historyRepository description]
     * @var [type]
     */
    private $historyRepository;

    /**
     * @var CustomAttributeServices
     */
    private $customAttributeServices;

    /**
     * OrderController constructor.
     * @param OrderRepositories $orderRepository
     * @param UserInterface $userRepository
     * @param PaymentMethodRepositories $paymentMethodRepositories
     * @param OrderSourceRepositories $orderSourceRepositories
     * @param ProductRepositories $productRepositories
     * @param OrderServices $orderServices
     * @param ReferenceServices $referenceServices
     * @param HistoryRepositories $historyRepository
     * @param CustomAttributeServices $customAttributeServices
     */
    public function __construct(
        OrderRepositories $orderRepository,
        UserInterface $userRepository,
        PaymentMethodRepositories $paymentMethodRepositories,
        OrderSourceRepositories $orderSourceRepositories,
        ProductRepositories $productRepositories,
        OrderServices $orderServices,
        ReferenceServices $referenceServices,
        HistoryRepositories $historyRepository,
        CustomAttributeServices $customAttributeServices
    )
    {
        $this->orderRepository           = $orderRepository;
        $this->userRepository            = $userRepository;
        $this->paymentMethodRepositories = $paymentMethodRepositories;
        $this->orderSourceRepositories   = $orderSourceRepositories;
        $this->productRepositories       = $productRepositories;
        $this->orderServices             = $orderServices;
        $this->referenceServices         = $referenceServices;
        $this->historyRepository         = $historyRepository;
        $this->customAttributeServices   = $customAttributeServices;
    }

    /**
     * Display all order
     * @param OrderDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(OrderDataTable $dataTable)
    {
        $orderStatuses = $this->referenceServices->getReferenceFromAttributeType(OrderConfigs::STATUS_ORDER_TYPE);
        $paymentOrderStatuses = $this->referenceServices->getReferenceFromAttributeType(OrderConfigs::STATUS_PAYMENT_ORDER_TYPE);
        page_title()->setTitle(trans('plugins-order::order.list'));
        $this->addListAssets();
        return view('plugins-order::order.list', compact('orderStatuses', 'paymentOrderStatuses'));
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        $users          = User::all()->pluck('full_name', 'id');
        $paymentMethods = $this->paymentMethodRepositories->pluck('name', 'id');
        $orderSources = $this->orderSourceRepositories->pluck('name', 'id');
        $products = $this->productRepositories->all(['productCategory']);
        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER)
            ]
        ], ['attributeOptions']);

        page_title()->setTitle(trans('plugins-order::order.create'));

        $this->addCustomAttributesAsset();
        $this->addDetailAssets();
        $this->addDetailCRUDAssets();

        return view('plugins-order::order.create', compact('users', 'paymentMethods', 'orderSources', 'products', 'allCustomAttributes'));
    }

    /**
     * Insert new Order into database
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(OrderRequest $request)
    {
        $data = $request->all();

        $order = $this->orderServices->createNewOrUpdateOrder($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.order.edit', $order->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetail($id)
    {
        $order = $this->orderRepository->findOrFail($id, ['products']);

        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER)
            ]
        ], ['attributeOptions']);

        $this->addDetailPageAssets();
        $this->addDetailCRUDAssets();

        page_title()->setTitle(trans('plugins-order::order.detail') . ' #' . $id);

        $histories = $this->historyRepository->allBy([
            'target_id'   => $id,
            'target_type' => HISTORY_MODULE_ORDER
        ])->sortByDesc('created_at');

        $productsHistory = ProductOrderHistory::where('order_id', $id)->get()->groupBy('path_session');
        $histories       = $histories->groupBy('path_session');
        return view('plugins-order::order.detail', compact('order','histories', 'productsHistory', 'allCustomAttributes'));
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
        $order          = $this->orderRepository->findOrFail($id);
        $users          = User::all()->pluck('full_name', 'id');
        $paymentMethods = $this->paymentMethodRepositories->pluck('name', 'id');
        $orderSources = $this->orderSourceRepositories->pluck('name', 'id');
        $products = $this->productRepositories->all(['productCategory']);
        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER)
            ]
        ], ['attributeOptions']);

        $this->addCustomAttributesAsset();
        $this->addDetailAssets();
        $this->addDetailCRUDAssets();

        page_title()->setTitle(trans('plugins-order::order.edit') . ' #' . $id);

        return view('plugins-order::order.edit', compact('order', 'users', 'paymentMethods', 'orderSources', 'products', 'allCustomAttributes'));
    }

    /**
     * @param $id
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, OrderRequest $request)
    {
        $order = $this->orderServices->createNewOrUpdateOrder($request->all(), $id);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.order.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $order = $this->orderRepository->findOrFail($id);
            $this->orderRepository->delete($order);
            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

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
    private function addDetailCRUDAssets() {
        AssetManager::addAsset('order-crud-css', 'backend/plugins/order/assets/css/order-crud.css');
        AssetManager::addAsset('history-css', 'backend/plugins/history/assets/css/history.css');
        AssetPipeline::requireCss('history-css');
        AssetPipeline::requireCss('order-crud-css');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addListAssets() {
        AssetManager::addAsset('order-css', 'backend/plugins/order/assets/css/order.css');
        AssetManager::addAsset('order-table-js', 'backend/plugins/order/assets/js/order-table.js');
        AssetPipeline::requireCss('order-css');
        AssetPipeline::requireJs('order-table-js');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailPageAssets() {
        AssetManager::addAsset('order-css', 'backend/plugins/order/assets/css/order.css');
        AssetPipeline::requireCss('order-css');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets()
    {
        AssetManager::addAsset('order-css', 'backend/plugins/order/assets/css/order.css');

        AssetManager::addAsset('order-js', 'backend/plugins/order/assets/js/order.js');

        AssetPipeline::requireCss('order-css');

        AssetPipeline::requireJs('order-js');
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
}
