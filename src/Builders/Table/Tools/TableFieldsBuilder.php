<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Tools;

use Abnermouke\ConsoleBuilder\Builders\Table\Fields\AvatarFieldBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Fields\DateFieldBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Fields\OptionFieldBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Fields\ProjectFieldBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Fields\RatingFieldBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Fields\StringFieldBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Fields\TextsFieldBuilder;

/**
 * 表格构建器字段构建处理器
 * Class TableFieldsBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Tools
 */
class TableFieldsBuilder
{
    /**
     * 字段信息
     * @var array
     */
    private $fields = [];

    /**
     * 获取字段信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:26:26
     * @return array
     */
    public function get()
    {
        //返回字段信息
        return $this->fields;
    }

    /**
     * 添加字段构建内容
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:02:24
     * @param $builder object 构建器实例
     * @return $this
     */
    public function addField($builder)
    {
        //设置字段信息
        $this->fields[] = $builder->get();
        //返回当前实例
        return $this;
    }

    /**
     * 构建头像相关字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:06:44
     * @param $field string 字段名
     * @param $guard_name string 提示文字
     * @return AvatarFieldBuilder
     */
    public function buildAvatar($field, $guard_name)
    {
        //返回构建对象
        return new AvatarFieldBuilder($field, $guard_name);
    }

    /**
     * 构建日期相关字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:06:44
     * @param $field string 字段名
     * @param $guard_name string 提示文字
     * @return DateFieldBuilder
     */
    public function buildDate($field, $guard_name)
    {
        //返回构建对象
        return new DateFieldBuilder($field, $guard_name);
    }

    /**
     * 构建选择项相关字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:06:44
     * @param $field string 字段名
     * @param $guard_name string 提示文字
     * @return OptionFieldBuilder
     */
    public function buildOption($field, $guard_name)
    {
        //返回构建对象
        return new OptionFieldBuilder($field, $guard_name);
    }

    /**
     * 构建项目介绍相关字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:06:44
     * @param $field string 字段名
     * @param $guard_name string 提示文字
     * @return ProjectFieldBuilder
     */
    public function buildProject($field, $guard_name)
    {
        //返回构建对象
        return new ProjectFieldBuilder($field, $guard_name);
    }

    /**
     * 构建评分相关字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:06:44
     * @param $field string 字段名
     * @param $guard_name string 提示文字
     * @return RatingFieldBuilder
     */
    public function buildRating($field, $guard_name)
    {
        //返回构建对象
        return new RatingFieldBuilder($field, $guard_name);
    }

    /**
     * 构建文本相关字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:06:44
     * @param $field string 字段名
     * @param $guard_name string 提示文字
     * @return StringFieldBuilder
     */
    public function buildString($field, $guard_name)
    {
        //返回构建对象
        return new StringFieldBuilder($field, $guard_name);
    }

    /**
     * 构建双文本相关字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:06:44
     * @param $field string 字段名
     * @param $guard_name string 提示文字
     * @return TextsFieldBuilder
     */
    public function buildTexts($field, $guard_name)
    {
        //返回构建对象
        return new TextsFieldBuilder($field, $guard_name);
    }

}
