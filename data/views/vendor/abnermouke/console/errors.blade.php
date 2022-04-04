<!DOCTYPE html>
<!--
Author: Abnermouke <abnerouke@outlook.com>
Product Description: abnermouke/console-builder - ConsoleBuilder是一款完整的管理后台/控制面板构建工具包，一键安装即可搭建一套完整后台模版，内含一套完整表格、表单构建器，开发高效，体验优良！
Github: https://github.com/abnermouke/console-builder
Contact: abnermouke@outlook.com
-->
<html lang="{{ config('app.locale', 'zh') == 'zh-cn' ? 'zh' : config('app.locale', 'zh') }}">
<head>
    @php
        $console_configs = (new \App\Handler\Cache\Data\Abnermouke\Console\ConfigCacheHandler())->get();
    @endphp
    <title>{{ $message }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="{!! data_get($console_configs, 'APP_DESCRIPTION', 'ConsoleBuilder是一款完整的管理后台/控制面板构建工具包，一键安装即可搭建一套完整后台模版，内含一套完整表格、表单构建器，开发高效，体验优良！') !!}" />
    <meta name="keywords" content="{!! implode(', ', object_2_array(data_get($console_configs, 'APP_KEYWORDS', ['abnermouke@outlook.com', 'abnermouke/console-builder', '控制台', '构建器']))) !!}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="{{ proxy_assets('') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="website-url" content="{{ config('app.url') }}">
    <meta name="default-theme" content="{{ $console_configs['CONSOLE_DEFAULT_THEME'] }}">
    <meta name="aes-iv" content="{{ config('project.aes.iv') }}">
    <meta name="aes-encrypt-key" content="{{ auto_datetime('Ymd').config('project.aes.encrypt_key_suffix') }}">
    <meta name="current_client_ip" content="{{ request()->getClientIp() }}">
    <meta name="current_route_name" content="{{ request()->route()->getName() }}">
    <meta name="mobile_device" content="{{ \Abnermouke\EasyBuilder\Library\Currency\DeviceLibrary::mobile() ? 1 : 0 }}">
    <link rel="shortcut icon" href="{{ $console_configs['APP_SHORTCUT_ICON'] }}" />
    <link rel="stylesheet" href="{{ proxy_assets('themes/km8/css/common.css', 'abnermouke') }}">
    @if($console_configs['CONSOLE_DEFAULT_THEME'] === 'dark')
        <link href="{{ proxy_assets('themes/km8/plugins/global/plugins.dark.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
        <link href="{{ proxy_assets('themes/km8/css/style.dark.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
    @elseif($console_configs['CONSOLE_DEFAULT_THEME'] === 'light')
        <link href="{{ proxy_assets('themes/km8/plugins/global/plugins.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
        <link href="{{ proxy_assets('themes/km8/css/style.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
    @else
        @if((int)date('H') >= 19 || (int)date('H') <= 6)
            <link href="{{ proxy_assets('themes/km8/plugins/global/plugins.dark.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
            <link href="{{ proxy_assets('themes/km8/css/style.dark.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
        @else
            <link href="{{ proxy_assets('themes/km8/plugins/global/plugins.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
            <link href="{{ proxy_assets('themes/km8/css/style.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
        @endif
    @endif
</head>
<body id="kt_body" class="auth-bg">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-center flex-column-fluid p-10">
            <img src="{{ proxy_assets('themes/km8/media/illustrations/sketchy-1/18.png', 'abnermouke') }}" alt="" class="mw-100 mb-10 h-lg-350px" />
            <h1 class="fw-bold mb-10" style="color: #A3A3C7">{{ '[ '.$code.' ] '.$message }}</h1>
            <a href="{{ $redirect_uri }}" class="btn btn-primary">立即返回</a>
        </div>
    </div>
</body>
</html>
