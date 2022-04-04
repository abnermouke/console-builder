<?php

namespace App\Http\Middleware\Abnermouke\ConsoleBuilder;

use Abnermouke\EasyBuilder\Library\CodeLibrary;
use App\Builders\Abnermouke\Console\ConsoleBuilderNodeTool;
use App\Handler\Cache\Data\Abnermouke\Console\NodeCacheHandler;
use App\Handler\Cache\Data\Abnermouke\Console\RoleCacheHandler;
use Closure;
use Illuminate\Http\Request;

class ConsoleBaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        //判断是否存在节点
        if (!(new NodeCacheHandler())->get()) {
            //刷新节点
            ConsoleBuilderNodeTool::run();
        }
        //判断是否登录
        if (!current_auth(false, config('console_builder.session_prefix', 'abnermouke:console:auth'))) {
            //判断当前请求方式
            if ($request->isMethod('post')) {
                //返回错误
                return responseError(CodeLibrary::PERMISSION_EXPIRED, [], '请重新登录后再试');
            } else {
                //跳转登录
                return redirect(route('abnermouke.console.oauth.sign.out', ['redirect_uri' => $request->fullUrl()]));
            }
        }
        //判断是否有权限
        if (!(new RoleCacheHandler(current_auth('role_id', config('console_builder.session_prefix', 'abnermouke:console:auth'))))->checkPermission($request)) {
            //判断请求方式
            if ($request->isMethod('post')) {
                //返回错误
                return responseError(CodeLibrary::MISSING_PERMISSION, [], 'Sorry，权限不足！');
            } else {
                //跳转登录
                return abnermouke_console_abort_error(CodeLibrary::MISSING_PERMISSION, 'Sorry，权限不足！', route('abnermouke.console.index'));
            }
        }
        //继续访问
        return $next($request);
    }
}
