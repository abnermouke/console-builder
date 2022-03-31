<?php

use Illuminate\Support\Facades\Route;

//设置前缀与路由
Route::group(['as' => 'abnermouke.console.', 'prefix' => 'abnermouke/console'], function () {

    //登录
    Route::group(['as' => 'oauth.', 'prefix' => 'oauth'], function () {

        //登录页面
        Route::get('', 'OauthController@index')->name('index');

        //普通登录
        Route::post('sign-in', 'OauthController@sign_in')->name('sign.in');

        //退出登录
        Route::get('sign-out', 'OauthController@sign_out')->name('sign.out');

        //微信授权
        Route::group(['as' => 'wechat.', 'prefix' => 'wechat'], function () {
            //获取授权链接
            Route::post('', 'OauthController@sign_in_with_wechat_qrcode')->name('sign.in');
            //管理员授权链接
            Route::get('{signature}', 'OauthController@wechat_qrcode')->name('signature')->where(['signature' => '[a-z0-9]{32}']);
            //管理员授权回调
            Route::get('callback/{signature}', 'OauthController@wechat_qrcode_callback')->name('signature.callback')->where(['signature' => '[a-z0-9]{32}']);
            //授权状态检测
            Route::post('check/{signature}', 'OauthController@wechat_qrcode_check')->name('signature.check')->where(['signature' => '[a-z0-9]{32}']);
        });

    });

    //需要登录路由
    Route::middleware('abnermouke.console.auth')->group(function () {

        //首页
        Route::get('', 'IndexController@index')->name('index');

        //列表请求
        Route::post('table', 'IndexController@table')->name('table');

        //删除
        Route::post('delete', 'IndexController@delete')->name('delete');



        //上传文件
        Route::post('uploader', 'UploadController@upload')->name('uploader');
        //ueditor上传
        Route::any('uploader/ueditor', 'UploadController@ueditor')->name('uploader.ueditor');

    });


});

