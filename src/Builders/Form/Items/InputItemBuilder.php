<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 输入框构建器
 * Class InputItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class InputItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * InputItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @param string $input_type 输入框type（text、number、date、color、hidden、url、email、password等）
     * @throws \Exception
     */
    public function __construct($field, $guard_name, $input_type = 'text')
    {
        //设置基础信息
        $this->setParam('type', 'input')->extra('input_type', $input_type)->extra('input_mode', 'text')->guard_name($guard_name)->field($field)->placeholder('请输入'.$guard_name)->value_type(BasicItemBuilder::VALUE_TYPE_OF_STRING);
        //判断是否为链接
        switch ($input_type) {
            case 'url':
                //默认设置按钮
                $this->append('前往链接', 'la la-link')->clipboard();
                break;
            case 'hidden':
                //设置隐藏
                $this->hidden();
                break;
            case 'number':
                //设置最长字数
                $this->max_length(10)->value_type(BasicItemBuilder::VALUE_TYPE_OF_INTEGRAL);
                break;
            case 'date':
                //设置默认格式
                $this->date_format()->prepend('', 'la la-calendar-alt')->extra('input_type', 'text');
                break;
        }
    }

    /**
     * 设置日期格式
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:48:33
     * @param string $format 日期格式
     * @param bool $range 是否范围获取
     * @return InputItemBuilder
     */
    public function date_format($format = 'Y-m-d', $range = false) {
        //设置日期输入框（包含range）时默认时间格式
        return $this->extra('format', $format)->extra('range', $range)->extra('input_mode', 'datetime');
    }

    /**
     * 设置金额格式
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-22 13:18:06
     * @param int $decimal
     * @param int $ratio
     * @param string $prefix
     * @param string $suffix
     * @return InputItemBuilder
     */
    public function price($decimal = 2, $ratio = 0, $prefix = '¥', $suffix = '元')
    {
        //更改类型
        return $this->extra('input_type', 'number')->min(0)->extra('decimal', (int)$decimal)->extra('ratio', (int)$ratio)->append($suffix)->prepend($prefix)->value_type(BasicItemBuilder::VALUE_TYPE_OF_FLOAT);
    }

    /**
     * 设置占位符信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:36:02
     * @param string $placeholder
     * @return InputItemBuilder
     */
    public function placeholder($placeholder = '')
    {
        //设置占位符信息
        return $this->extra('placeholder', $placeholder);
    }

    /**
     * 设置前置信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:37:47
     * @param $content string 显示/提示信息（icon不为空做为tooltip提示）
     * @param string $icon 图标
     * @return InputItemBuilder
     */
    public function prepend($content, $icon = '')
    {
        //设置前置信息
        return $this->extra('prepend', compact('content', 'icon'), true);
    }


    /**
     * 设置后置信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:37:47
     * @param $content string 显示/提示信息（icon不为空做为tooltip提示）
     * @param string $icon 图标
     * @return InputItemBuilder
     */
    public function append($content, $icon = '')
    {
        //设置前置信息
        return $this->extra('append', compact('content', 'icon'), true);
    }

    /**
     * 设置最长字数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:39:40
     * @param int $num 数值
     * @return InputItemBuilder
     */
    public function max_length($num = 200){
        //设置最长字数
        return $this->extra('max_length', (int)$num);
    }

    /**
     * 设置数值最小值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:39:40
     * @param int $num 数值
     * @return InputItemBuilder
     */
    public function min($num = 0){
        //设置数值最小值
        return $this->extra('min', (int)$num);
    }


    /**
     * 设置数值最大值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:39:40
     * @param int $num 数值
     * @return InputItemBuilder
     */
    public function max($num = 0){
        //设置数值最大值
        return $this->extra('max', (int)$num);
    }

    /**
     * 设置复制
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:41:33
     * @param bool $clip 是否设置
     * @return InputItemBuilder
     */
    public function clipboard($clip = true)
    {
        //设置粘贴触发按钮
        return $clip ? $this->extra('clipboard', $clip)->append('复制内容', 'la la-copy') :  $this;
    }

}
