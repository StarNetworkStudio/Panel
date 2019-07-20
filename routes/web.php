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

Route::get('/', 'PagesController@root')->name('root');
Route::get('test', 'HomeController@index');
Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
});
//管理
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::view('/', 'admin.index');

    Route::any('/options', 'AdminController@options');

    Route::view('/users-v1', 'admin.users-v1');
    Route::view('/users-v2', 'admin.users-v2');

    Route::any('/user-list', 'AdminController@getUserList');
    Route::any('/user-lists', 'AdminController@getUserLists');
});
//用户
Route::group(['middleware' => 'auth', 'prefix' => 'user'], function () {
    Route::view('/', 'user.index');
});
