<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 文本框构建器
 * Class TextareaItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class TextareaItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * TextareaItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @throws \Exception
     */
    public function __construct($field, $guard_name)
    {
        //设置基础信息
        $this->setParam('type', 'textarea')->guard_name($guard_name)->field($field)->placeholder('请输入'.$guard_name)->row();
    }


    /**
     * 设置占位符信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:36:02
     * @param string $placeholder
     * @return TextareaItemBuilder
     */
    public function placeholder($placeholder = '')
    {
        //设置占位符信息
        return $this->extra('placeholder', $placeholder);
    }

    /**
     * 设置最长字数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:39:40
     * @param int $num 数值
     * @return TextareaItemBuilder
     */
    public function max_length($num = 200){
        //设置最长字数
        return $this->extra('max_length', (int)$num);
    }

    /**
     * 设置默认行数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:04:42
     * @param int $row
     * @return TextareaItemBuilder
     */
    public function row($row = 3)
    {
        //默认显示行数
        return $this->extra('row', (int)$row);
    }

    /**
     * 设置复制
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:41:33
     * @param bool $clip 是否设置
     * @return TextareaItemBuilder
     */
    public function clipboard($clip = true)
    {
        //设置粘贴触发按钮
        return $clip ? $this->extra('clipboard', $clip) :  $this;
    }

}
