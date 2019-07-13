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
    ]);

    /** quick add resource */
    $router->post('/quick-add-order-resource', 'Admin\OrderController@quickAddOrderSource')
           ->name('ajax.admin.order.quick_add_resource');
    /** end quick add resource */

});
