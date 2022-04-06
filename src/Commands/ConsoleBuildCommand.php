<?php


namespace Abnermouke\ConsoleBuilder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * Console Builder to build
 * Class ConsoleBuildCommand
 * @package Abnermouke\ConsoleBuilder\Commands
 */
class ConsoleBuildCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'builder:console';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Console builder power by Abnermouke';

    /**
     * Console Builder to build
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-12 17:03:56
     * @return bool
     */
    public function handle()
    {
        //创建表
        if ($this->createTables()) {
            //打印信息
            $this->output->success('Console 构建器初始化完成！');
        }
        //返回成功
        return true;
    }

    /**
     * 创建表信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-31 23:42:33
     * @return bool
     * @throws \Exception
     */
    private function createTables()
    {
        //确认信息
        if (!$this->confirm('请确认是否已在.env中正确配置DB数据库链接信息？')) {
            //提示信息
            $this->output->warning('等待数据库配置完毕后继续...');
            //返回失败
            return false;
        }
        //打印命令
        $this->output->title('开始创建 Abnermouke/ConsoleBuilder 基础数据库表信息...');
        //整理生成内容
        $tables = [
            ['name' => 'admins',  '--desc' => '管理员表'],
            ['name' => 'roles',  '--desc' => '管理员角色表'],
            ['name' => 'nodes',  '--desc' => '管理员权限节点表'],
            ['name' => 'admin_logs',  '--desc' => '管理员操作记录表'],
            ['name' => 'configs',  '--desc' => '系统配置表'],
            ['name' => 'sms_logs',  '--desc' => '短信发送记录表'],
            ['name' => 'admin_oauth_signatures',  '--desc' => '管理员授权签名表'],
            ['name' => 'amap_areas',  '--desc' => '高德地图行政地区表'],
            ['name' => 'statistics',  '--desc' => '基础信息统计表'],
            ['name' => 'help_docs',  '--desc' => '帮助中心文档表'],
            ['name' => 'temporary_files',  '--desc' => '临时文件记录表'],
            ['name' => 'menus',  '--desc' => '菜单表'],
        ];
        //生成progress
        $bar = $this->output->createProgressBar(count($tables));
        //循环自动生成表
        foreach ($tables as $table_params) {
            //替换模版
            Artisan::call('builder:package', array_merge([
                '--dictionary' => 'abnermouke\console',
                '--dp' => 'acb_', '--dc' => 'mysql', '--dcs' => 'utf8mb4', '--de' => 'innodb',
                '--cd' => 'file',
                '--migration' => true, '--cache' => true, '--controller' => true, '--fcp' => true,
            ], $table_params));
            //递增进度条
            $bar->advance();
        }
        //设置结束进度条
        $bar->finish();
        //换行命令
        $this->output->newLine(2);
        //替换模版
        $this->createTemplate();
        //执行迁移
        Artisan::call('migrate:refresh', ['--path' => '/database/migrations/fillings']);
        //打印信息
        $this->output->success('数据库初始表创建成功');
        //清除缓存
        Artisan::call('cache:clear');
        //返回成功
        return true;
    }

    /**
     * 替换模版
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-31 23:15:36
     * @return bool
     * @throws \Exception
     */
    private function createTemplate()
    {
        //配置需要单独复制文件
        $copy_files = [
            ['from' => __DIR__.'/../../tpl/services/UploadService', 'to' => app_path('Services/Abnermouke/Console/UploadService.php')]
        ];
        //打印信息
        $this->output->title('开始创建 Abnermouke/ConsoleBuilder 基础模版信息...');
        //整理模版
        $templates = ['migrations' => [], 'models' => [], 'caches' => [], 'repositories' => [], 'services' => [], 'interfaces' => [], 'controllers' => []];
        //替换migrations模版
        foreach (File::allFiles(__DIR__.'/../../tpl/migrations') as $migration) {
            //记录信息
            $templates['migrations'][$migration->getFilename().'.php'] = file_get_contents($migration->getRealPath());
        }
        //替换interface模版
        foreach (File::allFiles(__DIR__.'/../../tpl/interfaces') as $interface) {
            //记录信息
            $templates['interfaces'][$interface->getFilename().'.php'] = file_get_contents($interface->getRealPath());
        }
        //替换interface模版
        foreach (File::allFiles(__DIR__.'/../../tpl/controllers') as $controller) {
            //记录信息
            $templates['controllers'][$controller->getFilename().'.php'] = file_get_contents($controller->getRealPath());
        }
        //替换models模版
        foreach (File::allFiles(__DIR__.'/../../tpl/models') as $model) {
            //记录信息
            $templates['models'][$model->getFilename().'.php'] = file_get_contents($model->getRealPath());
        }
        //替换cache模版
        foreach (File::allFiles(__DIR__.'/../../tpl/caches') as $cache) {
            //记录信息
            $templates['caches'][$cache->getFilename().'.php'] = file_get_contents($cache->getRealPath());
        }
        //替换services模版
        foreach (File::allFiles(__DIR__.'/../../tpl/services') as $service) {
            //记录信息
            $templates['services'][$service->getFilename().'.php'] = file_get_contents($service->getRealPath());
        }
//        //替换repositories模版
//        foreach (File::allFiles(__DIR__.'/../../tpl/repositories') as $repository) {
//            //记录信息
//            $templates['repositories'][$repository->getFilename().'.php'] = file_get_contents($repository->getRealPath());
//        }
        //循环本项目migrations
        foreach (File::allFiles($target_migration_path = database_path('migrations/abnermouke')) as $file) {
            //截取文件名
            $file_name = implode('_', array_slice(explode('_', $file->getFilename()), 4));
            //判断名称
            if (isset($templates['migrations'][$file_name])) {
                //替换内容
                file_put_contents($file->getRealPath(), $templates['migrations'][$file_name]);
            }
        }
        //打印信息
        $this->output->success('migration 模版创建成功');
        //循环本项目models
        foreach (File::allFiles($target_model_path = app_path('Model/Abnermouke/Console')) as $file) {
            //判断名称
            if (isset($templates['models'][($file_name = $file->getFilename())])) {
                //替换内容
                file_put_contents($file->getRealPath(), $templates['models'][$file_name]);
            }
        }
        //打印信息
        $this->output->success('model 模版创建成功');
        //循环本项目services
        foreach (File::allFiles($target_service_path = app_path('Services/Abnermouke/Console')) as $file) {
            //判断名称
            if (isset($templates['services'][($file_name = $file->getFilename())])) {
                //替换内容
                file_put_contents($file->getRealPath(), $templates['services'][$file_name]);
            }
        }
        //打印信息
        $this->output->success('service 模版创建成功！');
        //循环本项目caches
        foreach (File::allFiles($target_cache_path = app_path('Handler/Cache/Data/Abnermouke/Console')) as $file) {
            //判断名称
            if (isset($templates['caches'][($file_name = $file->getFilename())])) {
                //替换内容
                file_put_contents($file->getRealPath(),  $templates['caches'][$file_name]);
            }
        }
        //打印信息
        $this->output->success('cache 模版创建成功');
        //判断目录是否存在
        if (!File::exists($target_interface_path = app_path('Interfaces/Abnermouke/Console'))) {
            //创建目录
            File::makeDirectory($target_interface_path, 0777, true);
        }
        //复制接口逻辑
        File::copyDirectory(__DIR__.'/../../tpl/interfaces', $target_interface_path);
        //判断目录是否存在
        if (File::exists($target_controller_path = app_path('Http/Controllers/Abnermouke/Console'))) {
            //删除目录与全部文件
            File::deleteDirectory($target_controller_path);
        }
        //创建目录
        File::makeDirectory($target_controller_path, 0777, true);
        //复制控制器逻辑
        File::copyDirectory(__DIR__.'/../../tpl/controllers', $target_controller_path);
        //判断目录是否存在
        if (File::exists($target_builder_tools_path = app_path('Builders/Abnermouke/Console'))) {
            //删除目录与全部文件
            File::deleteDirectory($target_builder_tools_path);
        }
        //创建目录
        File::makeDirectory($target_builder_tools_path, 0777, true);
        //复制接口逻辑
        File::copyDirectory(__DIR__.'/../../tpl/builders', $target_builder_tools_path);
        //判断是否存在需要单独复制文件
        if ($copy_files) {
            //循环文件
            foreach ($copy_files as $file) {
                //复制文件
                File::copy($file['from'], $file['to']);
            }
        }
        //替换指定内容
        $this->replaceCurrentTemplate([$target_migration_path, $target_model_path, $target_service_path, $target_interface_path, $target_cache_path, $target_controller_path, $target_builder_tools_path]);
        //打印信息
        $this->output->success('console 控制台逻辑与静态文件复制成功');
        //返回成功
        return true;
    }

    /**
     * 替换模版通用参数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-16 14:32:04
     * @param array $dictionary_paths
     * @return bool
     * @throws \Exception
     */
    private function replaceCurrentTemplate($dictionary_paths = [])
    {
        //循环路径
        foreach ($dictionary_paths as $path) {
            //获取该目录下所有文件
            foreach (File::allFiles($path) as $file) {
                //替换内容
                file_put_contents($file->getRealPath(), str_replace(['__TIME__'], [auto_datetime()], file_get_contents($file->getRealPath())));
                //获取文件后缀
                if (!$file->getExtension() || $file->getExtension() !== 'php') {
                    //更改后缀
                    File::move($file->getRealPath(), $file->getRealPath().'.php');
                }
            }
        }
        //返回成功
        return true;
    }

}
