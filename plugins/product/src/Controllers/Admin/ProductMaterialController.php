<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-11
 * Time: 02:52
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductMaterialDataTable;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
use Plugins\Product\Requests\ProductMaterialRequest;

class ProductMaterialController extends BaseAdminController
{
    /**
     * @var ProductMaterialRepositories
     */
    protected $productMaterialRepository;

    /**
     * ProductController constructor.
     * @param ProductMaterialRepositories $productMaterialRepository
     * @author AnhPham
     */
    public function __construct(ProductMaterialRepositories $productMaterialRepository)
    {
        $this->productMaterialRepository = $productMaterialRepository;
    }

    /**
     * Display all material
     * @param ProductMaterialDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductMaterialDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::material.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::material.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::material.create'));

        return view('plugins-product::material.create');
    }

    /**
     * @param ProductMaterialRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductMaterialRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $material = $this->productMaterialRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $material);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.material.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.material.edit', $material->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $material = $this->productMaterialRepository->findById($id);
        if (empty($material)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::material.edit') . ' #' . $id);

        return view('plugins-product::material.edit', compact('material'));
    }

    /**
     * @param $id
     * @param ProductMaterialRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductMaterialRequest $request)
    {
        $material = $this->productMaterialRepository->findById($id);
        if (empty($material)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $material->fill($data);

        $this->productMaterialRepository->createOrUpdate($material);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $material);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.material.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.material.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $material = $this->productMaterialRepository->findById($id);
            if (empty($material)) {
                abort(404);
            }
            $this->productMaterialRepository->delete($material);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $material);

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