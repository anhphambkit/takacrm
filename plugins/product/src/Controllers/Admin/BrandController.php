<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-08
 * Time: 23:15
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Plugins\Product\DataTables\BrandDataTable;
use Plugins\Product\Repositories\Interfaces\BrandRepositories;

class BrandController extends BaseAdminController
{
    /**
     * @var BrandRepositories
     */
    protected $brandRepository;

    /**
     * ProductController constructor.
     * @param BrandRepositories $brandRepository
     * @author AnhPham
     */
    public function __construct(BrandRepositories $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display all brand
     * @param BrandDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(BrandDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::brand.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::brand.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::brand.create'));

        return view('plugins-product::brand.create');
    }

    /**
     * Insert new Product into database
     *
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postCreate(Request $request)
    {
        $brand = $this->brandRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $brand);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.brand.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.brand.edit', $brand->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $brand = $this->brandRepository->findById($id);
        if (empty($brand)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::brand.edit') . ' #' . $id);

        return view('plugins-product::brand.edit', compact('brand'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author AnhPham
     */
    public function postEdit($id, Request $request)
    {
        $brand = $this->brandRepository->findById($id);
        if (empty($brand)) {
            abort(404);
        }
        $brand->fill($request->input());

        $this->brandRepository->createOrUpdate($brand);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $brand);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.brand.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.brand.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $brand = $this->brandRepository->findById($id);
            if (empty($brand)) {
                abort(404);
            }
            $this->brandRepository->delete($brand);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $brand);

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