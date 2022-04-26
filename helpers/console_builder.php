<?php

if (!function_exists('decode_acbt_template')) {
    /**
     * 解析表格构建器显示模版信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 02:13:51
     * @param $template string 显示模版
     * @param $list array 列表信息
     * @param string $default 默认信息
     * @return string
     */
    function decode_acbt_template($template, $list, $default = '')
    {
        //判断数据信息
        if ($list && $template && preg_match_all('~\{(.*)\}~Uuis', $template, $matched) >= 1) {
            //判断匹配信息
            if ($matched[1] && !empty($matched[1])) {
                //循环字段信息
                foreach ($matched[1] as $field) {
                    //判断字段是否存在
                    if (isset($list[strtolower($field)])) {
                        //判断是否为数组
                        $list[strtolower($field)] = is_array($list[strtolower($field)]) ? implode(', ', $list[strtolower($field)]) : $list[strtolower($field)];
                        //设置链接数据
                        $template = str_replace('{' . $field . '}', $list[strtolower($field)], $template);
                    }
                }
            }
            //设置返回信息
            $default = $template;
        }
        //返回信息
        return trim($template) ? trim($template) : trim($default);
    }
}

if (!function_exists('abbr_acbt_template')) {
    /**
     * 获取模版大写首字母
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-01 15:06:52
     * @param $template
     * @param $list
     * @param $default
     * @return string
     * @throws Exception
     */
    function abbr_acbt_template($template, $list, $default)
    {
        //获取模版内容
        $template = decode_acbt_template($template, $list, $default);
        //获取首字母
        return abbr_acbt_string($template);
    }
}

if (!function_exists('acbt_conditions_result')) {
    /**
     * 表格构建器条件是否成立
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-25 11:26:35
     * @param $list
     * @param $conditions
     * @param string $condition_mode
     * @return bool
     */
    function acbt_conditions_result($list, $conditions, $condition_mode = '&&')
    {
        //判断条件信息
        if (!$conditions) {
            //直接成立
            return  true;
        }
        //初始化结果
        $result = true;
        //整理信息
        $success = $fail = [];
        //循环条件信息
        foreach ($conditions as $condition) {
            //根据类型处理
            switch ($condition['type']) {
                case \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder::VALUE_TYPE_OF_INTEGRAL:
                    //整理信息
                    $value = (int)data_get($list, $condition['field'], 0);
                    $condition['value'] = (int)$condition['value'];
                    break;
                case \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder::VALUE_TYPE_OF_FLOAT:
                    //整理信息
                    $value = data_get($list, $condition['field'], 0.00);
                    break;
                default:
                    //整理信息
                    $value = data_get($list, $condition['field'], '');
                    break;
            }
            //根据条件查询
            switch ($condition['operator']) {
                case '>':
                    //判断信息
                    if ($value > $condition['value']) {
                        //设置成功
                        $success[] = $condition['field'];
                    } else {
                        //设置失败
                        $fail[] = $condition['field'];
                    }
                    break;
                case '>=':
                    //判断信息
                    if ($value >= $condition['value']) {
                        //设置成功
                        $success[] = $condition['field'];
                    } else {
                        //设置失败
                        $fail[] = $condition['field'];
                    }
                    break;
                case '<':
                    //判断信息
                    if ($value < $condition['value']) {
                        //设置成功
                        $success[] = $condition['field'];
                    } else {
                        //设置失败
                        $fail[] = $condition['field'];
                    }
                    break;
                case '<=':
                    //判断信息
                    if ($value <= $condition['value']) {
                        //设置成功
                        $success[] = $condition['field'];
                    } else {
                        //设置失败
                        $fail[] = $condition['field'];
                    }
                    break;
                case 'in':
                    //判断信息
                    if (in_array($value, $condition['value'])) {
                        //设置成功
                        $success[] = $condition['field'];
                    } else {
                        //设置失败
                        $fail[] = $condition['field'];
                    }
                    break;
                case 'not-in':
                    //判断信息
                    if (!in_array($value, $condition['value'])) {
                        //设置成功
                        $success[] = $condition['field'];
                    } else {
                        //设置失败
                        $fail[] = $condition['field'];
                    }
                    break;
                default:
                    //判断信息
                    if ($value === $condition['value']) {
                        //设置成功
                        $success[] = $condition['field'];
                    } else {
                        //设置失败
                        $fail[] = $condition['field'];
                    }
                    break;
            }
        }
        //判断连接方式
        if ($condition_mode == '&&') {
            //判断是否存在失败
            if (!empty($fail)) {
                //设置失败
                $result = false;
            }
        } else {
            //设置失败
            $result = false;
            //判断是否存在成功
            if (!empty($success)) {
                //设置成功
                $result = true;
            }
        }
        //返回结果
        return $result;
    }
}

if (!function_exists('abbr_acbt_string')) {
    /**
     * 获取文本大写首字母
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-01 18:37:58
     * @param $string
     * @return string
     * @throws Exception
     */
    function abbr_acbt_string($string)
    {
        //获取第一位
        $first = mb_substr($string, 0, 1);
        //判断是否为中文
        if (\Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary::onlyZh($first)) {
            //转为英文
            $first = pinyin_abbr($first);
        }
        //返回大写首字母
        return strtoupper($first);
    }
}

if (!function_exists('get_acbt_link')) {
    /**
     * 获取构建器特质链接
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 02:21:25
     * @param $link string 链接地址
     * @param $list array 列表数据
     * @param $default_link string 链接格式有误时默认链接
     * @return mixed|string|string[]
     * @throws Exception
     */
    function get_acbt_link($link, $list, $default_link = 'javascript:;')
    {
        //判断链接
        if ($link && strstr($link, '__')) {
            //初始化链接信息
            $link = urldecode($link);
            //匹配信息
            if ($list && preg_match_all('~__(.*)__~Uuis', $link, $matched) >= 1) {
                //判断匹配信息
                if ($matched[1] && !empty($matched[1])) {
                    //循环字段信息
                    foreach ($matched[1] as $field) {
                        //设置链接数据
                        $link = str_replace('__'.$field.'__', data_get($list, strtolower($field), ''), $link);
                    }
                }
            }
            //初始化链接
            $link = trim($link);
        }
        //返回链接
        return $link ? $link : $default_link;
    }
}

if (!function_exists('acb_has_permission')) {
    /**
     * 验证是否有权限
     * @Author Abnermouke <abnermouke@gmail.com>
     * @Originate in Abnermouke's MBP
     * @Time 2021-04-28 14:30:49
     * @param $route_name
     * @param string $method
     * @return bool
     * @throws Exception
     */
    function acb_has_permission($route_name, $method = 'post')
    {
        //验证信息
        return (new \App\Handler\Cache\Data\Abnermouke\Console\RoleCacheHandler(current_auth('role_id', config('console_builder.session_prefix', 'abnermouke:console:auth'))))->hasPermission(strtolower($method), strtolower($route_name));
    }
}


if (!function_exists('abnermouke_console_abort_error'))
{
    /**
     * 渲染错误信息
     * @Author Abnermouke <abnermouke@gmail.com>
     * @Originate in Abnermouke's MBP
     * @Time 2021-04-28 15:33:24
     * @param $code
     * @param string $message
     * @param false $redirect_uri
     * @return \Illuminate\Http\Response
     */
    function abnermouke_console_abort_error($code, $message = '页面找不到了', $redirect_uri = false)
    {
        //配置消息信息
        $message = !empty($message) ? $message : '页面找不到了！';
        //渲染页面
        return response()->view('vendor.abnermouke.console.errors', compact('code', 'message', 'redirect_uri'));
    }
}
