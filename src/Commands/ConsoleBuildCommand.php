<?php


namespace Abnermouke\ConsoleBuilder\Commands;

use Illuminate\Console\Command;

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
        //打印信息
        $this->output->success('Console 构建器初始化完成！');
        //返回成功
        return true;
    }


}
