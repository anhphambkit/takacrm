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

$router->group(['prefix' => 'tenant'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.tenant.list',
        'uses' => 'TenantController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.tenant.create',
        'uses' => 'TenantController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.tenant.create',
        'uses' => 'TenantController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.tenant.edit',
        'uses' => 'TenantController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.tenant.edit',
        'uses' => 'TenantController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.tenant.delete',
        'uses' => 'TenantController@getDelete',
    ]);
});

	