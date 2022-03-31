<?php

namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

use Abnermouke\EasyBuilder\Module\BaseModel;

/**
 * 多项值表单构建器
 * Class ValuesItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class ValuesItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * ValuesItemBuilder constructor.
     * @param $filed
     * @param $guard_name
     * @throws \Exception
     */
    public function __construct($filed, $guard_name)
    {
        //设置基础参数
        $this->setParam('type', 'values')->field($filed)->guard_name($guard_name);
    }

    /**
     * 添加文本框
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:52:34
     * @param $key mixed value字段名
     * @param $guard_name string 显示文字
     * @param string $input_type 输入框类型
     * @param array $extras 额外参数
     * @return ValuesItemBuilder
     */
    public function addInput($key, $guard_name, $input_type = 'text', $extras = [])
    {
        //设置默认类型
        $type = 'input';
        //添加输入框项
        return $this->extra('columns', compact('key', 'guard_name', 'type', 'input_type', 'extras'), true);
    }

    /**
     * 添加选择框项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:50:54
     * @param $key mixed value字段名
     * @param $guard_name string 显示文字
     * @param array $options 选项内容 [key_1 => guard_name_1, key_2 => guard_name_2]
     * @param array $extras 额外参数
     * @return ValuesItemBuilder
     */
    public function addSelect($key, $guard_name, $options = [], $extras = [])
    {
        //设置默认类型
        $type = 'select';
        //添加选择框项
        return $this->extra('columns', compact('key', 'guard_name', 'type', 'options', 'extras'), true);
    }

    /**
     * 添加Switch开关
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-30 12:41:44
     * @param $key mixed value字段名
     * @param $guard_name string 显示文字
     * @param mixed $on_value 开启时值
     * @param mixed $off_value 关闭时值
     * @param array $extras 额外参数
     * @return ValuesItemBuilder
     */
    public function addSwitch($key, $guard_name, $on_value = BaseModel::SWITCH_ON, $off_value = BaseModel::SWITCH_OFF, $extras = [])
    {
        //设置类型
        $type = 'switch';
        //添加选择框项
        return $this->extra('columns', compact('key', 'guard_name', 'type', 'on_value', 'off_value', 'extras'), true);
    }


}
