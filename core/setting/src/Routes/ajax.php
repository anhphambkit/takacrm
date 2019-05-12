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

$router->group(['prefix' => 'address'], function (Router $router) {
    $router->get('/refresh-districts', 'AddressController@getDistrictsByCity')
        ->name('ajax.address.refresh_districts');

    $router->get('/refresh-wards', 'AddressController@getWardsByDistrict')
        ->name('ajax.address.refresh_wards');
});
