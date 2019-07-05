<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'user'], function (Router $router) {
   
    $router->get('/users', [
        'as' => 'admin.user.index',
        'uses' => 'UserController@index',
        'middleware' => 'access:user.index'
    ]);

    $router->get('/create', [
        'as' => 'admin.user.create',
        'uses' => 'UserController@getCreate',
        'middleware' => 'access:user.create'
    ]);

    $router->post('/create', [
        'as' => 'admin.user.create',
        'uses' => 'UserController@postCreate',
        'middleware' => 'access:user.create'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.user.delete',
        'uses' => 'UserController@getDelete',
        'middleware' => 'access:user.delete'
    ]);

    $router->get('/search', [
        'as' => 'admin.user.search',
        'uses' => 'UserController@search',
        'middleware' => 'access:user.search'
    ]);

    $router->get('/profile/{id}', [
        'as' => 'admin.user.profile',
        'uses' => 'UserController@getUserProfile',
        'middleware' => 'access:user.update-profile'
    ]);

    $router->post('/update-profile/{id}', [
        'as' => 'admin.user.update-profile',
        'uses' => 'UserController@postUpdateProfile',
        'middleware' => 'access:user.update-profile'
    ]);

    $router->post('/profile/image', [
        'as' => 'admin.profile.image',
        'uses' => 'UserController@postModifyProfileImage',
        'middleware' => 'access:user.update-profile'
    ]);

    $router->post('/change-password/{id}', [
        'as' => 'admin.user.change-password',
        'uses' => 'UserController@postChangePassword',
        'middleware' => 'access:user.update-profile'
    ]);
    
});

$router->group(['prefix' =>'super-user'], function (Router $router) {
   
    $router->get('/users', [
        'as' => 'admin.super-user.index',
        'uses' => 'SuperUserController@index',
        'middleware' => 'access:false'
    ]);

    $router->get('/create', [
        'as' => 'admin.super-user.create',
        'uses' => 'SuperUserController@getCreate',
        'middleware' => 'access:false'
    ]);

    $router->post('/create', [
        'as' => 'admin.super-user.create',
        'uses' => 'SuperUserController@postCreate',
        'middleware' => 'access:false'
    ]);
});

$router->group(['prefix' =>'role'], function (Router $router) {
   
    $router->get('/roles', [
        'as' => 'admin.role.index',
        'uses' => 'RoleController@index',
        'middleware' => 'access:role.index'
    ]);

    $router->get('/create', [
        'as' => 'admin.role.create',
        'uses' => 'RoleController@getCreate',
        'middleware' => 'access:role.create'
    ]);

    $router->post('/create', [
        'as' => 'admin.role.create',
        'uses' => 'RoleController@postCreate',
        'middleware' => 'access:role.create'
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.role.edit',
        'uses' => 'RoleController@getEdit',
        'middleware' => 'access:role.edit'
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.role.edit',
        'uses' => 'RoleController@postEdit',
        'middleware' => 'access:role.edit'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.role.delete',
        'uses' => 'RoleController@getDelete',
        'middleware' => 'access:role.delete'
    ]);

    $router->post('/roles/assign', [
        'as' => 'admin.roles.assign',
        'uses' => 'RoleController@postAssignMember',
        'middleware' => 'access:role.assign'
    ]);

    $router->get('/roles/list', [
        'as' => 'admin.roles.list.json',
        'uses' => 'RoleController@getJson',
        'middleware' => 'access:role.list'
    ]);
});


