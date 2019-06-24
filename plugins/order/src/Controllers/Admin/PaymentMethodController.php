<?php
/**
 * Created by PhpStorm.
 * User: Tu Nguyen
 * Date: 2019-05-24
 * Time: 22:57
 */

namespace Plugins\Order\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Order\DataTables\PaymentMethodDataTable;
use Plugins\Order\Repositories\Interfaces\PaymentMethodRepositories;
use Plugins\Order\Requests\PaymentMethodRequest;

class PaymentMethodController extends BaseAdminController
{
    /**
     * @var PaymentMethodRepositories
     */
    protected $paymentMethodRepository;

    /**
     * PaymentMethodController constructor.
     * @param PaymentMethodRepositories $paymentMethodRepository
     * @author Tu Nguyen
     */
    public function __construct(PaymentMethodRepositories $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * @param PaymentMethodDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getList(PaymentMethodDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-order::payment.list'));

        return $dataTable->renderTable(['title' => trans('plugins-order::payment.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Tu Nguyen
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-order::payment.create'));

        return view('plugins-order::payment.create');
    }

    /**
     * @param PaymentMethodRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(PaymentMethodRequest $request)
    {
        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $paymentMethod = $this->paymentMethodRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $paymentMethod);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.payment.method.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.order.payment.method.edit', $paymentMethod->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Tu Nguyen
     */
    public function getEdit($id)
    {
        $paymentMethod = $this->paymentMethodRepository->findById($id);
        if (empty($paymentMethod)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-order::payment.edit') . ' #' . $id);

        return view('plugins-order::payment.edit', compact('paymentMethod'));
    }

    /**
     * @param $id
     * @param PaymentMethodRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, PaymentMethodRequest $request)
    {
        $paymentMethod = $this->paymentMethodRepository->findById($id);
        if (empty($paymentMethod)) {
            abort(404);
        }

        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $paymentMethod->fill($data);

        $this->paymentMethodRepository->createOrUpdate($paymentMethod);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $paymentMethod);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.payment.method.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.order.payment.method.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author Tu Nguyen
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $paymentMethod = $this->paymentMethodRepository->findById($id);
            if (empty($paymentMethod)) {
                abort(404);
            }
            $this->paymentMethodRepository->delete($paymentMethod);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $paymentMethod);

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
}
