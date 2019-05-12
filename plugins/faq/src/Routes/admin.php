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

$router->group(['prefix' => 'faq'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.faq.list',
        'uses' => 'FaqController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.faq.create',
        'uses' => 'FaqController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.faq.create',
        'uses' => 'FaqController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.faq.edit',
        'uses' => 'FaqController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.faq.edit',
        'uses' => 'FaqController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.faq.delete',
        'uses' => 'FaqController@getDelete',
    ]);
});

	