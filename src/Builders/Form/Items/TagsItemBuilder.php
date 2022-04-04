<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 标签输入框构建器
 * Class TagItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class TagsItemBuilder extends BasicItemBuilder
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
        $this->setParam('type', 'tags')->guard_name($guard_name)->field($field)->placeholder('输入（标签/关键词）后回车确认以生成（标签/关键词）信息')->description('输入（标签/关键词）后回车确认以生成（标签/关键词）信息')->tip('标签/关键词将进行自动过滤，如存在违禁词将在提交后自动删除')->whitelist()->value_type(BasicItemBuilder::VALUE_TYPE_OF_OBJECT);
    }

    /**
     * 设置占位符信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:36:02
     * @param string $placeholder
     * @return TagsItemBuilder
     */
    public function placeholder($placeholder = '')
    {
        //设置占位符信息
        return $this->extra('placeholder', $placeholder);
    }

    /**
     * 设置白名单
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-03 03:06:10
     * @param array $lists
     * @return TagsItemBuilder
     */
    public function whitelist($lists = [])
    {
        //设置白名单
        return $this->extra('whitelist', $lists);
    }

}
