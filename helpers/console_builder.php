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
