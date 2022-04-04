<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 头像表格构建器
 * Class AvatarFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class AvatarFieldBuilder extends BasicFieldBuilder
{

    /**
     * 构造函数
     * AvatarFieldBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示文本
     */
    public function __construct($field, $guard_name)
    {
        //设置默认信息
        $this->type('avatar')->field($field)->guard_name($guard_name)->empty('---');
    }

}
