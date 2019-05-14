<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-15
 * Time: 05:30
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductOriginDataTable;
use Plugins\Product\Repositories\Interfaces\ProductOriginRepositories;
use Plugins\Product\Requests\ProductOriginRequest;

class ProductOriginController extends BaseAdminController
{
    /**
     * @var ProductOriginRepositories
     */
    protected $productOriginRepositories;

    /**
     * ProductOriginController constructor.
     * @param ProductOriginRepositories $productOriginRepositories
     */
    public function __construct(ProductOriginRepositories $productOriginRepositories)
    {
        $this->productOriginRepositories = $productOriginRepositories;
    }

    /**
     * Display all origin
     * @param ProductOriginDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductOriginDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::origin.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::origin.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::origin.create'));

        return view('plugins-product::origin.create');
    }

    /**
     * @param ProductOriginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductOriginRequest $request)
    {
        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $productOrigin = $this->productOriginRepositories->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $productOrigin);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.origin.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.origin.edit', $productOrigin->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $productOrigin = $this->productOriginRepositories->findById($id);
        if (empty($productOrigin)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::origin.edit') . ' #' . $id);

        return view('plugins-product::origin.edit', compact('productOrigin'));
    }

    /**
     * @param $id
     * @param ProductOriginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductOriginRequest $request)
    {
        $productOrigin = $this->productOriginRepositories->findById($id);
        if (empty($productOrigin)) {
            abort(404);
        }

        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $productOrigin->fill($data);

        $this->productOriginRepositories->createOrUpdate($productOrigin);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $productOrigin);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.origin.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.origin.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $productOrigin = $this->productOriginRepositories->findById($id);
            if (empty($productOrigin)) {
                abort(404);
            }
            $this->productOriginRepositories->delete($productOrigin);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $productOrigin);

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