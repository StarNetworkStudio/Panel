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
Route::view('test', 'index');
Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
});
//管理
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::get('users', 'AdminController@users');
    Route::get('players', 'AdminController@players');
    Route::get('options', 'AdminController@options');
    Route::get('test', 'AdminController@test');
    Route::any('/UserList', 'AdminController@getUserList');
});
//用户
Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index');
});
