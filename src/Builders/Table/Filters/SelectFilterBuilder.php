<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Filters;

/**
 * 选择框筛选构建器
 * Class SelectFilterBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Filters
 */
class SelectFilterBuilder extends BasicFilterBuilder
{

    /**
     * 选择框构建器
     * SelectFilterBuilder constructor.
     */
    public function __construct()
    {
        //设置类型
        $this->type('select')->col(2)->options()->default_value('__WITHOUT_ANY_VALUE__', false);
    }

    /**
     * 设置选择项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:48:52
     * @param $options array 选择项
     * @return SelectFilterBuilder
     */
    public function options($options = [])
    {
        //判断是否存在默认参数
        if (!isset($options['__WITHOUT_ANY_VALUE__'])) {
            //添加默认
            $options['__WITHOUT_ANY_VALUE__'] = '请选择';
        }
        //设置选项
        return $this->extra('options', $options);
    }

}
