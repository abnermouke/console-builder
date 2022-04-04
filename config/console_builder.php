<?php

/**
 * Power by abnermouke/console-builder.
 * User: Abnermouke <abnermouke@outlook.com>
 * Originate in YunniTec.
 */

return [


    /*
   |--------------------------------------------------------------------------
   | Console builder default setting and Basic setting
   |--------------------------------------------------------------------------
   |
   | The default console builder settings
   |
   */

    //默认主题
    'default_theme' => 'km8',

    //Session前缀
    'session_prefix' => 'abnermouke:console:auth',

    //节点配置信息
    'nodes' => [
        //检索命名空间（可指定多个目录）
        'index_namespaces' => [
            //ConsoleBuilder 默认文件目录
            'App\Http\Controllers\Abnermouke\Console'
        ],
        //检索中间件标识或中间件Class地址（可指定多个中间件）
        'index_route_middleware' => ['abnermouke.console.auth'],
        //排除不检测路由（可指定多个路由）
        'ignore_route_names' => [],
        //默认必须存在的路由（可指定多个路由）
        'default_node_aliases' => ['get&abnermouke.console.index', 'post&abnermouke.console.admins.change.password', 'post&abnermouke.console.uploader', 'get&abnermouke.console.uploader.ueditor'],
        //控制器组名后缀（可指定多个），移除后缀后所剩内容为该控制器权限组名
        'controller_group_name_suffix' => '基础控制器',
    ],

    //菜单配置信息
    'menus' => [
        //菜单触发规则（click：点击展开；hover：滑过展开）
        'trigger' => "{default:'click', lg: 'hover'}",
        //子菜单显示未知（不建议更改）
        'placement' => 'bottom-start',
    ],

    //表格构建器配置信息
    'table' => [
        //默认列表单页获取条数
        'default_page_size' => 20,
        //默认列表开始页码
        'default_page' => 1,
    ],

    'ueditor_upload' => [
        /* 图片上传配置 */
        "imageActionName" => "uploadimage",
        "imageFieldName" => "upfile",
        "imageMaxSize" => 104857600,
        "imageAllowFiles" => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
        "imageCompressEnable" => true,
        "imageCompressBorder" => 620,
        "imageInsertAlign" => "none",
        "imageUrlPrefix" => "",
        "imagePathFormat" => "abnermouke/console/builder/ueditor/images",

        /* 上传视频配置 */
        "videoActionName" => "uploadmedia",
        "videoFieldName" => "upfile",
        "videoPathFormat" => "abnermouke/console/builder/ueditor/medias",
        "videoUrlPrefix" => "",
        "videoMaxSize" => 10737418240,
        "videoAllowFiles" => [
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid", ".mpga"
        ],

        /* 上传文件配置 */
        "fileActionName" => "uploadfile",
        "fileFieldName" => "upfile",
        "filePathFormat" => "abnermouke/console/builder/ueditor/files",
        "fileUrlPrefix" => "",
        "fileMaxSize" => 10737418240,
        "fileAllowFiles" => [
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml", ".mpga"
        ],
    ]

];
