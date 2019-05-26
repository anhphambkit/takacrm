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

$router->group(['prefix' => 'custom-attributes'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.custom-attributes.list',
        'uses' => 'CustomAttributesController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.custom-attributes.create',
        'uses' => 'CustomAttributesController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.custom-attributes.create',
        'uses' => 'CustomAttributesController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.custom-attributes.edit',
        'uses' => 'CustomAttributesController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.custom-attributes.edit',
        'uses' => 'CustomAttributesController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.custom-attributes.delete',
        'uses' => 'CustomAttributesController@getDelete',
    ]);

    $router->group(['prefix' => '{typeEntity}'], function (Router $router) {
        $router->get('/', [
            'as' => 'admin.custom-attributes.entity.list',
            'uses' => 'CustomAttributesController@getListByEntity',
        ]);

        $router->get('/create', [
            'as' => 'admin.custom-attributes.entity.create',
            'uses' => 'CustomAttributesController@getCreateByEntity',
        ]);

        $router->post('/create', [
            'as' => 'admin.custom-attributes.entity.create',
            'uses' => 'CustomAttributesController@postCreateByEntity',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.custom-attributes.entity.edit',
            'uses' => 'CustomAttributesController@getEditByEntity',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.custom-attributes.entity.edit',
            'uses' => 'CustomAttributesController@postEditByEntity',
        ]);
    });
});

	