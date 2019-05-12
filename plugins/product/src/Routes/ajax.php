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

    $router->get('/get-spaces-by-business-type', [
        'as' => 'ajax.admin.get_spaces_by_business_type',
        'uses' => 'Admin\ProductController@getSpacesByBusinessType',
    ]);

    $router->get('/get-all-spaces', [
        'as' => 'ajax.admin.get_all_spaces',
        'uses' => 'Admin\ProductController@getAllSpaces',
    ]);

    $router->get('/get-default-business-type', [
        'as' => 'ajax.admin.get_default_business_type',
        'uses' => 'Admin\ProductController@getDefaultBusinessType',
    ]);

});