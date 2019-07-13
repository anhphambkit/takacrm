<?php

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Routing\Router;

$router->group(['prefix' => 'admin'], function (Router $router) {

    $router->get('/get-introduce-persons-by-type-reference', [
        'as' => 'ajax.admin.get_introduce_persons_by_type_reference',
        'uses' => 'Admin\CustomerController@getIntroducePersonsByReference',
//        'middleware' => ['access:customer_relation.create', 'access:customer_relation.edit']
    ]);

    $router->get('/get-list-customer', [
        'as' => 'ajax.admin.get_list_customer',
        'uses' => 'Admin\CustomerController@getListCustomer',
        'middleware' => 'access:customer.list'
    ]);

    $router->post('/update-data-relation-of-customer', [
        'as' => 'ajax.admin.update_data_relation_of_customer',
        'uses' => 'Admin\CustomerController@updateDataRelationCustomer',
        'middleware' => 'access:customer_relation.edit'
    ]);

    $router->get('/get-customer-query-list', [
        'as' => 'ajax.admin.get_customer_query_list',
        'uses' => 'Admin\CustomerController@getCustomerQueryList',
        'middleware' => 'access:customer.list'
    ]);

    $router->get('/get-data-customer-query-list', [
        'as' => 'ajax.admin.get_data_customer_query_list',
        'uses' => 'Admin\CustomerController@getDataCustomerQueryList',
        'middleware' => 'access:customer.list'
    ]);

    $router->post('/create-customer-query-list', [
        'as' => 'ajax.admin.create_customer_query_list',
        'uses' => 'Admin\CustomerController@createCustomerQueryList',
        'middleware' => 'access:customer.list'
    ]);

    $router->post('/update-customer-query-list', [
        'as' => 'ajax.admin.update_customer_query_list',
        'uses' => 'Admin\CustomerController@updateCustomerQueryList',
        'middleware' => 'access:customer.list'
    ]);

    $router->get('/delete-customer-query-list/{id}', [
        'as' => 'ajax.admin.delete_customer_query_list',
        'uses' => 'Admin\CustomerController@deleteCustomerQueryList',
        'middleware' => 'access:customer.list'
    ]);

    $router->get('/search-ajax-customer', [
        'as' => 'ajax.admin.search_ajax_customer',
        'uses' => 'Admin\CustomerController@searchAjaxCustomer',
//        'middleware' => 'access:customer_relation.list'
    ]);

    $router->get('/get-info-with-contact-of-customer', [
        'as' => 'ajax.admin.get_info_with_contact_of_customer',
        'uses' => 'Admin\CustomerController@getInfoWithContactOfCustomer',
//        'middleware' => 'access:customer_relation.list'
    ]);

});