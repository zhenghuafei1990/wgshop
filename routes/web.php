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
//前台首页
Route::get('/','Home\IndexController@index');
//后台登录
Route::any('/admin/login','Admin\LoginController@login');                         
Route::any('/admin/dologin','Admin\LoginController@dologin');
Route::any('/admin/cap','Admin\LoginController@cap');
//后台管理
Route::group(['middleware'=>'adminlogin'],function(){
	//后台首页
	Route::any('/admin','Admin\IndexController@index');
	//后台的用户模块
	Route::resource('/admin/user','Admin\UserController');
	//后台的分类模块
	Route::resource('/admin/cate','Admin\CateController');
	//后台的商品模块
	Route::resource('/admin/goods','Admin\GoodsController');
});

//前台管理
Route::group([],function(){

});


