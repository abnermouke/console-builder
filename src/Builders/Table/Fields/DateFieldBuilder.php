<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 日期表格构建器
 * Class DateFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class DateFieldBuilder extends BasicFieldBuilder
{

    /**
     * 构造函数
     * DateFieldBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示文本
     */
    public function __construct($field, $guard_name)
    {
        //设置默认信息
        $this->type('date')->field($field)->guard_name($guard_name)->format('Y-m-d H:i:s');
    }

    /**
     * 设置格式
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:24:20
     * @param string $format 格式
     * @return DateFieldBuilder
     */
    public function format($format = 'Y-m-d H:i:s')
    {
        //设置类型
        return $this->extra('format', $format ? $format : 'Y-m-d H:i:s');
    }

    /**
     * 设置为友好的时间显示类型
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:57:57
     * @return DateFieldBuilder
     */
    public function friendly()
    {
        //设置为友好的时间提示类型
        return $this->type('friendly_datetime');
    }



}
