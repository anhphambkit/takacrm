<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-24
 * Time: 16:52
 */

namespace Plugins\Customer\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\DataTables\CustomerJobDataTable;
use Plugins\Customer\Repositories\Interfaces\CustomerJobRepositories;
use Plugins\Customer\Requests\CustomerJobRequest;

class CustomerJobsController extends BaseAdminController
{
    /**
     * @var CustomerJobRepositories
     */
    protected $customerJobRepository;

    /**
     * ProductController constructor.
     * @param CustomerJobRepositories $customerJobRepository
     * @author AnhPham
     */
    public function __construct(CustomerJobRepositories $customerJobRepository)
    {
        $this->customerJobRepository = $customerJobRepository;
    }

    /**
     * Display all customerJob
     * @param CustomerJobDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(CustomerJobDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-customer::customer-job.list'));

        return $dataTable->renderTable(['title' => trans('plugins-customer::customer-job.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-customer::customer-job.create'));

        return view('plugins-customer::customer-job.create');
    }

    /**
     * @param CustomerJobRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CustomerJobRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $customerJob = $this->customerJobRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerJob);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.customer_job.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.customer.customer_job.edit', $customerJob->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $customerJob = $this->customerJobRepository->findById($id);
        if (empty($customerJob)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-customer::customer-job.edit') . ' #' . $id);

        return view('plugins-customer::customer-job.edit', compact('customerJob'));
    }

    /**
     * @param $id
     * @param CustomerJobRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, CustomerJobRequest $request)
    {
        $customerJob = $this->customerJobRepository->findById($id);
        if (empty($customerJob)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $customerJob->fill($data);

        $this->customerJobRepository->createOrUpdate($customerJob);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerJob);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.customer_job.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.customer.customer_job.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $customerJob = $this->customerJobRepository->findById($id);
            if (empty($customerJob)) {
                abort(404);
            }
            $this->customerJobRepository->delete($customerJob);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerJob);

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