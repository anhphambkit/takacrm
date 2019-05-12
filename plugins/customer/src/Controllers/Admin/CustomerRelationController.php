<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-29
 * Time: 15:31
 */

namespace Plugins\Customer\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\DataTables\CustomerRelationDataTable;
use Plugins\Customer\Repositories\Interfaces\CustomerRelationRepositories;
use Plugins\Customer\Requests\CustomerRelationRequest;
use AssetManager;
use AssetPipeline;

class CustomerRelationController extends BaseAdminController
{
    /**
     * @var CustomerRelationRepositories
     */
    protected $customerRelationRepositories;

    /**
     * ProductController constructor.
     * @param CustomerRelationRepositories $customerRelationRepositories
     * @author AnhPham
     */
    public function __construct(CustomerRelationRepositories $customerRelationRepositories)
    {
        $this->customerRelationRepositories = $customerRelationRepositories;
    }

    /**
     * Display all customerRelation
     * @param CustomerRelationDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(CustomerRelationDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-customer::customer-relation.list'));
        $this->addManageAssets();
        return $dataTable->renderTable(['title' => trans('plugins-customer::customer-relation.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-customer::customer-relation.create'));
        $this->addDetailAssets();
        return view('plugins-customer::customer-relation.create');
    }

    /**
     * @param CustomerRelationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CustomerRelationRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $customerRelation = $this->customerRelationRepositories->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerRelation);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.customer_relation.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.customer.customer_relation.edit', $customerRelation->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $customerRelation = $this->customerRelationRepositories->findById($id);
        if (empty($customerRelation)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-customer::customer-relation.edit') . ' #' . $id);
        $this->addDetailAssets();
        return view('plugins-customer::customer-relation.edit', compact('customerRelation'));
    }

    /**
     * @param $id
     * @param CustomerRelationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, CustomerRelationRequest $request)
    {
        $customerRelation = $this->customerRelationRepositories->findById($id);
        if (empty($customerRelation)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $customerRelation->fill($data);

        $this->customerRelationRepositories->createOrUpdate($customerRelation);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerRelation);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.customer.customer_relation.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.customer.customer_relation.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $customerRelation = $this->customerRelationRepositories->findById($id);
            if (empty($customerRelation)) {
                abort(404);
            }
            $this->customerRelationRepositories->delete($customerRelation);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, CUSTOMER_MODULE_SCREEN_NAME, $request, $customerRelation);

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
        AssetManager::addAsset('customer-color-css', 'backend/plugins/customer/assets/css/customer-color.css');
        AssetManager::addAsset('mini-colors-css', 'libs/core/base/css/miniColors/jquery.minicolors.css');
        AssetManager::addAsset('mini-colors-js', 'libs/core/base/js/miniColors/jquery.minicolors.min.js');
        AssetManager::addAsset('spectrum-js', 'libs/core/base/js/spectrum/spectrum.js');
        AssetManager::addAsset('picker-color-js', 'backend/core/base/assets/scripts/picker-color.min.js');

        AssetPipeline::requireCss('mini-colors-css');
        AssetPipeline::requireCss('customer-color-css');
        AssetPipeline::requireJs('mini-colors-js');
        AssetPipeline::requireJs('spectrum-js');
        AssetPipeline::requireJs('picker-color-js');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addManageAssets()
    {
        AssetManager::addAsset('customer-color-css', 'backend/plugins/customer/assets/css/customer-color.css');

        AssetPipeline::requireCss('customer-color-css');
    }
}