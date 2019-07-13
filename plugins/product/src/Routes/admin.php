<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' => 'product'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.product.list',
        'uses' => 'ProductController@getList',
        'middleware' => 'access:products.list'
    ]);

    $router->get('/create', [
        'as' => 'admin.product.create',
        'uses' => 'ProductController@getCreate',
        'middleware' => 'access:products.create'
    ]);

    $router->post('/create', [
        'as' => 'admin.product.create',
        'uses' => 'ProductController@postCreate',
        'middleware' => 'access:products.create'
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.product.edit',
        'uses' => 'ProductController@getEdit',
        'middleware' => 'access:products.edit'
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.product.edit',
        'uses' => 'ProductController@postEdit',
        'middleware' => 'access:products.edit'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.product.delete',
        'uses' => 'ProductController@getDelete',
        'middleware' => 'access:products.delete'
    ]);

    $router->get('detail/{id}', [
        'as'    => 'admin.product.detail',
        'uses'  => 'ProductController@getDetail',
        'middleware' => 'access:products.view'
    ]);

    $router->group(['prefix' => 'manufacturer'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.manufacturer.list',
            'uses' => 'ManufacturerController@getList',
            'middleware' => 'access:product_manufacturers.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.product.manufacturer.create',
            'uses' => 'ManufacturerController@getCreate',
            'middleware' => 'access:product_manufacturers.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.product.manufacturer.create',
            'uses' => 'ManufacturerController@postCreate',
            'middleware' => 'access:product_manufacturers.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.manufacturer.edit',
            'uses' => 'ManufacturerController@getEdit',
            'middleware' => 'access:product_manufacturers.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.manufacturer.edit',
            'uses' => 'ManufacturerController@postEdit',
            'middleware' => 'access:product_manufacturers.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.manufacturer.delete',
            'uses' => 'ManufacturerController@getDelete',
            'middleware' => 'access:product_manufacturers.delete'
        ]);

    });

    $router->group(['prefix' => 'category'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.category.list',
            'uses' => 'ProductCategoryController@getList',
            'middleware' => 'access:product_categories.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.product.category.create',
            'uses' => 'ProductCategoryController@getCreate',
            'middleware' => 'access:product_categories.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.product.category.create',
            'uses' => 'ProductCategoryController@postCreate',
            'middleware' => 'access:product_categories.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.category.edit',
            'uses' => 'ProductCategoryController@getEdit',
            'middleware' => 'access:product_categories.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.category.edit',
            'uses' => 'ProductCategoryController@postEdit',
            'middleware' => 'access:product_categories.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.category.delete',
            'uses' => 'ProductCategoryController@getDelete',
            'middleware' => 'access:product_categories.delete'
        ]);

    });

    $router->group(['prefix' => 'unit'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.unit.list',
            'uses' => 'ProductUnitController@getList',
            'middleware' => 'access:product_units.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.product.unit.create',
            'uses' => 'ProductUnitController@getCreate',
            'middleware' => 'access:product_units.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.product.unit.create',
            'uses' => 'ProductUnitController@postCreate',
            'middleware' => 'access:product_units.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.unit.edit',
            'uses' => 'ProductUnitController@getEdit',
            'middleware' => 'access:product_units.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.unit.edit',
            'uses' => 'ProductUnitController@postEdit',
            'middleware' => 'access:product_units.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.unit.delete',
            'uses' => 'ProductUnitController@getDelete',
            'middleware' => 'access:product_units.delete'
        ]);

    });

    $router->group(['prefix' => 'origin'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.origin.list',
            'uses' => 'ProductOriginController@getList',
            'middleware' => 'access:product_origins.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.product.origin.create',
            'uses' => 'ProductOriginController@getCreate',
            'middleware' => 'access:product_origins.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.product.origin.create',
            'uses' => 'ProductOriginController@postCreate',
            'middleware' => 'access:product_origins.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.origin.edit',
            'uses' => 'ProductOriginController@getEdit',
            'middleware' => 'access:product_origins.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.origin.edit',
            'uses' => 'ProductOriginController@postEdit',
            'middleware' => 'access:product_origins.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.origin.delete',
            'uses' => 'ProductOriginController@getDelete',
            'middleware' => 'access:product_origins.delete'
        ]);

    });

});

