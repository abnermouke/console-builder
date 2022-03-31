<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

use Illuminate\Support\Arr;

/**
 * 图片表单项构建器
 * Class ImageItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class ImageItemBuilder extends BasicItemBuilder
{
    /**
     * 构造函数
     * ImageItemBuilder constructor.
     * @param $filed
     * @param $guard_name
     * @throws \Exception
     */
    public function __construct($filed, $guard_name)
    {
        //设置基础数据
        $this->setParam('type', 'image')->guard_name($guard_name)->field($filed)->accept()->size('200x200')->uploader()->dictionary();
    }

    /**
     * 设置上传链接
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-29 16:19:07
     * @param false $url
     * @return ImageItemBuilder
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
     * @return ImageItemBuilder
     */
    public function dictionary($dictionary = 'abnermouke/console/builder/uploader/images')
    {
        //设置上传目录
        return $this->extra('dictionary', $dictionary);
    }

    /**
     * 配置图片显示尺寸
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:36:22
     * @param false $size 截取尺寸
     * @return $this|ImageItemBuilder
     */
    public function size($size = false)
    {
        //设置尺寸信息
        if ($size) {
            //拆分尺寸信息
            $size = explode('x', str_replace('×', 'x', $size));
            //设置宽高信息
            return $this->width(Arr::first($size))->height(Arr::last($size))->extra('size', implode('x', $size));
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置允许的图片后缀
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:36:51
     * @param string $ext 允许后缀
     * @return ImageItemBuilder
     */
    public function accept($ext = '*')
    {
        //设置允许图片类型
        return $this->extra('accept', 'image/'.$ext);
    }

    /**
     * 设置图片限制宽度
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:37:05
     * @param int $width
     * @return ImageItemBuilder
     */
    private function width($width = 0)
    {
        //设置宽度信息
        return (int)$width > 0 ? $this->extra('width', (int)$width)->extra('box_width', (int)$width) : $this;
    }

    /**
     * 设置图片限制高度
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 02:37:11
     * @param int $height
     * @return ImageItemBuilder
     */
    private function height($height = 0)
    {
        //设置高度信息
        return (int)$height > 0 ? $this->extra('height', (int)$height)->extra('box_height', (int)$height) : $this;
    }

}
