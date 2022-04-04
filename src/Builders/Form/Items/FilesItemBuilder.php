<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

use Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormItemsBuilder;
use Illuminate\Support\Arr;

/**
 * 文件表单项构建器
 * Class FilesItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class FilesItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * FilesItemBuilder constructor.
     * @param $filed
     * @param $guard_name
     * @throws \Exception
     */
    public function __construct($filed, $guard_name)
    {
        //设置基础数据
        $this->setParam('type', 'files')->guard_name($guard_name)->field($filed)->accept()->multiple(true)->uploader()->dictionary()->value_type(BasicItemBuilder::VALUE_TYPE_OF_OBJECT);
    }


    /**
     * 设置上传链接
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-29 16:19:07
     * @param false $url
     * @return FilesItemBuilder
     */
    public function uploader($url = false)
    {
        //设置链接
        $url = $url ? $url : route('abnermouke.console.uploader');
        //设置信息并返回
        return $this->extra('uploader_url', $url);
    }

    /**
     * 设置上传目录
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-29 17:45:51
     * @param string $dictionary
     * @return FilesItemBuilder
     */
    public function dictionary($dictionary = 'abnermouke/console/builder/uploader/files')
    {
        //设置上传目录
        return $this->extra('dictionary', $dictionary);
    }
    /**
     * 允许上传文件类型
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:41:11
     * @param string $accept
     * @return FilesItemBuilder
     */
    public function accept($accept = '*/*')
    {
        //设置允许图片类型
        return $this->extra('accept', $accept);
    }

    /**
     * 是否可多选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:41:03
     * @param bool $multiple
     * @return FilesItemBuilder
     */
    public function multiple($multiple = true)
    {
        //设置是否为多选
        return $this->extra('multiple', $multiple);
    }

}
