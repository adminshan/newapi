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

//用户注册
Route::get('/reg','User\StartController@reg');
Route::post('/reg','User\StartController@doReg');

//用户登录
Route::get('/userlogin','User\StartController@login');
Route::post('/userlogin','User\StartController@doLogin');

Route::post('/apilogin','User\StartController@apiLogin');