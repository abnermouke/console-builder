# console-builder - 一款完整的管理后台/控制面板构建工具包

 Power By Abnermouke <abnermouke@outlook.com>

 此工具包由 Abnermouke <abnermouke@outlook.com> 开发并维护。

----

最后更新时间：2022年03月31日，持续更新中！！！

---


## Requirement - 环境要求

1. PHP >= 7.2（建议安装7.4）
2. **[Composer](https://getcomposer.org/)**
3. abnermouke/easy-builder



## Installation - 安装方法

```shell
$ composer require "abnermouke/console-builder"
```

## Configuration - 配置

- 在`config/app.php`的`providers`注册服务提供者

```php
Abnermouke\ConsoleBuilder\ConsoleBuilderServiceProvider::class
```
- 如果你想只在非`production`的模式中使用构建器功能，可在`AppServiceProvider`中进行`register()`配置

```php
public function register()
{
  if ($this->app->environment() !== 'production') {
      $this->app->register(\Abnermouke\ConsoleBuilder\ConsoleBuilderServiceProvider::class);
  }
  // ...
}
```

-  构建工具提供一配置文件帮助开发者自行配置自己的构建配置，导出命令：

```shell
php artisan vendor:publish --provider="Abnermouke\ConsoleBuilder\ConsoleBuilderServiceProvider"
```


- 设置路由 
```php
protected $middlewareGroups = [

       // 其他路由配置

        'abnermouke.console' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'abnermouke.console.auth' => [
            \App\Http\Middleware\Abnermouke\ConsoleBuilder\ConsoleBaseMiddleware::class
        ],
    ];

```
- 注册路由
- 移除 app/Http/Kernel.php 默认中间件：\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

Laravel 8 中配置路由服务 app/Providers/RouteServiceProvider.php

```
public function boot()
{
    $this->configureRateLimiting();
    
    $this->routes(function () {
    
         // 其他路由服务注册

        Route::middleware('abnermouke.console')
            ->namespace('App\Http\Controllers\Abnermouke\Console')
            ->group(base_path('routes/abnermouke/console.php'));
    });
}
```

增加Csrf例外 app/Http/Middleware/VerifyCsrfToken.php （处理ueditor或其他插件文件上传无法加入csrf验证）

```
    protected $except = [
        
        //其他例外
    
        'abnermouke/console/uploader/*'
    ];
```

### Usage 使用方法

执行命令：
```shell
php artisan builder:console
```
等待处理结束接口

## License

MIT
