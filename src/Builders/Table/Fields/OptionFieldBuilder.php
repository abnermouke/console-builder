<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 选择类表格构建器
 * Class OptionFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class OptionFieldBuilder extends BasicFieldBuilder
{

    /**
     * 构造函数
     * OptionFieldBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示文本
     */
    public function __construct($field, $guard_name)
    {
        //设置默认信息
        $this->type('options')->field($field)->guard_name($guard_name)->options();
    }

    /**
     * 设置选择项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:08:29
     * @param array $options 选择项
     * @return OptionFieldBuilder
     */
    public function options($options = [])
    {
        //设置选择项
        return $this->extra('options', $options);
    }

}
