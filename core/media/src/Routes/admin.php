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

$router->group(['prefix' =>'media'], function (Router $router) {
   
    $router->get('/', [
		'as'         => 'media.index',
		'uses'       => 'MediaController@getMedia',
		'middleware' => 'access:media.index'
    ]);

    $router->get('/popup', [
		'as'         => 'media.popup',
		'uses'       => 'MediaController@getPopup',
		'middleware' => 'access:media.index'
    ]);

    $router->get('/list', [
		'as'         => 'media.list',
		'uses'       => 'MediaController@getList',
		'middleware' => 'access:media.index'
    ]);

    $router->get('/quota', [
		'as'         => 'media.quota',
		'uses'       => 'MediaController@getQuota',
		'middleware' => 'access:media.index'
    ]);

    $router->get('/breadcrumbs', [
		'as'         => 'media.breadcrumbs',
		'uses'       => 'MediaController@getBreadcrumbs',
		'middleware' => 'access:media.index'
    ]);

    $router->post('/global-actions', [
		'as'         => 'media.global_actions',
		'uses'       => 'MediaController@postGlobalActions',
		'middleware' => 'access:media.index'
    ]);

    $router->get('/download', [
		'as'         => 'media.download',
		'uses'       => 'MediaController@download',
		'middleware' => 'access:media.index'
    ]);

    $router->group(['prefix' => 'files'], function (Router $router) {

        $router->post('/upload', [
			'as'         => 'media.files.upload',
			'uses'       => 'MediaFileController@postUpload',
			'middleware' => 'access:media.index'
        ]);

        $router->post('/upload-from-editor', [
			'as'         => 'media.files.upload.from.editor',
			'uses'       => 'MediaFileController@postUploadFromEditor',
			'middleware' => 'access:media.index'
        ]);

        $router->post('/add-external-service', [
			'as'         => 'media.files.add_external_service',
			'uses'       => 'MediaFileController@postAddExternalService',
			'middleware' => 'access:media.index'
        ]);

    });

    $router->group(['prefix' => 'folders'], function (Router $router) {

        $router->post('/create', [
			'as'         => 'media.folders.create',
			'uses'       => 'MediaFolderController@postCreate',
			'middleware' => 'access:media.index'
        ]);
    });

    $router->group(['prefix' => 'users'], function (Router $router) {

        $router->get('/get-list', [
			'as'         => 'media.users.list',
			'uses'       => 'UserController@getList',
			'middleware' => 'access:media.index'
        ]);
    });

    $router->group(['prefix' => 'shares'], function (Router $router) {

        $router->get('/get-shared-users', [
			'as'         => 'media.shares.list_shared_users',
			'uses'       => 'MediaShareController@getSharedUsers',
			'middleware' => 'access:media.index'
        ]);
    });
    
});



	