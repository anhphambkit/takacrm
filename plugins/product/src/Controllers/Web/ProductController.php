<?php

namespace Plugins\Product\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use AssetManager;
use AssetPipeline;

class ProductController extends BasePublicController
{
    /**
     * @var ProductRepositories
     */
    protected $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepositories $productRepository
     */
    public function __construct(ProductRepositories $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLandingPageProduct($url) {
        $productId = get_id_from_url($url);
        page_title()->setTitle(trans('plugins-product::product.detail') . ' #' . $productId);
        $product = $this->productRepository->findById($productId);

        $galleries = [];
        if ($product->galleries != null)
            $galleries = $product->galleries->pluck('media')->all();

        if (empty($product))
            abort(404);

        $this->addAssets();
        return view('plugins-product::product.landing-product-page', compact('product', 'galleries'));
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addAssets()
    {
        AssetManager::addAsset('landing-page-css', 'frontend/plugins/product/assets/css/landing-page.css');
        AssetPipeline::requireCss('landing-page-css');
        AssetManager::addAsset('landing-page-js', 'frontend/plugins/product/assets/js/product-landing-page.js');
        AssetPipeline::requireJs('landing-page-js');
    }
}