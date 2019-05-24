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
});

	