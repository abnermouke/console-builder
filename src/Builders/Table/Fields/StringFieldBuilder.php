<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 字符串表格构建器
 * Class StringFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class StringFieldBuilder extends BasicFieldBuilder
{

    /**
     * 构造函数
     * StringFieldBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示文本
     */
    public function __construct($field, $guard_name)
    {
        //设置默认信息
        $this->type('string')->field($field)->guard_name($guard_name);
    }

    /**
     * 设置为数字类型
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:47:58
     * @return StringFieldBuilder
     */
    public function number()
    {
        //更改类型
        return $this->type('number');
    }

    /**
     * 设置为金额类型
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:50:34
     * @param int $decimal 显示几位小数点
     * @param int $ratio 倍率系数（默认无系数，如金额默认*100，$ratio则需配置为100，系统将自动换算后显示）
     * @param string $prefix 单位前缀
     * @param string $suffix 单位后缀
     * @return StringFieldBuilder
     */
    public function price($decimal = 2, $ratio = 0, $prefix = '¥', $suffix = '元')
    {
        //更改类型
        return $this->type('price')->extra('decimal', (int)$decimal)->extra('ratio', (int)$ratio)->extra('prefix', $prefix)->extra('suffix', $suffix);
    }

    /**
     * 文本前置图片
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:53:56
     * @param $url string 图片访问地址 将自动替换链接中__ __包含字段，如__ID__将被当前项对应id字段内容替换
     * @param string $class 默认样式内容
     * @return StringFieldBuilder
     */
    public function pre_image($url, $class = 'w-20px')
    {
        //添加前置图片
        return $this->extra('pre_image', $url)->extra('image_class', $class);
    }

}
