<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-06
 * Time: 04:02
 */

namespace Plugins\Order\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Order\DataTables\SourceOrderDataTable;
use Plugins\Order\Repositories\Interfaces\OrderSourceRepositories;
use Plugins\Order\Requests\SourceOrderRequest;

class SourceOrderController extends BaseAdminController
{
    /**
     * @var OrderSourceRepositories
     */
    protected $orderSourceRepositories;

    /**
     * SourceOrderController constructor.
     * @param OrderSourceRepositories $orderSourceRepositories
     */
    public function __construct(OrderSourceRepositories $orderSourceRepositories)
    {
        $this->orderSourceRepositories = $orderSourceRepositories;
    }

    /**
     * @param SourceOrderDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getList(SourceOrderDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-order::source.list'));

        return $dataTable->renderTable(['title' => trans('plugins-order::source.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Tu Nguyen
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-order::source.create'));

        return view('plugins-order::source.create');
    }

    /**
     * @param SourceOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(SourceOrderRequest $request)
    {
        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $sourceOrder = $this->orderSourceRepositories->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $sourceOrder);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.source.method.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.order.source.method.edit', $sourceOrder->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $sourceOrder = $this->orderSourceRepositories->findById($id);
        if (empty($sourceOrder)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-order::source.edit') . ' #' . $id);

        return view('plugins-order::source.edit', compact('sourceOrder'));
    }

    /**
     * @param $id
     * @param SourceOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, SourceOrderRequest $request)
    {
        $sourceOrder = $this->orderSourceRepositories->findById($id);
        if (empty($sourceOrder)) {
            abort(404);
        }

        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $sourceOrder->fill($data);

        $this->orderSourceRepositories->createOrUpdate($sourceOrder);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $sourceOrder);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.order.source.method.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.order.source.method.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $sourceOrder = $this->orderSourceRepositories->findById($id);
            if (empty($sourceOrder)) {
                abort(404);
            }
            $this->orderSourceRepositories->delete($sourceOrder);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $sourceOrder);

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
