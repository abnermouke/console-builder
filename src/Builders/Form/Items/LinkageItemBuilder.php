<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 联动表单项构建器
 * Class LinkageItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class LinkageItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * LinkageItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @param $json_file_url string 读取json链接
     * @throws \Exception
     */
    public function __construct($field, $guard_name, $json_file_url)
    {
        //设置基础信息
        $this->setParam('type', 'linkage')->guard_name($guard_name)->field($field)->extra('json_path', $json_file_url)->names()->level()->default_key_value()->placeholder('请选择'.$guard_name)->value_type(BasicItemBuilder::VALUE_TYPE_OF_OBJECT);
    }

    /**
     * 设置默认联动层级
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:25:45
     * @param int $level
     * @return LinkageItemBuilder
     */
    public function level($level = 2)
    {
        //设置联动层级
        return $this->extra('level', (int)$level)->extra('item_col', !in_array((int)$level, [2, 3, 4, 6]) ? 4 : 12/$level);
    }

    /**
     * 设置占位符信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:36:02
     * @param string $placeholder
     * @return LinkageItemBuilder
     */
    public function placeholder($placeholder = '')
    {
        //设置占位符信息
        return $this->extra('placeholder', $placeholder);
    }

    /**
     * 设置检索字段名集合
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:23:02
     * @param string $key_name key条件字段名
     * @param string $text_name 显示字段名
     * @param string $sub_name 下级字段名
     * @return LinkageItemBuilder
     */
    public function names($key_name = 'id', $text_name = 'guard_name', $sub_name = 'subs')
    {
        //设置字段名集合
        return $this->extra('names', compact('key_name', 'text_name', 'sub_name'));
    }

    /**
     * 设置默认无数据返回值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:27:05
     * @param mixed $default_key_value
     * @return LinkageItemBuilder
     */
    public function default_key_value($default_key_value = '')
    {
        //设置默认无数据返回值
        return $this->extra('default_key_value', $default_key_value);
    }
}
