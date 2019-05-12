<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-11
 * Time: 02:27
 */

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductCollectionDataTable;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Requests\ProductCollectionRequest;

class ProductCollectionController extends BaseAdminController
{
    /**
     * @var ProductCollectionRepositories
     */
    protected $productCollectionRepository;

    /**
     * ProductController constructor.
     * @param ProductCollectionRepositories $productCollectionRepository
     * @author AnhPham
     */
    public function __construct(ProductCollectionRepositories $productCollectionRepository)
    {
        $this->productCollectionRepository = $productCollectionRepository;
    }

    /**
     * Display all collection
     * @param ProductCollectionDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(ProductCollectionDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-product::collection.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::collection.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-product::collection.create'));

        return view('plugins-product::collection.create');
    }

    /**
     * @param ProductCollectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductCollectionRequest $request)
    {
        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();

        $collection = $this->productCollectionRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $collection);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.collection.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.product.collection.edit', $collection->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $collection = $this->productCollectionRepository->findById($id);
        if (empty($collection)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-product::collection.edit') . ' #' . $id);

        return view('plugins-product::collection.edit', compact('collection'));
    }

    /**
     * @param $id
     * @param ProductCollectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductCollectionRequest $request)
    {
        $collection = $this->productCollectionRepository->findById($id);
        if (empty($collection)) {
            abort(404);
        }

        $data = $request->input();

        $data['slug'] = str_slug($data['name']);
        $data['updated_by'] = Auth::id();

        $collection->fill($data);

        $this->productCollectionRepository->createOrUpdate($collection);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $collection);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.product.collection.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.product.collection.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $collection = $this->productCollectionRepository->findById($id);
            if (empty($collection)) {
                abort(404);
            }
            $this->productCollectionRepository->delete($collection);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $collection);

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