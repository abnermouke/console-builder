<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 双文本字段表格构建器
 * Class TextsFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class TextsFieldBuilder extends BasicFieldBuilder
{

    /**
     * 构造函数
     * TextsFieldBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示文本
     */
    public function __construct($field, $guard_name)
    {
        //设置默认信息
        $this->type('texts')->field($field)->guard_name($guard_name);
    }

}
