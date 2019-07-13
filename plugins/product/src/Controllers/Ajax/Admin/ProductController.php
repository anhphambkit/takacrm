<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-21
 * Time: 12:27
 */

namespace Plugins\Product\Controllers\Ajax\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use http\Env\Response;
use Illuminate\Http\Request;
use Plugins\Product\Models\Product;
use Plugins\Product\Models\ProductBusinessType;
use Plugins\Product\Models\ProductCategory;
use Plugins\Product\Models\ProductSpace;
use Plugins\Product\Services\ProductServices;
use Plugins\Product\Requests\ImportProductRequest;

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
        $categoryId = (int)$request->get('category_id');
        $category = ProductCategory::find($categoryId);
        $products = $category->products()->get();
        return response()->json($products);
    }

    /**
     * Description
     * @param Request $request
     * @return type
     */
    public function getInfoPriceProduct(Request $request)
    {
        $productId = (int)$request->get('product_id');
        $product = $this->productServices->getInfoPriceProduct($productId);
        return response()->json($product);
    }

    /**
     * get template excel for import product
     * @return mixed
     */
    public function downloadTemplateExcel(){
        $file = $this->productServices->getTemplateExcel();
        return response()->json($file);
    }

    /**
     * import product action from template excel file
     * @param ImportProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importProduct(ImportProductRequest $request){
        $result = $this->productServices->importProduct($request->file('templates'));
        if(!$result)
            return response()->json(['message' => 'Vui lòng điền đầy đủ thông tin'], 400);
        return response()->json(['message'  => 'File has been import success']);
    }
}
