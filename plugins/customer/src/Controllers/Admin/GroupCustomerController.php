<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-24
 * Time: 15:36
 */

namespace Plugins\Customer\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\DataTables\GroupCustomerDataTable;
use Plugins\Customer\Repositories\Interfaces\GroupCustomerRepositories;
use Plugins\Customer\Requests\GroupCustomerRequest;
use AssetManager;
use AssetPipeline;

class GroupCustomerController extends BaseAdminController
{
    /**
     * @var GroupCustomerRepositories
     */
    protected $groupCustomerRepository;

    /**
     * ProductController constructor.
     * @param GroupCustomerRepositories $groupCustomerRepository
     * @author AnhPham
     */
    public function __construct(GroupCustomerRepositories $groupCustomerRepository)
    {
        $this->groupCustomerRepository = $groupCustomerRepository;
    }

    /**
     * Display all customerGroup
     * @param GroupCustomerDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(GroupCustomerDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-customer::group-customer.list'));

        return $dataTable->renderTable(['title' => trans('plugins-customer::group-customer.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $customerGroups = $this->groupCustomerRepository->pluck('name', 'id');

        $customerGroups = array_merge([ 0 => trans('plugins-customer::group-customer.default_option_select_group_customer') ], $customerGroups);

        page_title()->setTitle(trans('plugins-customer::group-customer.create'));
        $this->addDetailAssets();

        return view('plugins-customer::group-customer.create', compact('customerGroups'));
    }

    /**
     * @param GroupCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(GroupCustomerRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $customerGroup = $this->groupCustomerRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerGroup);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.group_customer.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.customer.group_customer.edit', $customerGroup->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $customerGroups = $this->groupCustomerRepository->getByWhereNotIn('id', [$id])->pluck('name', 'id')->toArray();
        $customerGroups = array_merge([ 0 => trans('plugins-customer::group-customer.default_option_select_group_customer') ], $customerGroups);

        $customerGroup = $this->groupCustomerRepository->findById($id);

        if (empty($customerGroup)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-customer::group-customer.edit') . ' #' . $id);
        $this->addDetailAssets();
        return view('plugins-customer::group-customer.edit', compact('customerGroup', 'customerGroups'));
    }

    /**
     * @param $id
     * @param GroupCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, GroupCustomerRequest $request)
    {
        $customerGroup = $this->groupCustomerRepository->findById($id);
        if (empty($customerGroup)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $customerGroup->fill($data);

        $this->groupCustomerRepository->createOrUpdate($customerGroup);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerGroup);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.group_customer.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.customer.group_customer.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $customerGroup = $this->groupCustomerRepository->findById($id);
            if (empty($customerGroup)) {
                abort(404);
            }
            $this->groupCustomerRepository->delete($customerGroup);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerGroup);

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
        AssetManager::addAsset('select2-css', 'libs/core/base/css/select2/select2.min.css');
        AssetManager::addAsset('select2-js', 'libs/core/base/js/select2/select2.full.min.js');
        AssetManager::addAsset('form-select2-js', 'backend/core/base/assets/scripts/form-select2.min.js');

        AssetPipeline::requireCss('select2-css');
        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('form-select2-js');
    }
}