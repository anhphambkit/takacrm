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

$router->group(['prefix' => 'newsletter'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.newsletter.list',
        'uses' => 'NewsletterController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.newsletter.create',
        'uses' => 'NewsletterController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.newsletter.create',
        'uses' => 'NewsletterController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.newsletter.edit',
        'uses' => 'NewsletterController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.newsletter.edit',
        'uses' => 'NewsletterController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.newsletter.delete',
        'uses' => 'NewsletterController@getDelete',
    ]);
});

	