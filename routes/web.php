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

Route::get('/', function () {
    return view('welcome');
});

//hs全部课程
Route::any('/cataloglist','Controller\CatalogController@cataloglist');
//家长登陆
Route::any('/studentlogin','Controller\StudentController@studentlogin');
//微信登陆
Route::any('/stucode','Controller\StudentController@stucode');
//账号密码登陆
Route::any('/stuloginpwd','Controller\StudentController@stuloginpwd');
//小问模块展示（家长端）
Route::any('/stuxw','Controller\StudentController@stuxw');