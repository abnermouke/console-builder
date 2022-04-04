# console-builder - 一款完整的管理后台/控制面板构建工具包

 Power By Abnermouke <abnermouke@outlook.com>

 此工具包由 Abnermouke <abnermouke@outlook.com> 开发并维护。

----

最后更新时间：2022年04月06日，持续更新中！！！

---


## Requirement - 环境要求

1. PHP >= 7.2（建议安装7.4）
2. **[Composer](https://getcomposer.org/)**
3. abnermouke/easy-builder
4. Laravel Framework 6+



## Installation - 安装方法

```shell
$ composer require "abnermouke/console-builder"
```

## Configuration - 配置

- 一切就绪之前，请先确保 "abnermouke/easy-builder" 配置已就位

点击 [abnermouke/easy-builder](https://github.com/abnermouke/easy-builder) 查看配置方法


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

Laravel 6 与 Laravel 7 中配置路由服务

```
  public function map()
    {
        
        // 其他路由配置

        $this->mapAbnermoukeConsoleRoutes();
    }

    /**
     * Define the "abnermouke/console" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAbnermoukeConsoleRoutes()
    {
        Route::middleware('abnermouke.console')
            ->namespace('App\Http\Controllers\Abnermouke\Console')
            ->group(base_path('routes/abnermouke/console.php'));
    }
```

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

- 添加辅助函数自动加载至 composer.json

```php
     "autoload": {
       
       // 
        
        "files": [
            
            //其他加载文件
            
            "app/Helpers/console_builder.php"
        ]
    },
```

- 执行 Composer Autoload 以生效辅助函数

```shell
composer dump-autoload
```


### Usage 使用方法

执行命令：
```shell
php artisan builder:console
```

- 构建表格方法

```php
    ($builder = (new \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder('__LIST_QUERY_URL__')))
        ->addButton($builder->buildBotton()->text('按钮名称')->url('跳转链接', '请求方式', true)->confirm_before_query('跳转前确认提示')->theme('primary')->id_suffix('自定义ID')->icon('自定义图标'))
        ->addButton($builder->buildBotton()->text('按钮名称')->ajax('Ajax跳转链接', '请求方式'))
        ->setCheckbox('选中时使用字段值', ['自定义的按钮ID'])
        ->setFields(function () use ($builder) {
            return ($fieldBuilder = new \Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableFieldsBuilder())
                ->addField($fieldBuilder->buildTexts('字段名', '显示名称')-> ···)      //双行文本字段
                ->addField($fieldBuilder->buildAvatar('字段名', '显示名称')-> ···)     //多头像显示字段
                ->addField($fieldBuilder->buildDate('字段名', '显示名称')-> ···)       //日期显示字段
                ->addField($fieldBuilder->buildOption('字段名', '显示名称')-> ···)     //选项显示字段
                ->addField($fieldBuilder->buildProject('字段名', '显示名称')-> ···)    //详细介绍显示字段
                ->addField($fieldBuilder->buildRating('字段名', '显示名称')-> ···)     //评分显示字段
                ->addField($fieldBuilder->buildString('字段名', '显示名称')-> ···)     //字符串显示字段
        })
        ->addFilter($builder->filterAsInput()-> ···)            //添加input筛选项
        ->addFilter($builder->filterAsGroup()-> ···)            //添加分组选择筛选项
        ->addFilter($builder->filterAsSelect()-> ···)           //添加选择框筛选想
        ->addFilter($builder->filterAsSwitch()-> ···)           //添加switch形式筛选想
        ->addAction($builder->buildAction()->ajax(route('xxx', ['id' => '__ID__']))-> ···)      //添加数据操作（系统将自动转换当前栏字段为id的值替换__ID__，可设置多个替换字段）
        ->render();     //实例化构建器内容（返回html）
```

- 构建表单方法

```php
    ($builder = (new \Abnermouke\ConsoleBuilder\Builders\Form\ConsoleFormBuilder()))
        ->setTitle('标题', '描述')
        ->submit($builder->buildButton()-> ···)     //添加提交按钮（必须存在）
        ->back($builder->buildButton()-> ···)       //添加返回按钮
        ->setItems(function () {
            return ($formItemBuilder = (new \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormItemsBuilder()))
            ->addItem($formItemBuilder->buildInput('字段名', '显示名称')-> ···)        //input文本框
            ->addItem($formItemBuilder->buildCheckbox('字段名', '显示名称')-> ···)     //checkbox多选
            ->addItem($formItemBuilder->buildEditor('字段名', '显示名称')-> ···)       //富文本编辑器，ueditor、ck_Editor
            ->addItem($formItemBuilder->buildFiles('字段名', '显示名称')-> ···)        //文件上传（可批量上传）
            ->addItem($formItemBuilder->buildImage('字段名', '显示名称')-> ···)        //单图上传
            ->addItem($formItemBuilder->buildLinkage('字段名', '显示名称', 'JSON文件地址')-> ···)      ///N级联动
            ->addItem($formItemBuilder->buildRadio('字段名', '显示名称')->trigger('选中值', ['选中时显示字段', '未选中时不会显示'])-> ···)        //单选框
            ->addItem($formItemBuilder->buildSelect('字段名', '显示名称')-> ···)       //选择框
            ->addItem($formItemBuilder->buildTags('字段名', '显示名称')-> ···)         //标签
            ->addItem($formItemBuilder->buildTextarea('字段名', '显示名称')-> ···)     //文本域
            ->addItem($formItemBuilder->buildValues('字段名', '显示名称')-> ···)       //自定义结构类型（常用于答题、商品属性等）
            ->addItem($formItemBuilder->buildSwitch('字段名', '显示名称')->on('开启时使用值', ['开启时显示字段', 'switch关闭时不会显示'])->off('关闭时使用值', ['关闭时显示字段', 'switch开启时不会显示'])-> ···);      //switch开关
        })
->addStructure($builder->buildStructure()->addFiled('字段名', '显示栏(1-12)')->addFiled(···)->···)        //每一个结构块中可添加多个字段并自定义显示宽度比例（基于bootstrap col）
->bindTable('构建表格ID', '动态modalID')      //表格构建器Action或Button为form类型时使用
->render();     //实例化构建器内容（返回html）
```


表单构建器可对switch、radio类型数据进行触发处理，详看 -> triiger()

- 系统提供多项自定义属性操作，-> 后可查看构建器提供的多个方法实例，花点时间了解，就能完全掌握他。

## License

MIT
