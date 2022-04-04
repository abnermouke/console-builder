<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 富文本编辑器表单构建器
 * Class EditorItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class EditorItemBuilder extends BasicItemBuilder
{

    //编辑器配置名称
    public const CK_EDITOR = 'ck_editor';
    public const UEDITOR = 'ueditor';

    /**
     * 构建函数
     * EditorItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @param string $editor 编辑器名称 ck_editor\ueditor
     * @throws \Exception
     */
    public function __construct($field, $guard_name, $editor = self::CK_EDITOR)
    {
        //设置基础信息
        $this->setParam('type', $editor)->guard_name($guard_name)->field($field)->row()->value_type(BasicItemBuilder::VALUE_TYPE_OF_STRING);
    }

    /**
     * 设置文本域默认行数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:43:38
     * @param int $row
     * @return EditorItemBuilder
     */
    public function row($row = 3)
    {
        //默认显示行数
        return $this->extra('row', (int)$row);
    }

}
