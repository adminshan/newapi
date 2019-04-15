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

//测试-用户注册
Route::get('/ceshi/reg','User\CeshiController@reg');
Route::post('/ceshi/reg','User\CeshiController@doReg');
//测试-用户登录
Route::get('/ceshi/login','User\CeshiController@login');
Route::post('/ceshi/login','User\CeshiController@doLogin');

Route::post('/user/reg','User\CeshiController@user_reg');
Route::post('/user/login','User\CeshiController@user_login');
Route::post('/showlist','User\CeshiController@showlist');
Route::post('/show/banben','User\CeshiController@banben');







//加密
Route::get('/enopenssl','Openssl\OpensslController@encode');
//切片上传
Route::get('/uploadshow','Img\ImgController@show');
Route::post('/upload','Img\ImgController@upload');


Route::get('/aaa','Login\LoginController@qqq');

//app登录
//Route::post('user/login','Login\LoginController@login');
//app退出
Route::post('/quit','Login\LoginController@quit');
//修改密码
Route::post('/checkpwd','Center\CenterController@changepwd');
//收藏删除
Route::post('/delcollect','Center\CenterController@delcollection');













