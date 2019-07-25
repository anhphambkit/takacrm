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

$router->group(['prefix' => 'tenancy'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.tenancy.list',
        'uses' => 'TenancyController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.tenancy.create',
        'uses' => 'TenancyController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.tenancy.create',
        'uses' => 'TenancyController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.tenancy.edit',
        'uses' => 'TenancyController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.tenancy.edit',
        'uses' => 'TenancyController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.tenancy.delete',
        'uses' => 'TenancyController@getDelete',
    ]);
});

	