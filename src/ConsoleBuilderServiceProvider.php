<?php


namespace Abnermouke\ConsoleBuilder;

use Abnermouke\ConsoleBuilder\Commands\ConsoleBuildCommand;
use Illuminate\Support\ServiceProvider;

class ConsoleBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //引入配置
        $this->app->singleton('command.builder.console', function () {
            //返回实例
            return new ConsoleBuildCommand();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/../config/console_builder.php' => config_path('console_builder.php'),
            __DIR__.'/../data/routes/abnermouke/console.php' => base_path('routes/abnermouke/console.php'),
            __DIR__.'/../data/assets' => public_path('abnermouke'),
            __DIR__.'/../helpers/console_builder.php' => app_path('Helpers/console_builder.php'),
            __DIR__.'/../data/views/abnermouke/console' => resource_path('views/abnermouke/console'),
            __DIR__.'/../data/views/vendor/abnermouke/console' => resource_path('views/vendor/abnermouke/console'),
            __DIR__.'/Middlewares/ConsoleBaseMiddleware.php' => app_path('Http/Middleware/Abnermouke/ConsoleBuilder/ConsoleBaseMiddleware.php'),
        ]);
        // 注册配置
        $this->commands('command.builder.console');
    }

}
