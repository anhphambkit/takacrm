<?php

namespace Plugins\Order\Controllers\Admin;

use Core\User\Models\User;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;
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
     * OrderController constructor.
     * @param OrderRepositories $orderRepository
     * @param UserInterface $userRepository
     * @param PaymentMethodRepositories $paymentMethodRepositories
     * @param OrderSourceRepositories $orderSourceRepositories
     * @param ProductRepositories $productRepositories
     * @param OrderServices $orderServices
     */
    public function __construct(OrderRepositories $orderRepository, UserInterface $userRepository,
                                PaymentMethodRepositories $paymentMethodRepositories, OrderSourceRepositories $orderSourceRepositories,
                                ProductRepositories $productRepositories, OrderServices $orderServices
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->paymentMethodRepositories = $paymentMethodRepositories;
        $this->orderSourceRepositories = $orderSourceRepositories;
        $this->productRepositories = $productRepositories;
        $this->orderServices = $orderServices;
    }

    /**
     * Display all order
     * @param OrderDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(OrderDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-order::order.list'));

        return $dataTable->renderTable(['title' => trans('plugins-order::order.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        $users = User::all()->pluck('full_name', 'id');
        $paymentMethods = $this->paymentMethodRepositories->pluck('name', 'id');
        $orderSources = $this->orderSourceRepositories->pluck('name', 'id');
        $products = $this->productRepositories->all(['productCategory']);

        page_title()->setTitle(trans('plugins-order::order.create'));

        $this->addDetailAssets();
        $this->addDetailCRUDAssets();

        return view('plugins-order::order.create', compact('users', 'paymentMethods', 'orderSources', 'products'));
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

        $order = $this->orderServices->createNewOrder($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.order.edit', $order->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
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
        $order = $this->orderRepository->findById($id);
        if (empty($order)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-order::order.edit') . ' #' . $id);

        return view('plugins-order::order.edit', compact('order'));
    }

    /**
     * @param $id
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, OrderRequest $request)
    {
        $order = $this->orderRepository->findById($id);
        if (empty($order)) {
            abort(404);
        }
        $order->fill($request->input());

        $this->orderRepository->createOrUpdate($order);

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
            $order = $this->orderRepository->findById($id);
            if (empty($order)) {
                abort(404);
            }
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
        AssetPipeline::requireCss('order-crud-css');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/plugins/Order/css/select2/select2.min.css');
        AssetManager::addAsset('order-css', 'backend/plugins/order/assets/css/order.css');

        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('order-js', 'backend/plugins/order/assets/js/order.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireCss('order-css');

        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('order-js');

        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');

        AssetPipeline::requireCss('daterangepicker-css');
        AssetPipeline::requireCss('pickadate-css');
        AssetPipeline::requireCss('cnddaterange-css');

        AssetPipeline::requireJs('pickadate-picker-js');
        AssetPipeline::requireJs('pickadate-picker-date-js');
        AssetPipeline::requireJs('daterangepicker-js');
        AssetPipeline::requireJs('datetime-js');
    }
}
