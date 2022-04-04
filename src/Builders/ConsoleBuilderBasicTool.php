<?php

namespace Abnermouke\ConsoleBuilder\Builders;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * 控制台构建器基础工具
 * Class ConsoleBuilderBasicTool
 * @package Abnermouke\ConsoleBuilder\Builders
 */
class ConsoleBuilderBasicTool
{

    /**
     * 初始化请求参数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-16 14:53:30
     * @param $params
     * @return mixed
     */
    public static function initRequestParams($params) {
        //判断信息
        if ($params) {
            //循环参数信息
            foreach ($params as $k => $param) {
                //判断信息
                if (is_array($param)) {
                    //整理信息
                    $param = !empty($param) ? Arr::query($param) : '[]';
                }
                //判断信息
                $param = Str::length($param) > 200 ? ('__LONG_TEXT__:'.Str::length($param)) : $param;
                //设置参数信息
                $params[$k] = $param;
            }
        }
        //返回参数信息
        return $params;
    }

}
