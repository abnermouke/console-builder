<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 评分表格构建器
 * Class RatingFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class RatingFieldBuilder extends BasicFieldBuilder
{

    /**
     * 构造函数
     * RatingFieldBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示文本
     */
    public function __construct($field, $guard_name)
    {
        //设置默认信息
        $this->type('rating')->field($field)->guard_name($guard_name)->empty(0);
    }

}
