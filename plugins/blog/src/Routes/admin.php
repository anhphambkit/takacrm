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

$router->group(['prefix' => 'blog/post'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.blog.post.list',
        'uses' => 'PostController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.blog.post.create',
        'uses' => 'PostController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.blog.post.create',
        'uses' => 'PostController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.blog.post.edit',
        'uses' => 'PostController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.blog.post.edit',
        'uses' => 'PostController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.blog.post.delete',
        'uses' => 'PostController@getDelete',
    ]);
});

$router->group(['prefix' => 'blog/category'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.blog.category.list',
        'uses' => 'CategoryController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.blog.category.create',
        'uses' => 'CategoryController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.blog.category.create',
        'uses' => 'CategoryController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.blog.category.edit',
        'uses' => 'CategoryController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.blog.category.edit',
        'uses' => 'CategoryController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.blog.category.delete',
        'uses' => 'CategoryController@getDelete',
    ]);
});

$router->group(['prefix' => 'blog/tag'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.blog.tag.list',
        'uses' => 'TagController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.blog.tag.create',
        'uses' => 'TagController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.blog.tag.create',
        'uses' => 'TagController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.blog.tag.edit',
        'uses' => 'TagController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.blog.tag.edit',
        'uses' => 'TagController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.blog.tag.delete',
        'uses' => 'TagController@getDelete',
    ]);

    $router->post('create-slug', [
        'as' => 'admin.blog.tag.create.slug',
        'uses' => 'TagController@postCreateSlug',
    ]);
});

	