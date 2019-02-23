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

Auth::routes();

//\Auth::login(\App\User::find(1));

Route::get('/home', 'HomeController@index')->name('home');


Route::get('wechat/redirect','WechatController@redirect')->name('wechat.redirect');
Route::get('wechat/callback','WechatController@callback')->name('wechat.callback');

Route::group(['middleware'=>'auth'],function(){

    Route::group(['as'=>'api.home.','prefix'=>'api/home'],function(){
        Route::post('wechat/confirm_login','Home\WechatController@confirm_login')->name('wechat.confirm_login');//确认登录
        Route::post('wechat/cancel_login','Home\WechatController@cancel_login')->name('wechat.cancel_login');//取消登陆
        Route::post('wechat/login/{code}/state','Home\WechatController@login_code_state')->name('wechat.login_code_state');//已扫描状态
    });
});

Route::get('wechat/web/login','Home\WechatController@wechat_web_login')->name('wechat.web.login');//登录二维码页面
Route::post('api/home/wechat/login/api_web_login','Home\WechatController@api_web_login')->name('api.home.wechat.api.web_login');//轮训请求api
Route::get('web/login','Home\WechatController@web_login')->name('web.login');//轮训成功后指向该页面登录

Route::group(['middleware'=>'auth'],function(){
    Route::any('/{all?}','FrontController@home')->where(['all'=>'.*']);
});

