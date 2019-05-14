<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-12
 * Time: 22:57
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductUnitDataTable;
use Plugins\Product\Repositories\Interfaces\ProductUnitRepositories;
use Plugins\Product\Requests\ProductUnitRequest;

class ProductUnitController extends BaseAdminController
{
    /**
     * @var ProductUnitRepositories
     */
    protected $productUnitRepository;

    /**
     * ProductController constructor.
     * @param ProductUnitRepositories $productUnitRepository
     * @author AnhPham
     */
    public function __construct(ProductUnitRepositories $productUnitRepository)
    {
        $this->productUnitRepository = $productUnitRepository;
    }

    /**
     * Display all unit
     * @param ProductUnitDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductUnitDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::unit.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::unit.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::unit.create'));

        return view('plugins-product::unit.create');
    }

    /**
     * @param ProductUnitRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductUnitRequest $request)
    {
        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $productUnit = $this->productUnitRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $productUnit);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.unit.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.unit.edit', $productUnit->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $productUnit = $this->productUnitRepository->findById($id);
        if (empty($productUnit)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::unit.edit') . ' #' . $id);

        return view('plugins-product::unit.edit', compact('productUnit'));
    }

    /**
     * @param $id
     * @param ProductUnitRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductUnitRequest $request)
    {
        $productUnit = $this->productUnitRepository->findById($id);
        if (empty($productUnit)) {
            abort(404);
        }

        $data = $request->input();
        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $productUnit->fill($data);

        $this->productUnitRepository->createOrUpdate($productUnit);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $productUnit);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.unit.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.unit.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $productUnit = $this->productUnitRepository->findById($id);
            if (empty($productUnit)) {
                abort(404);
            }
            $this->productUnitRepository->delete($productUnit);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $productUnit);

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