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

$router->group(['prefix' => 'history'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.history.list',
        'uses' => 'HistoryController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.history.create',
        'uses' => 'HistoryController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.history.create',
        'uses' => 'HistoryController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.history.edit',
        'uses' => 'HistoryController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.history.edit',
        'uses' => 'HistoryController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.history.delete',
        'uses' => 'HistoryController@getDelete',
    ]);
});

	