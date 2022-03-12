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
        ]);
        // 注册配置
        $this->commands('command.builder.console');
    }

}
