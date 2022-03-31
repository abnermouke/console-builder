<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 复选框构建器
 * Class CheckboxItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class CheckboxItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * CheckboxItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @throws \Exception
     */
    public function __construct($field, $guard_name)
    {
        //设置基础信息
        $this->guard_name($guard_name)->field($field)->options();
    }

    /**
     * 设置选项（单选项）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:20:45
     * @param array $options 选项内容 [key_1 => guard_name_1, key_2 => guard_name_2]
     * @param mixed $default_value 默认选中值
     * @return CheckboxItemBuilder
     * @throws \Exception
     */
    public function options($options = [], $default_value = 0)
    {
        //设置选择项
        return $this->setParam('type', 'checkbox')->extra('options', $options)->default_value(is_array($default_value) ? $default_value : explode(',', $default_value));
    }

    /**
     * 设置选项（带描述）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:27:31
     * @param array $options 选项内容 [key_1 => guard_name_1, key_2 => guard_name_2]
     * @param array $descriptions  描述内容 [key_1 => description_1, key_2 => description_2]
     * @param mixed $default_value 默认选中值
     * @return CheckboxItemBuilder
     * @throws \Exception
     */
    public function options_with_descriptions($options = [], $descriptions = [], $default_value = 0)
    {
        //设置选择项
        return $this->setParam('type', 'normal_checkbox')->extra('options', $options)->extra('descriptions', $descriptions)->default_value(is_array($default_value) ? $default_value : explode(',', $default_value));
    }

    /**
     * 设置选项（带描述、图片）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:27:51
     * @param array $options 选项内容 [key_1 => guard_name_1, key_2 => guard_name_2]
     * @param array $descriptions  描述内容 [key_1 => description_1, key_2 => description_2]
     * @param array $images 图片链接内容 [key_1 => link_1, key_2 => link_1] (link为空时将使用guard_name的首字母大写做为图片)
     * @param mixed $default_value 默认选中值
     * @return CheckboxItemBuilder
     * @throws \Exception
     */
    public function options_with_images($options = [], $descriptions = [], $images = [], $default_value = 0)
    {
        //设置选择项
        return $this->setParam('type', 'image_checkbox')->extra('options', $options)->extra('descriptions', $descriptions)->extra('images', $images)->default_value(is_array($default_value) ? $default_value : explode(',', $default_value));
    }



}
