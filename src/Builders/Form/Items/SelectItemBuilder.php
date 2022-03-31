<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 选择框构建器
 * Class SelectItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class SelectItemBuilder extends BasicItemBuilder
{

    /**
     * 构造函数
     * SelectItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @throws \Exception
     */
    public function __construct($field, $guard_name)
    {
        //设置基础信息
        $this->setParam('type', 'select')->field($field)->guard_name($guard_name)->multiple()->options()->searchable(false)->placeholder('请选择'.$guard_name);;
    }

    /**
     * 设置是否多选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:58:56
     * @param false $multiple
     * @return SelectItemBuilder
     */
    public function multiple($multiple = false) {
        //设置是否多选
        return $this->extra('multiple', $multiple);
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
     * 设置选择项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:00:36
     * @param array $options 选项内容 [key_1 => guard_name_1, key_2 => guard_name_2]
     * @param int $default_value
     * @return SelectItemBuilder
     * @throws \Exception
     */
    public function options($options = [], $default_value = '__WITHOUT_SELECTED_OPTION__')
    {
        //判断长度
        if (count($options) >= 5) {
            //设置可搜索
            $this->searchable();
        }
        //设置选择项
        return $this->extra('options', $options)->default_value($default_value);
    }

    /**
     * 设置是否可搜索
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:01:37
     * @param false $searchable
     * @return SelectItemBuilder
     */
    public function searchable($searchable = true)
    {
        //设置是否可搜索
        return $this->extra('searchable', $searchable);
    }

}
