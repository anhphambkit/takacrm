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

    $router->group(['prefix' => 'color'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.color.list',
            'uses' => 'ProductColorController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.color.create',
            'uses' => 'ProductColorController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.color.create',
            'uses' => 'ProductColorController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.color.edit',
            'uses' => 'ProductColorController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.color.edit',
            'uses' => 'ProductColorController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.color.delete',
            'uses' => 'ProductColorController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'business-type'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.business-type.list',
            'uses' => 'ProductBusinessTypeController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.business-type.create',
            'uses' => 'ProductBusinessTypeController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.business-type.create',
            'uses' => 'ProductBusinessTypeController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.business-type.edit',
            'uses' => 'ProductBusinessTypeController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.business-type.edit',
            'uses' => 'ProductBusinessTypeController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.business-type.delete',
            'uses' => 'ProductBusinessTypeController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'space'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.space.list',
            'uses' => 'ProductSpacesController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.space.create',
            'uses' => 'ProductSpacesController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.space.create',
            'uses' => 'ProductSpacesController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.space.edit',
            'uses' => 'ProductSpacesController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.space.edit',
            'uses' => 'ProductSpacesController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.space.delete',
            'uses' => 'ProductSpacesController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'collection'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.collection.list',
            'uses' => 'ProductCollectionController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.collection.create',
            'uses' => 'ProductCollectionController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.collection.create',
            'uses' => 'ProductCollectionController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.collection.edit',
            'uses' => 'ProductCollectionController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.collection.edit',
            'uses' => 'ProductCollectionController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.collection.delete',
            'uses' => 'ProductCollectionController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'material'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.material.list',
            'uses' => 'ProductMaterialController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.material.create',
            'uses' => 'ProductMaterialController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.material.create',
            'uses' => 'ProductMaterialController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.material.edit',
            'uses' => 'ProductMaterialController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.material.edit',
            'uses' => 'ProductMaterialController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.material.delete',
            'uses' => 'ProductMaterialController@getDelete',
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

    $router->group(['prefix' => 'look_book'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.look_book.list',
            'uses' => 'LookBookController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.look_book.create',
            'uses' => 'LookBookController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.look_book.create',
            'uses' => 'LookBookController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.look_book.edit',
            'uses' => 'LookBookController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.look_book.edit',
            'uses' => 'LookBookController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.look_book.delete',
            'uses' => 'LookBookController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'coupon'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.coupon.list',
            'uses' => 'ProductCouponController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.coupon.create',
            'uses' => 'ProductCouponController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.coupon.create',
            'uses' => 'ProductCouponController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.coupon.edit',
            'uses' => 'ProductCouponController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.coupon.edit',
            'uses' => 'ProductCouponController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.coupon.delete',
            'uses' => 'ProductCouponController@getDelete',
        ]);
    });

});

	