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

$router->group(['prefix' => 'product'], function (Router $router) {

    $router->get('/{url}', [
        'as' => 'public.product.landing_page',
        'uses' => 'ProductController@getLandingPageProduct',
    ]);
});