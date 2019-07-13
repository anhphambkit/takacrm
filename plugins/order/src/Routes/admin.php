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

$router->group(['prefix' => 'order'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.order.list',
        'uses' => 'OrderController@getList',
        'middleware' => 'access:order.list'
    ]);

    $router->get('/create', [
        'as' => 'admin.order.create',
        'uses' => 'OrderController@getCreate',
        'middleware' => 'access:order.create'
    ]);

    $router->post('/create', [
        'as' => 'admin.order.create',
        'uses' => 'OrderController@postCreate',
        'middleware' => 'access:order.create'
    ]);

    $router->get('/detail/{id}', [
        'as' => 'admin.order.detail',
        'uses' => 'OrderController@getDetail',
        'middleware' => 'access:order.view'
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.order.edit',
        'uses' => 'OrderController@getEdit',
        'middleware' => 'access:order.edit'
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.order.edit',
        'uses' => 'OrderController@postEdit',
        'middleware' => 'access:order.edit'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.order.delete',
        'uses' => 'OrderController@getDelete',
        'middleware' => 'access:order.delete'
    ]);

    $router->group(['prefix' => 'payment'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.order.payment.method.list',
            'uses' => 'PaymentMethodController@getList',
            'middleware' => 'access:order.payments.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.order.payment.method.create',
            'uses' => 'PaymentMethodController@getCreate',
            'middleware' => 'access:order.payments.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.order.payment.method.create',
            'uses' => 'PaymentMethodController@postCreate',
            'middleware' => 'access:order.payments.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.order.payment.method.edit',
            'uses' => 'PaymentMethodController@getEdit',
            'middleware' => 'access:order.payments.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.order.payment.method.edit',
            'uses' => 'PaymentMethodController@postEdit',
            'middleware' => 'access:order.payments.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.order.payment.method.delete',
            'uses' => 'PaymentMethodController@getDelete',
            'middleware' => 'access:order.payments.delete'
        ]);

    });

    $router->group(['prefix' => 'source'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.order.source.method.list',
            'uses' => 'SourceOrderController@getList',
            'middleware' => 'access:order.sources.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.order.source.method.create',
            'uses' => 'SourceOrderController@getCreate',
            'middleware' => 'access:order.sources.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.order.source.method.create',
            'uses' => 'SourceOrderController@postCreate',
            'middleware' => 'access:order.sources.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.order.source.method.edit',
            'uses' => 'SourceOrderController@getEdit',
            'middleware' => 'access:order.sources.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.order.source.method.edit',
            'uses' => 'SourceOrderController@postEdit',
            'middleware' => 'access:order.sources.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.order.source.method.delete',
            'uses' => 'SourceOrderController@getDelete',
            'middleware' => 'access:order.sources.delete'
        ]);

    });
});

	