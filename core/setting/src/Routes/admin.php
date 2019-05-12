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

$router->group(['prefix' =>'setting'], function (Router $router) {
   
    $router->get('/systems', [
        'as' => 'admin.setting.system',
        'uses' => 'SettingController@getSystems',
        'middleware' => 'access:setting.system'
    ]);

    $router->post('/systems', [
        'as' => 'admin.setting.system',
        'uses' => 'SettingController@postSystems',
        'middleware' => 'access:setting.system'
    ]);    
});

$router->group(['prefix' =>'theme'], function (Router $router) {
   
    $router->get('/options', [
        'as' => 'admin.setting.option',
        'uses' => 'SettingController@getOptions',
        'middleware' => 'access:setting.option'
    ]);

    $router->post('/options', [
        'as' => 'admin.setting.option',
        'uses' => 'SettingController@postOptions',
        'middleware' => 'access:setting.option'
    ]); 
});