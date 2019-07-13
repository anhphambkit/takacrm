<?php

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Routing\Router;

$router->group(['prefix' => 'admin'], function (Router $router) {

    $router->get('/get-products-by-category', [
        'as' => 'ajax.admin.get_products_by_category',
        'uses' => 'Admin\ProductController@getProductsByCategory',
    ]);

    $router->get('/get-info-price-product', [
        'as' => 'ajax.admin.get_info_price_product',
        'uses' => 'Admin\ProductController@getInfoPriceProduct',
    ]);

    /** import product */
    $router->group(['prefix' => 'product'], function (Router $route){
        $route->get('/import/download', 'Admin\ProductController@downloadTemplateExcel')
            ->name('ajax.admin.product.import.download');

        $route->post('/import/process', 'Admin\ProductController@importProduct')
            ->name('ajax.admin.product.import.process');
    });

    /** end import product */

});
