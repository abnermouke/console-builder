<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Filters;

/**
 * 文本框筛选构建器
 * Class InputFilterBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Filters
 */
class InputFilterBuilder extends BasicFilterBuilder
{

    /**
     * 文本框构建器
     * InputFilterBuilder constructor.
     */
    public function __construct()
    {
        //设置类型
        $this->type('input')->col(6)->placeholder('');
    }

    /**
     * 设置文本框placeholder
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:44:19
     * @param $text string 文字内容
     * @return InputFilterBuilder
     */
    public function placeholder($text)
    {
        //设置placeholder
        return $this->extra('placeholder', $text);
    }

    /**
     * 更改类型为数值筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:38:28
     * @param false $min 最低值（false为不限制）
     * @param false $max 最大值（false为不限制）
     * @return InputFilterBuilder
     */
    public function number($min = false, $max = false)
    {
        //更改类型
        return $this->type('number')->extra('min', $min)->extra('max', $max)->col(2);
    }

    /**
     * 更改类型为计步器
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:40:19
     * @param $min float|integer 最小值
     * @param $max float|integer 最大值
     * @param $step float|integer 步长单位
     * @param $decimals int 保留几位小数
     * @return InputFilterBuilder
     */
    public function dialer($min, $max, $step, $decimals)
    {
        //更改类型
        return $this->type('dialer')->extra('min', $min)->extra('max', $max)->extra('step', $step)->extra('decimals', $decimals)->col(2);
    }

    /**
     * 更改为标签类型筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:30:48
     * @return InputFilterBuilder
     */
    public function tags()
    {
        //更改类型
        return $this->type('tags')->col(6);
    }

    /**
     * 更改为日期筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:32:48
     * @param string $format 格式
     * @return InputFilterBuilder
     */
    public function date($format = 'Y-m-d')
    {
        //更改类型
        return $this->type('date')->extra('format', $format ? $format : 'Y-m-d')->col(4)->placeholder('点击选择时间');
    }

    /**
     * 更改为日期时间范围筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:35:03
     * @param string $format 格式
     * @return InputFilterBuilder
     */
    public function date_range($format = 'Y-m-d H:i:ss')
    {
        //更改类型
        return $this->type('date_range')->extra('format', $format ? $format : 'Y-m-d H:i:ss')->col(6)->placeholder('点击选择时间');
    }

}
