<?php

namespace Plugins\Tenancy\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Tenancy\Requests\TenancyRequest;
use Plugins\Tenancy\DataTables\TenancyDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;
use Plugins\Tenancy\Services\TenancyServices;

class TenancyController extends BaseAdminController
{
    protected $tenancyServices;

    /**
     * TenancyController constructor.
     * @param TenancyServices $tenancyServices
     */
    public function __construct(TenancyServices $tenancyServices)
    {
        $this->tenancyServices = $tenancyServices;
    }

    /**
     * Display all tenancy
     * @param TenancyDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(TenancyDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-tenancy::tenancy.list'));

        return $dataTable->renderTable(['title' => trans('plugins-tenancy::tenancy.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-tenancy::tenancy.create'));

        $this->addAssets();

        return view('plugins-tenancy::create');
    }

    /**
     * @param TenancyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(TenancyRequest $request)
    {
        $tenancy = $this->tenancyServices->registerTenant($request->all());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, TENANCY_MODULE_SCREEN_NAME, $request, $tenancy);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.tenancy.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.tenancy.edit', $tenancy->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $tenancy = $this->tenancyRepository->findById($id);
        if (empty($tenancy)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-tenancy::tenancy.edit') . ' #' . $id);

        return view('plugins-tenancy::edit', compact('tenancy'));
    }

    /**
     * @param $id
     * @param TenancyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, TenancyRequest $request)
    {
        $tenancy = $this->tenancyRepository->findById($id);
        if (empty($tenancy)) {
            abort(404);
        }
        $tenancy->fill($request->input());

        $this->tenancyRepository->createOrUpdate($tenancy);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, TENANCY_MODULE_SCREEN_NAME, $request, $tenancy);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.tenancy.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.tenancy.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $tenancy = $this->tenancyRepository->findById($id);
            if (empty($tenancy)) {
                abort(404);
            }
            $this->tenancyRepository->delete($tenancy);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, TENANCY_MODULE_SCREEN_NAME, $request, $tenancy);

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

    public function addAssets() {
        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');
    }
}
