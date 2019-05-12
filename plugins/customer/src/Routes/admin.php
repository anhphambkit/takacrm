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

$router->group(['prefix' => 'customer'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.customer.list',
        'uses' => 'CustomerController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.customer.create',
        'uses' => 'CustomerController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.customer.create',
        'uses' => 'CustomerController@postCreate',
    ]);

    $router->get('/detail/{id}', [
        'as' => 'admin.customer.detail',
        'uses' => 'CustomerController@getDetail',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.customer.edit',
        'uses' => 'CustomerController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.customer.edit',
        'uses' => 'CustomerController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.customer.delete',
        'uses' => 'CustomerController@getDelete',
    ]);

    $router->post('/change-password/{id}', [
        'as' => 'admin.customer.change-password',
        'uses' => 'UserController@postChangePassword',
        'middleware' => 'access:customer.edit'
    ]);

    // Group Customer:
    $router->group(['prefix' => 'group-customer'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.customer.group_customer.list',
            'uses' => 'GroupCustomerController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.group_customer.create',
            'uses' => 'GroupCustomerController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.group_customer.create',
            'uses' => 'GroupCustomerController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.group_customer.edit',
            'uses' => 'GroupCustomerController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.group_customer.edit',
            'uses' => 'GroupCustomerController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.group_customer.delete',
            'uses' => 'GroupCustomerController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'customer-source'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.customer.customer_source.list',
            'uses' => 'CustomerSourcesController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.customer_source.create',
            'uses' => 'CustomerSourcesController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.customer_source.create',
            'uses' => 'CustomerSourcesController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.customer_source.edit',
            'uses' => 'CustomerSourcesController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.customer_source.edit',
            'uses' => 'CustomerSourcesController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.customer_source.delete',
            'uses' => 'CustomerSourcesController@getDelete',
        ]);

    });

    // Customer Jobs:
    $router->group(['prefix' => 'customer-job'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.customer.customer_job.list',
            'uses' => 'CustomerJobsController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.customer_job.create',
            'uses' => 'CustomerJobsController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.customer_job.create',
            'uses' => 'CustomerJobsController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.customer_job.edit',
            'uses' => 'CustomerJobsController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.customer_job.edit',
            'uses' => 'CustomerJobsController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.customer_job.delete',
            'uses' => 'CustomerJobsController@getDelete',
        ]);

    });

    // Customer Relation:
    $router->group(['prefix' => 'customer-relation'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.customer.customer_relation.list',
            'uses' => 'CustomerRelationController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.customer_relation.create',
            'uses' => 'CustomerRelationController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.customer_relation.create',
            'uses' => 'CustomerRelationController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.customer_relation.edit',
            'uses' => 'CustomerRelationController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.customer_relation.edit',
            'uses' => 'CustomerRelationController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.customer_relation.delete',
            'uses' => 'CustomerRelationController@getDelete',
        ]);

    });

});

	