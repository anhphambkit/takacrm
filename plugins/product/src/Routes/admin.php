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
    ]);

    $router->get('/create', [
        'as' => 'admin.product.create',
        'uses' => 'ProductController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.product.create',
        'uses' => 'ProductController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.product.edit',
        'uses' => 'ProductController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.product.edit',
        'uses' => 'ProductController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.product.delete',
        'uses' => 'ProductController@getDelete',
    ]);

    $router->group(['prefix' => 'manufacturer'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.manufacturer.list',
            'uses' => 'ManufacturerController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.manufacturer.create',
            'uses' => 'ManufacturerController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.manufacturer.create',
            'uses' => 'ManufacturerController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.manufacturer.edit',
            'uses' => 'ManufacturerController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.manufacturer.edit',
            'uses' => 'ManufacturerController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.manufacturer.delete',
            'uses' => 'ManufacturerController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'category'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.category.list',
            'uses' => 'ProductCategoryController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.category.create',
            'uses' => 'ProductCategoryController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.category.create',
            'uses' => 'ProductCategoryController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.category.edit',
            'uses' => 'ProductCategoryController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.category.edit',
            'uses' => 'ProductCategoryController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.category.delete',
            'uses' => 'ProductCategoryController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'unit'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.unit.list',
            'uses' => 'ProductUnitController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.unit.create',
            'uses' => 'ProductUnitController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.unit.create',
            'uses' => 'ProductUnitController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.unit.edit',
            'uses' => 'ProductUnitController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.unit.edit',
            'uses' => 'ProductUnitController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.unit.delete',
            'uses' => 'ProductUnitController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'origin'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.origin.list',
            'uses' => 'ProductOriginController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.origin.create',
            'uses' => 'ProductOriginController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.origin.create',
            'uses' => 'ProductOriginController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.origin.edit',
            'uses' => 'ProductOriginController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.origin.edit',
            'uses' => 'ProductOriginController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.origin.delete',
            'uses' => 'ProductOriginController@getDelete',
        ]);

    });



    $router->group(['prefix' => 'payment'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.payment.method.list',
            'uses' => 'PaymentMethodController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.payment.method.create',
            'uses' => 'PaymentMethodController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.payment.method.create',
            'uses' => 'PaymentMethodController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.payment.method.edit',
            'uses' => 'PaymentMethodController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.payment.method.edit',
            'uses' => 'PaymentMethodController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.payment.method.delete',
            'uses' => 'PaymentMethodController@getDelete',
        ]);

    });

});

