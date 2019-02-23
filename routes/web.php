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

Route::get('/home', 'HomeController@index')->name('home');


Route::get('wechat/redirect','WechatController@redirect')->name('wechat.redirect');
Route::get('wechat/callback','WechatController@callback')->name('wechat.callback');

Route::group(['namespace'=>'\Home'],function(){


    Route::group(['as'=>'api.home.','prefix'=>'api/home'],function(){
        Route::post('wechat/confirm_login','WechatController@confirm_login')->name('wechat.confirm_login');
        Route::post('wechat/cancel_login','WechatController@cancel_login')->name('wechat.cancel_login');
        Route::post('wechat/login/{code}/state','WechatController@login_state')->name('wechat.login_code_state');
    });
});

Route::get('wechat/web/login','Home\WechatController@wechat_web_login')->name('wechat.web.login');//登录二维码页面
Route::post('api/home/wechat/login/api_web_login','Home\WechatController@api_web_login')->name('api.home.wechat.api.web_login');//轮训请求api
Route::get('web/login','Home\WechatController@web_login')->name('web.login');//轮训成功后指向该页面登录

Route::group([],function(){
    Route::any('/{all?}','FrontController@home')->where(['all'=>'.*']);
});

