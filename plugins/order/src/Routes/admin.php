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
    ]);

    $router->get('/create', [
        'as' => 'admin.order.create',
        'uses' => 'OrderController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.order.create',
        'uses' => 'OrderController@postCreate',
    ]);

    $router->get('/detail/{id}', [
        'as' => 'admin.order.detail',
        'uses' => 'OrderController@getDetail',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.order.edit',
        'uses' => 'OrderController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.order.edit',
        'uses' => 'OrderController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.order.delete',
        'uses' => 'OrderController@getDelete',
    ]);

    $router->group(['prefix' => 'payment'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.order.payment.method.list',
            'uses' => 'PaymentMethodController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.order.payment.method.create',
            'uses' => 'PaymentMethodController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.order.payment.method.create',
            'uses' => 'PaymentMethodController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.order.payment.method.edit',
            'uses' => 'PaymentMethodController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.order.payment.method.edit',
            'uses' => 'PaymentMethodController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.order.payment.method.delete',
            'uses' => 'PaymentMethodController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'source'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.order.source.method.list',
            'uses' => 'SourceOrderController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.order.source.method.create',
            'uses' => 'SourceOrderController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.order.source.method.create',
            'uses' => 'SourceOrderController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.order.source.method.edit',
            'uses' => 'SourceOrderController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.order.source.method.edit',
            'uses' => 'SourceOrderController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.order.source.method.delete',
            'uses' => 'SourceOrderController@getDelete',
        ]);

    });
});

	