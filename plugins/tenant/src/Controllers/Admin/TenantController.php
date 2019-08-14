<?php

namespace Plugins\Tenant\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Tenant\Requests\TenantRequest;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;
use Plugins\Tenant\DataTables\TenantDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;
use Plugins\Tenant\Services\TenantServices;

class TenantController extends BaseAdminController
{
    /**
     * @var TenantRepositories
     */
    protected $tenantRepository;

    /**
     * @var TenantServices
     */
    protected $tenantServices;

    /**
     * TenantController constructor.
     * @param TenantRepositories $tenantRepository
     * @param TenantServices $tenantServices
     */
    public function __construct(TenantRepositories $tenantRepository, TenantServices $tenantServices)
    {
        $this->tenantRepository = $tenantRepository;
        $this->tenantServices = $tenantServices;
    }

    /**
     * Display all tenant
     * @param TenantDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(TenantDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-tenant::tenant.list'));

        return $dataTable->renderTable(['title' => trans('plugins-tenant::tenant.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-tenant::tenant.create'));
        $this->addAssets();
        return view('plugins-tenant::create');
    }

    /**
     * Insert new Tenant into database
     *
     * @param TenantRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(TenantRequest $request)
    {
        $tenant = $this->tenantServices->registerTenant($request->all());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, TENANT_MODULE_SCREEN_NAME, $request, $tenant);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.tenant.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.tenant.edit', $tenant->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $tenant = $this->tenantRepository->findById($id);
        if (empty($tenant)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-tenant::tenant.edit') . ' #' . $id);

        return view('plugins-tenant::edit', compact('tenant'));
    }

    /**
     * @param $id
     * @param TenantRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, TenantRequest $request)
    {
        $currentTenant = $this->tenantRepository->findById($id);

        if (empty($currentTenant)) {
            abort(404);
        }

        $data = $request->all();

        $tenant = $this->tenantServices->updateTenant($data, $currentTenant);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, TENANT_MODULE_SCREEN_NAME, $request, $tenant);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.tenant.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.tenant.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $tenant = $this->tenantRepository->findById($id);
            if (empty($tenant)) {
                abort(404);
            }
            $this->tenantRepository->delete($tenant);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, TENANT_MODULE_SCREEN_NAME, $request, $tenant);

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
     *
     */
    public function addAssets() {
        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');
    }
}
