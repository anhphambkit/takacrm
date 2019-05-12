<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-24
 * Time: 16:26
 */

namespace Plugins\Customer\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\DataTables\CustomerSourceDataTable;
use Plugins\Customer\Repositories\Interfaces\CustomerSourceRepositories;
use Plugins\Customer\Requests\CustomerSourceRequest;

class CustomerSourcesController extends BaseAdminController
{
    /**
     * @var CustomerSourceRepositories
     */
    protected $customerSourceRepository;

    /**
     * ProductController constructor.
     * @param CustomerSourceRepositories $customerSourceRepository
     * @author AnhPham
     */
    public function __construct(CustomerSourceRepositories $customerSourceRepository)
    {
        $this->customerSourceRepository = $customerSourceRepository;
    }

    /**
     * Display all collection
     * @param CustomerSourceDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(CustomerSourceDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-customer::customer-source.list'));

        return $dataTable->renderTable(['title' => trans('plugins-customer::customer-source.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-customer::customer-source.create'));

        return view('plugins-customer::customer-source.create');
    }

    /**
     * @param CustomerSourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CustomerSourceRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $customerSource = $this->customerSourceRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerSource);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.customer_source.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.customer.customer_source.edit', $customerSource->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getEdit($id)
    {
        $customerSource = $this->customerSourceRepository->findById($id);
        if (empty($customerSource)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-customer::customer-source.edit') . ' #' . $id);

        return view('plugins-customer::customer-source.edit', compact('customerSource'));
    }

    /**
     * @param $id
     * @param CustomerSourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, CustomerSourceRequest $request)
    {
        $customerSource = $this->customerSourceRepository->findById($id);
        if (empty($customerSource)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $customerSource->fill($data);

        $this->customerSourceRepository->createOrUpdate($customerSource);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerSource);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.customer_source.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.customer.customer_source.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author AnhPham
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $customerSource = $this->customerSourceRepository->findById($id);
            if (empty($customerSource)) {
                abort(404);
            }
            $this->customerSourceRepository->delete($customerSource);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerSource);

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