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
        'middleware' => 'access:custom-attributes.list'
    ]);

    $router->get('/create', [
        'as' => 'admin.custom-attributes.create',
        'uses' => 'CustomAttributesController@getCreate',
        'middleware' => 'access:custom-attributes.create'
    ]);

    $router->post('/create', [
        'as' => 'admin.custom-attributes.create',
        'uses' => 'CustomAttributesController@postCreate',
        'middleware' => 'access:custom-attributes.create'
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.custom-attributes.edit',
        'uses' => 'CustomAttributesController@getEdit',
        'middleware' => 'access:custom-attributes.edit'
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.custom-attributes.edit',
        'uses' => 'CustomAttributesController@postEdit',
        'middleware' => 'access:custom-attributes.edit'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.custom-attributes.delete',
        'uses' => 'CustomAttributesController@getDelete',
        'middleware' => 'access:custom-attributes.delete'
    ]);

    $router->group(['prefix' => '{typeEntity}'], function (Router $router) {
        $router->get('/', [
            'as' => 'admin.custom-attributes.entity.list',
            'uses' => 'CustomAttributesController@getListByEntity',
            'middleware' => 'access:custom-attributes.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.custom-attributes.entity.create',
            'uses' => 'CustomAttributesController@getCreateByEntity',
            'middleware' => 'access:custom-attributes.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.custom-attributes.entity.create',
            'uses' => 'CustomAttributesController@postCreateByEntity',
            'middleware' => 'access:custom-attributes.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.custom-attributes.entity.edit',
            'uses' => 'CustomAttributesController@getEditByEntity',
            'middleware' => 'access:custom-attributes.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.custom-attributes.entity.edit',
            'uses' => 'CustomAttributesController@postEditByEntity',
            'middleware' => 'access:custom-attributes.edit'
        ]);
    });
});

	