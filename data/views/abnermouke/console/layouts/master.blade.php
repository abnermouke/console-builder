<!DOCTYPE html>
<!--
Author: Abnermouke <abnerouke@outlook.com>
Product Description: abnermouke/console-builder - ConsoleBuilder是一款完整的管理后台/控制面板构建工具包，一键安装即可搭建一套完整后台模版，内含一套完整表格、表单构建器，开发高效，体验优良！
Github: https://github.com/abnermouke/console-builder
Contact: abnermouke@outlook.com
-->
<html lang="{{ config('app.locale', 'zh') == 'zh-cn' ? 'zh' : config('app.locale', 'zh') }}">
    @php
        $console_configs = (new \App\Handler\Cache\Data\Abnermouke\Console\ConfigCacheHandler())->get();
    @endphp
    <head>
        <title>@yield('title', data_get($console_configs, 'APP_TITLE', 'Console控制台'))</title>
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
        <meta name="enable_aside" content="@yield('enable_aside', 0)">
        <meta name="mobile_device" content="{{ \Abnermouke\EasyBuilder\Library\Currency\DeviceLibrary::mobile() ? 1 : 0 }}">
        <link rel="shortcut icon" href="{{ $console_configs['APP_SHORTCUT_ICON'] }}" />
        <link rel="stylesheet" href="{{ proxy_assets('themes/km8/css/common.css', 'abnermouke') }}">
        @if($console_configs['CONSOLE_DEFAULT_THEME'] == 'dark')
            <link href="{{ proxy_assets('themes/km8/plugins/global/plugins.dark.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
            <link href="{{ proxy_assets('themes/km8/css/style.dark.bundle.css', 'abnermouke') }}" rel="stylesheet" type="text/css" />
        @elseif($console_configs['CONSOLE_DEFAULT_THEME'] == 'light')
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
        <script src="{{ proxy_assets('themes/km8/plugins/global/plugins.bundle.js', 'abnermouke') }}"></script>
        <script src="{{ proxy_assets('themes/km8/plugins/cryptojs/aes.js', 'abnermouke') }}"></script>
        <script src="{{ proxy_assets('themes/km8/plugins/cryptojs/pad-zeropadding-min.js', 'abnermouke') }}"></script>
        <script src="{{ proxy_assets('themes/km8/js/common.js', 'abnermouke') }}"></script>
        <script src="{{ proxy_assets('themes/km8/js/scripts.bundle.js', 'abnermouke') }}"></script>
        <script src="{{ proxy_assets('themes/km8/js/builder/flatpickr/langs/zh-cn.js', 'abnermouke') }}"></script>
        {{--自定义样式--}}
        @yield('styles')
    </head>
    <body id="acb_body" class="{{ $console_configs['CONSOLE_DEFAULT_THEME'] == 'auto' ? (((int)date('H') >= 19 || (int)date('H') <= 6) ? 'dark-mode' : '') : ($console_configs['CONSOLE_DEFAULT_THEME'] == 'dark' ? 'dark-mode' : '') }} header-extended header-fixed header-tablet-and-mobile-fixed">
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    {{--引入头部--}}
                    @include('abnermouke.console.layouts.headers.header')
                    {{--引入面包屑--}}
                    @include('abnermouke.console.layouts.toolbar')
                    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                        {{--PC设备访问--}}
                        @if(\Abnermouke\EasyBuilder\Library\Currency\DeviceLibrary::pc())
                            {{--引入侧边栏--}}
                            @include('abnermouke.console.layouts.aside')
                        @endif
                        <div class="content flex-row-fluid" id="kt_content">
                            {{--自定义主体内容--}}
                            @yield('container')
                        </div>
                    </div>
                    {{--引入底部--}}
                    @include('abnermouke.console.layouts.footer')
                </div>
            </div>
        </div>
        {{--引入滚动到顶部--}}
        @include('abnermouke.console.layouts.scroll')
        {{--自定义弹窗--}}
        @yield('popups')
        {{--手机设备访问--}}
        @if(\Abnermouke\EasyBuilder\Library\Currency\DeviceLibrary::mobile())
            {{--引入头部：手机版--}}
            @include('abnermouke.console.layouts.headers.mobile')
        @endif
    </body>
    {{--自定义javascript--}}
    @yield('script')
</html>
