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

Route::get('/', function () {
	return view('homepage');
});

/** @var Router $router */
$router->group(['prefix' => 'auth'], function (Router $router) {
    # Login
    $router->get('login', [
		'as'         => 'login', 
		'uses'       => 'LoginController@showLoginForm',
    ]);

    $router->post('login', [ 
		'as'         => 'post.login', 
		'uses'       => 'LoginController@login',
    ]);

    $router->post('register', [ 
		'as'         => 'register', 
		'uses'       => 'WebController@showRegisterForm',
		'middleware' => 'guest', 
    ]);
   
    # Logout
    $router->get('logout', [
		'as'         => 'logout', 
		'uses'       => 'LoginController@logout',
		'middleware' => 'auth', 
    ]);

    $router->get('reset', [
		'as'         => 'auth.reset', 
		'uses'       => 'ForgotPasswordController@showLinkRequestForm',
		'middleware' => 'guest', 
    ]);

    $router->post('reset', [
		'as'         => 'auth.reset', 
		'uses'       => 'ForgotPasswordController@sendResetLinkEmail',
		'middleware' => 'guest', 
    ]);

    $router->get('password/reset/{token}', [
		'as'         => 'auth.reset.complete', 
		'uses'       => 'ResetPasswordController@showResetForm',
		'middleware' => 'guest', 
    ]);

    $router->post('password/reset', [
		'as'         => 'auth.reset.complete.post', 
		'uses'       => 'ResetPasswordController@reset',
		'middleware' => 'guest', 
    ]);
});