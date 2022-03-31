<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

use Abnermouke\EasyBuilder\Module\BaseModel;

/**
 * Switch构建器
 * Class SwitchItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class SwitchItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * TagItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @throws \Exception
     */
    public function __construct($field, $guard_name)
    {
        //设置基础信息
        $this->setParam('type', 'switch')->guard_name($guard_name)->field($field)->description('是否允许开启'.$guard_name)->default_value(BaseModel::SWITCH_OFF)->allow_text()->on(BaseModel::SWITCH_ON)->off(BaseModel::SWITCH_OFF);
    }

    /**
     * 设置开关提示文案
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:10:56
     * @param string $text
     * @return SwitchItemBuilder
     */
    public function allow_text($text = '允许') {
        //设置switch开关提示文案
        return $this->extra('allow_text', $text);
    }

    /**
     * 设置开启时值与触发规则
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:16:49
     * @param $value mixed 对应值
     * @param array $trigger_show_fields 选中时显示字段
     * @return $this
     */
    public function on($value, $trigger_show_fields = [])
    {
        //设置开启时值
        return $this->extra('on', $value)->addTrigger($value, $trigger_show_fields);
    }

    /**
     * 设置关闭时值与触发规则
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:16:49
     * @param $value mixed 对应值
     * @param array $trigger_show_fields 选中时显示字段
     * @return $this
     */
    public function off($value, $trigger_show_fields = [])
    {
        //设置开启时值
        return $this->extra('off', $value)->addTrigger($value, $trigger_show_fields);
    }

}
