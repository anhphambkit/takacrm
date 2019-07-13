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
        'middleware' => 'access:customer.list'
    ]);

    $router->get('/create', [
        'as' => 'admin.customer.create',
        'uses' => 'CustomerController@getCreate',
        'middleware' => 'access:customer.create'
    ]);

    $router->post('/create', [
        'as' => 'admin.customer.create',
        'uses' => 'CustomerController@postCreate',
        'middleware' => 'access:customer.create'
    ]);

    $router->get('/detail/{id}', [
        'as' => 'admin.customer.detail',
        'uses' => 'CustomerController@getDetail',
        'middleware' => 'access:customer.view'
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.customer.edit',
        'uses' => 'CustomerController@getEdit',
        'middleware' => 'access:customer.edit'
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.customer.edit',
        'uses' => 'CustomerController@postEdit',
        'middleware' => 'access:customer.edit'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.customer.delete',
        'uses' => 'CustomerController@getDelete',
        'middleware' => 'access:customer.delete'
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
            'middleware' => 'access:group_customer.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.group_customer.create',
            'uses' => 'GroupCustomerController@getCreate',
            'middleware' => 'access:group_customer.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.group_customer.create',
            'uses' => 'GroupCustomerController@postCreate',
            'middleware' => 'access:group_customer.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.group_customer.edit',
            'uses' => 'GroupCustomerController@getEdit',
            'middleware' => 'access:group_customer.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.group_customer.edit',
            'uses' => 'GroupCustomerController@postEdit',
            'middleware' => 'access:group_customer.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.group_customer.delete',
            'uses' => 'GroupCustomerController@getDelete',
            'middleware' => 'access:group_customer.delete'
        ]);

    });

    $router->group(['prefix' => 'customer-source'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.customer.customer_source.list',
            'uses' => 'CustomerSourcesController@getList',
            'middleware' => 'access:customer_source.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.customer_source.create',
            'uses' => 'CustomerSourcesController@getCreate',
            'middleware' => 'access:customer_source.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.customer_source.create',
            'uses' => 'CustomerSourcesController@postCreate',
            'middleware' => 'access:customer_source.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.customer_source.edit',
            'uses' => 'CustomerSourcesController@getEdit',
            'middleware' => 'access:customer_source.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.customer_source.edit',
            'uses' => 'CustomerSourcesController@postEdit',
            'middleware' => 'access:customer_source.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.customer_source.delete',
            'uses' => 'CustomerSourcesController@getDelete',
            'middleware' => 'access:customer_source.delete'
        ]);

    });

    // Customer Jobs:
    $router->group(['prefix' => 'customer-job'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.customer.customer_job.list',
            'uses' => 'CustomerJobsController@getList',
            'middleware' => 'access:customer_job.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.customer_job.create',
            'uses' => 'CustomerJobsController@getCreate',
            'middleware' => 'access:customer_job.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.customer_job.create',
            'uses' => 'CustomerJobsController@postCreate',
            'middleware' => 'access:customer_job.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.customer_job.edit',
            'uses' => 'CustomerJobsController@getEdit',
            'middleware' => 'access:customer_job.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.customer_job.edit',
            'uses' => 'CustomerJobsController@postEdit',
            'middleware' => 'access:customer_job.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.customer_job.delete',
            'uses' => 'CustomerJobsController@getDelete',
            'middleware' => 'access:customer_job.delete'
        ]);

    });

    // Customer Relation:
    $router->group(['prefix' => 'customer-relation'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.customer.customer_relation.list',
            'uses' => 'CustomerRelationController@getList',
            'middleware' => 'access:customer_relation.list'
        ]);

        $router->get('/create', [
            'as' => 'admin.customer.customer_relation.create',
            'uses' => 'CustomerRelationController@getCreate',
            'middleware' => 'access:customer_relation.create'
        ]);

        $router->post('/create', [
            'as' => 'admin.customer.customer_relation.create',
            'uses' => 'CustomerRelationController@postCreate',
            'middleware' => 'access:customer_relation.create'
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.customer.customer_relation.edit',
            'uses' => 'CustomerRelationController@getEdit',
            'middleware' => 'access:customer_relation.edit'
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.customer.customer_relation.edit',
            'uses' => 'CustomerRelationController@postEdit',
            'middleware' => 'access:customer_relation.edit'
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.customer.customer_relation.delete',
            'uses' => 'CustomerRelationController@getDelete',
            'middleware' => 'access:customer_relation.delete'
        ]);

    });

});

	