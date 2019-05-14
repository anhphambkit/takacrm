<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-21
 * Time: 12:27
 */

namespace Plugins\Product\Controllers\Ajax\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Plugins\Product\Models\ProductBusinessType;
use Plugins\Product\Models\ProductCategory;
use Plugins\Product\Models\ProductSpace;
use Plugins\Product\Services\ProductServices;

class ProductController extends BaseAdminController
{
    /**
     * @var ProductServices
     */
    protected $productServices;

    public function __construct(ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    /**
     * Description
     * @param Request $request 
     * @return type
     */
    public function getProductsByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');
        $category = ProductCategory::find($categoryId);
        $products = $category->products()->get();
        return response()->json($products);
    }
}