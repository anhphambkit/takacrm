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

$router->group(['prefix' => 'blog'], function (Router $router) {
    
    $router->get('tag/{slug?}', [
        'as' => 'public.blog.tag',
        'uses' => 'BlogController@getTag',
    ]);
});