<?php

namespace Plugins\Product\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\DataTables\ProductCouponDataTable;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;
use Plugins\Product\Requests\ProductCouponRequest;
use Core\Base\Responses\BaseHttpResponse;
use AssetManager;
use AssetPipeline;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;

class ProductCouponController extends BaseAdminController
{
    /**
     * @var ProductCouponRepositories
     */
    protected $productCouponRepository;

    /**
     * @var ProductCategoryRepositories
     */
    protected $productCategoryRepository;

    /**
     * ProductController constructor.
     * @param ProductCouponRepositories $productCouponRepository
     * @author TrinhLe
     */
    public function __construct(ProductCouponRepositories $coupon, ProductCategoryRepositories $category)
    {
        $this->productCouponRepository   = $coupon;
        $this->productCategoryRepository = $category;
    }

    /**
     * [addAssets description]
     */
    protected function addAssets(){
        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');

        AssetPipeline::requireCss('daterangepicker-css');
        AssetPipeline::requireCss('pickadate-css');
        AssetPipeline::requireCss('cnddaterange-css');

        AssetPipeline::requireJs('pickadate-picker-js');
        AssetPipeline::requireJs('pickadate-picker-date-js');
        AssetPipeline::requireJs('daterangepicker-js');
        AssetPipeline::requireJs('datetime-js');
    }

    /**
     * Display all material
     * @param ProductCouponDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(ProductCouponDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-product::coupon.list'));

        return $dataTable->renderTable(['title' => trans('plugins-product::coupon.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        $this->addAssets();
        page_title()->setTitle(trans('plugins-product::coupon.create'));

        $list = $this->productCategoryRepository->all();

        foreach ($list as $row) {
            $categories[$row->id] = $row->name;
        }
        $categories = [0 => trans('plugins-blog::categories.none')] + $categories;

        return view('plugins-product::coupon.create', compact('categories'));
    }

    /**
     * @param ProductCouponRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ProductCouponRequest $request, BaseHttpResponse $response)
    {
        $numberCoupons = $request->get('number_coupon', 0);
        $coupons = array();
        while ( $numberCoupons > 0) {
            # code...
            $this->productCouponRepository->createOrUpdate(array_merge($request->input(), [
                'created_by'   => Auth::user()->getKey(),
                'updated_by'   => Auth::user()->getKey(),
                'coupon_value' => (float)preg_replace("/[^0-9.]/", "", $request->coupon_value),
                'code'         => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10)
            ]));

            $numberCoupons--;
        }

        return $response
            ->setPreviousUrl(route('admin.product.coupon.list'))
            ->setNextUrl(route('admin.product.coupon.list'))
            ->setMessage(trans('core-base::notices.create_success_message'));
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
        $this->addAssets();
        $coupon = $this->productCouponRepository->findOrFail($id);
        $list   = $this->productCategoryRepository->all();

        foreach ($list as $row) {
            $categories[$row->id] = $row->name;
        }
        $categories = [0 => trans('plugins-blog::categories.none')] + $categories;

        page_title()->setTitle(trans('plugins-product::coupon.edit') . ' #' . $id);

        return view('plugins-product::coupon.edit', compact('coupon', 'categories'));
    }

    /**
     * @param $id
     * @param ProductCouponRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, ProductCouponRequest $request, BaseHttpResponse $response)
    {
        $coupon = $this->productCouponRepository->findOrFail($id);

        $coupon->fill($request->input());
        $coupon->updated_by = Auth::id();
        $coupon->coupon_value = (float)preg_replace("/[^0-9.]/", "", $request->coupon_value);

        $this->productCouponRepository->createOrUpdate($coupon);

        return $response
            ->setPreviousUrl(route('admin.product.coupon.list'))
            ->setMessage(trans('core-base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $coupon = $this->productCouponRepository->findOrFail($id);
            $this->productCouponRepository->delete($coupon);
            return $response->setMessage(trans('core-base::notices.delete_success_message'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage(trans('core-base::notices.cannot_delete'));
        }
    }
}