<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Tools;

use Abnermouke\ConsoleBuilder\Builders\Form\Items\CheckboxItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\EditorItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\FilesItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\IconItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\ImageItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\InputItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\LinkageItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\RadioItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\SelectItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\SwitchItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\TagsItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\TextareaItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Items\ValuesItemBuilder;

/**
 * 表单字段构建器
 * Class FormFieldsBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Tools
 */
class FormItemsBuilder
{
    /**
     * 表单项
     * @var array
     */
    private $items = [];

    /**
     * 获取表单项信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 12:26:26
     * @return array
     */
    public function get()
    {
        //返回表单项信息
        return $this->items;
    }

    /**
     * 添加表单项构建内容
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:02:24
     * @param $builder object 构建器实例
     * @return $this
     */
    public function addItem($builder)
    {
        //设置表单项信息
        $this->items[] = $builder->get();
        //返回当前实例
        return $this;
    }


    /**
     * 生成输入框构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @param string $input_type
     * @return InputItemBuilder
     * @throws \Exception
     */
    public function buildInput($field, $guard_name, $input_type = 'text')
    {
        //返回实例对象
        return new InputItemBuilder($field, $guard_name, $input_type);
    }

    /**
     * 生成复选框构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return CheckboxItemBuilder
     * @throws \Exception
     */
    public function buildCheckbox($field, $guard_name)
    {
        //返回实例对象
        return new CheckboxItemBuilder($field, $guard_name);
    }

    /**
     * 生成富文本构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @param $editor
     * @return EditorItemBuilder
     * @throws \Exception
     */
    public function buildEditor($field, $guard_name, $editor = EditorItemBuilder::UEDITOR)
    {
        //返回实例对象
        return new EditorItemBuilder($field, $guard_name, $editor);
    }

    /**
     * 生成多文件上传构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return FilesItemBuilder
     * @throws \Exception
     */
    public function buildFiles($field, $guard_name)
    {
        //返回实例对象
        return new FilesItemBuilder($field, $guard_name);
    }

    /**
     * 生成单图片上传构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return ImageItemBuilder
     * @throws \Exception
     */
    public function buildImage($field, $guard_name)
    {
        //返回实例对象
        return new ImageItemBuilder($field, $guard_name);
    }

    /**
     * 生成多级联动构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:57:35
     * @param $field
     * @param $guard_name
     * @param $json_file_url string json文件地址
     * @return LinkageItemBuilder
     * @throws \Exception
     */
    public function buildLinkage($field, $guard_name, $json_file_url)
    {
        //返回实例对象
        return new LinkageItemBuilder($field, $guard_name, $json_file_url);
    }

    /**
     * 生成单选框构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return RadioItemBuilder
     * @throws \Exception
     */
    public function buildRadio($field, $guard_name)
    {
        //返回实例对象
        return new RadioItemBuilder($field, $guard_name);
    }

    /**
     * 生成选择框构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return SelectItemBuilder
     * @throws \Exception
     */
    public function buildSelect($field, $guard_name)
    {
        //返回实例对象
        return new SelectItemBuilder($field, $guard_name);
    }

    /**
     * 生成Icon图标选择构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return IconItemBuilder
     * @throws \Exception
     */
    public function buildIcon($field, $guard_name)
    {
        //返回实例对象
        return new IconItemBuilder($field, $guard_name);
    }

    /**
     * 生成Switch构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return SwitchItemBuilder
     * @throws \Exception
     */
    public function buildSwitch($field, $guard_name)
    {
        //返回实例对象
        return new SwitchItemBuilder($field, $guard_name);
    }

    /**
     * 生成标签构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return TagsItemBuilder
     * @throws \Exception
     */
    public function buildTags($field, $guard_name)
    {
        //返回实例对象
        return new TagsItemBuilder($field, $guard_name);
    }

    /**
     * 生成文本框构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return TextareaItemBuilder
     * @throws \Exception
     */
    public function buildTextarea($field, $guard_name)
    {
        //返回实例对象
        return new TextareaItemBuilder($field, $guard_name);
    }

    /**
     * 生成多项值构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:55:04
     * @param $field
     * @param $guard_name
     * @return ValuesItemBuilder
     * @throws \Exception
     */
    public function buildValues($field, $guard_name)
    {
        //返回实例对象
        return new ValuesItemBuilder($field, $guard_name);
    }



}
