<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 项目介绍表格构建器
 * Class ProjectFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class ProjectFieldBuilder extends BasicFieldBuilder
{

    /**
     * 构造函数
     * ProjectFieldBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示文本
     */
    public function __construct($field, $guard_name)
    {
        //设置默认信息
        $this->type('project')->field($field)->guard_name($guard_name)->thumb('THUMB');
    }

    /**
     * 设置封面图信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 03:09:11
     * @param $link string 图片访问地址 将自动替换链接中__ __包含字段，如__ID__将被当前项对应id字段内容替换
     * @param false $circle 是否显示为圆形
     * @param string $class 默认class内容
     * @return ProjectFieldBuilder
     */
    public function thumb($link, $circle = false, $class = 'symbol-50px')
    {
        //设置图片地址
        return $this->extra('thumb_link', $link)->extra('circle', $circle)->extra('thumb_class', $class);
    }

}
