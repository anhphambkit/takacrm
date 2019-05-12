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

$router->group(['prefix' =>'dashboard'], function (Router $router) {
   
    $router->get('/', [
        'as' => 'admin.dashboard.index',
        'uses' => 'DashboardController@index',
        'middleware' => 'access:dashboard.index'
    ]);
    
});


