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

        //管理员相关路由
        Route::group(['as' => 'admins.', 'prefix' => 'admins'], function () {
            //管理员
            Route::get('', 'AdminController@index')->name('index');
            //获取管理员列表
            Route::post('lists', 'AdminController@lists')->name('lists');
            //管理员详情
            Route::post('{id}', 'AdminController@detail')->name('detail')->where('id', '\d+');
            //保存管理员信息
            Route::post('{id}/store', 'AdminController@store')->name('store')->where('id', '\d+');
            //操作管理员状态
            Route::post('status/{id}', 'AdminController@status')->name('status')->where('id', '\d+');
            //修改密码
            Route::post('change/password', 'AdminController@change_password')->name('change.password');
            //管理员日志相关路由
            Route::group(['as' => 'logs.', 'prefix' => 'logs'], function () {
                //管理员日志
                Route::get('', 'AdminLogController@index')->name('index');
                //获取管理员日志列表
                Route::post('lists', 'AdminLogController@lists')->name('lists');
            });
            //权限角色相关路由
            Route::group(['as' => 'roles.', 'prefix' => 'roles'], function () {
                //权限角色
                Route::get('', 'RoleController@index')->name('index');
                //获取权限角色列表
                Route::post('lists', 'RoleController@lists')->name('lists');
                //删除权限角色
                Route::post('delete', 'RoleController@delete')->name('delete');
                //权限角色详情
                Route::post('{id}', 'RoleController@detail')->name('detail')->where('id', '\d+');
                //保存权限角色信息
                Route::post('store/{id}', 'RoleController@store')->name('store')->where('id', '\d+');
                //权限节点相关路由
                Route::group(['as' => 'nodes.', 'prefix' => 'nodes'], function () {
                    //权限节点详情
                    Route::get('{id}', 'NodeController@index')->name('index')->where('id', '\d+');
                    //保存权限节点
                    Route::post('store/{id}', 'NodeController@store')->name('store')->where('id', '\d+');
                });
            });
        });

        //高德地图相关路由
        Route::group(['as' => 'amap.', 'prefix' => 'amap'], function () {
            //高德地图行政地区
            Route::get('', 'AmapAreaController@index')->name('index');
            //在线更新数据
            Route::post('sync', 'AmapAreaController@sync')->name('sync');
        });

        //菜单相关路由
        Route::group(['as' => 'menus.', 'prefix' => 'menus'], function () {
            //菜单配置
            Route::get('', 'MenuController@index')->name('index');
            //菜单详情
            Route::post('{parent_id}/{id}', 'MenuController@detail')->name('detail')->where('id', '\d+')->where('parent_id', '\d+');
            //保存菜单信息
            Route::post('store/{parent_id}/{id}', 'MenuController@store')->name('store')->where('id', '\d+')->where('parent_id', '\d+');
            //删除菜单
            Route::post('delete/{id}', 'MenuController@delete')->name('delete')->where('id', '\d+');
        });

        //帮助文档相关路由
        Route::group(['as' => 'help.docs.', 'prefix' => 'help/docs'], function () {
            //帮助文档
            Route::get('', 'HelpDocController@index')->name('index');
            //帮助文档列表
            Route::post('lists', 'HelpDocController@lists')->name('lists');
            //帮助文档详情
            Route::post('{id}', 'HelpDocController@detail')->name('detail')->where('id', '\d+');
            //保存帮助文档
            Route::post('store/{id}', 'HelpDocController@store')->name('store')->where('id', '\d+');
            //删除帮助文档
            Route::post('delete', 'HelpDocController@delete')->name('delete');
        });

        //短信记录相关路由
        Route::group(['as' => 'sms.', 'prefix' => 'sms'], function () {
            //短信记录
            Route::get('', 'SmsLogController@index')->name('index');
            //获取短信记录列表
            Route::post('lists', 'SmsLogController@lists')->name('lists');
            //配置短信参数
            Route::post('store', 'SmsLogController@store')->name('store');
        });

        //系统配置相关路由
        Route::group(['as' => 'configs.', 'prefix' => 'configs'], function () {
            //系统配置
            Route::get('', 'ConfigController@index')->name('index');
            //保存系统配置
            Route::post('store', 'ConfigController@store')->name('store');
        });

        //刷新节点
        Route::post('refresh/nodes', 'IndexController@refresh_nodes')->name('refresh.nodes');

        //上传文件
        Route::post('uploader', 'UploadController@upload')->name('uploader');
        //ueditor上传
        Route::any('uploader/ueditor', 'UploadController@ueditor')->name('uploader.ueditor');

    });


});

