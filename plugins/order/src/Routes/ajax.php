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

    $router->get('/get-list-order', [
        'as' => 'ajax.admin.get_list_order',
        'uses' => 'Admin\OrderController@getListOrder',
        'middleware' => 'access:order.list'
    ]);

    /** quick add resource */
    $router->post('/quick-add-order-resource', 'Admin\OrderController@quickAddOrderSource')
           ->name('ajax.admin.order.quick_add_resource');

    $router->post('/quick-add-customer-group', 'Admin\OrderController@quickAddCustomerGroup')
        ->name('ajax.admin.order.quick_add_customer_group');

    $router->post('/quick-add-customer-source', 'Admin\OrderController@quickAddCustomerSource')
        ->name('ajax.admin.order.quick_add_customer_source');

    $router->post('/quick-add-customer-job', 'Admin\OrderController@quickAddCustomerJob')
        ->name('ajax.admin.order.quick_add_customer_job');

    $router->post('quick-add-customer', 'Admin\OrderController@quickAddCustomer')
        ->name('ajax.admin.order.quick_add_customer');
    /** end quick add resource */

});
