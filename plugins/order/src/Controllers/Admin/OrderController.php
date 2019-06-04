<?php

namespace Plugins\Order\Controllers\Admin;

use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Plugins\Order\Requests\OrderRequest;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;
use Plugins\Order\DataTables\OrderDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;

class OrderController extends BaseAdminController
{
    /**
     * @var OrderRepositories
     */
    protected $orderRepository;

    /**
     * @var UserInterface|UserRepository
     */
    protected $userRepository;

    /**
     * OrderController constructor.
     * @param OrderRepositories $orderRepository
     * @param UserInterface $userRepository
     */
    public function __construct(OrderRepositories $orderRepository, UserInterface $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
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
        $users = $this->userRepository->getAllUsers();

        page_title()->setTitle(trans('plugins-order::order.create'));

        $this->addDetailAssets();

        return view('plugins-order::create', compact('users'));
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
        $order = $this->orderRepository->createOrUpdate($request->input());

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

        return view('plugins-order::edit', compact('order'));
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
    private function addDetailAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/plugins/Order/css/select2/select2.min.css');
        //AssetManager::addAsset('bootstrap-switch-css', 'libs/plugins/Order/css/toggle/bootstrap-switch.min.css');
        //AssetManager::addAsset('switchery-css', 'libs/plugins/Order/css/toggle/switchery.min.css');
        AssetManager::addAsset('admin-gallery-css', 'libs/core/base/css/gallery/admin-gallery.css');
        //AssetManager::addAsset('Order-css', 'backend/plugins/Order/assets/css/Order.css');

        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        //AssetManager::addAsset('bootstrap-switch-js', 'libs/plugins/product/js/toggle/bootstrap-switch.min.js');
        //AssetManager::addAsset('bootstrap-checkbox-js', 'libs/plugins/product/js/toggle/bootstrap-checkbox.min.js');
        //AssetManager::addAsset('switchery-js', 'libs/plugins/product/js/toggle/switchery.min.js');
        //AssetManager::addAsset('form-select2-js', 'backend/plugins/product/assets/scripts/form-select2.min.js');
        AssetManager::addAsset('order-js', 'backend/plugins/order/assets/js/order.js');

        //AssetPipeline::requireCss('select2-css');
        //AssetPipeline::requireCss('bootstrap-switch-css');
        //AssetPipeline::requireCss('switchery-css');
        AssetPipeline::requireCss('admin-gallery-css');
        //AssetPipeline::requireCss('order-css');

        AssetPipeline::requireJs('select2-js');
        //AssetPipeline::requireJs('bootstrap-switch-js');
        //AssetPipeline::requireJs('bootstrap-checkbox-js');
        //AssetPipeline::requireJs('switchery-js');
        //AssetPipeline::requireJs('form-select2-js');
        AssetPipeline::requireJs('order-js');

        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');
    }
}
