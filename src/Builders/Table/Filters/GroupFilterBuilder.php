<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Filters;

/**
 * 分组筛选构建器
 * Class GroupFilterBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Filters
 */
class GroupFilterBuilder extends BasicFilterBuilder
{

    /**
     * 分组构建器
     * GroupFilterBuilder constructor.
     */
    public function __construct()
    {
        //设置类型
        $this->type('group')->col(6)->options()->default_value('__IGNORE__', false);
    }

    /**
     * 设置选择项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:48:52
     * @param $options array 选择项
     * @return GroupFilterBuilder
     */
    public function options($options = [])
    {
        //判断是否存在默认option
        if (!isset($options['__IGNORE__'])) {
            //添加默认
            $options = array_merge(['__IGNORE__' => '不设置'], $options);
        }
        //设置选项
        return $this->extra('options', $options);
    }

}
