<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Tools;


/**
 * 表格构建器按钮构建处理器
 * Class TableButtonBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Tools
 */
class TableButtonBuilder
{
    /**
     * 按钮信息
     * @var array
     */
    private $button = [
        'type' => 'link', 'guard_name' => '', 'theme' => 'primary', 'redirect_uri' => 'javascript:;', 'redirect_target' => false, 'icon' => '', 'id_suffix' => '', 'only_show_icon' => false, 'method' => 'get', 'confirm_tip' => '', 'extras' => [], 'after_ajax' => ''
    ];

    /**
     * 请求前确认
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:47:36
     * @param string $tip 提示文字
     * @return TableButtonBuilder
     */
    public function confirm_before_query($tip = '请确认继续此操作!')
    {
        //设置提示确认
        return $this->setParams('confirm_tip', $tip);
    }

    /**
     * 设置ID后缀
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:45:21
     * @param string $suffix 后缀
     * @return $this
     */
    public function id_suffix($suffix = '')
    {
        //设置自定义按钮后缀
        return $this->setParams('id_suffix', $suffix);
    }

    /**
     * 设置跳转/请求链接
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:40:56
     * @param $url string 跳转链接
     * @param string $method 请求方式
     * @param false $target 是否新开（get时使用）
     * @return $this
     */
    public function url($url, $method = 'get', $target = false)
    {
        //判断是否非get请求方式
        if ($method !== 'get') {
            //设置ajax请求方式
            $this->setParams('is_ajax', true);
        }
        //设置跳转/请求链接
        return $this->setParams('redirect_uri', $url)->setParams('method', $method)->setParams('redirect_target', $target);
    }

    /**
     * 设置ajax请求
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:44:25
     * @param $url
     * @param $method
     * @param string $after ajax执行完毕后表格操作 refresh：刷新当前列表（当前条件）；reload：页面刷新；其他：请给链接（执行完毕后跳转到对应链接）
     * @param array $params 默认请求参数
     * @return TableButtonBuilder
     */
    public function ajax($url, $method, $after = 'refresh', $params = [])
    {
        //设置ajax请求
        return $this->setParams('type', 'ajax')->setParams('redirect_uri', $url)->setParams('redirect_target', false)->setParams('method', $method)->setParams('after_ajax', $after)->extra('params', $params);
    }

    /**
     * 设置图标信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:38:50
     * @param $icon string 设置图标
     * @param false $only_show_icon
     * @return TableButtonBuilder
     */
    public function icon($icon, $only_show_icon = false)
    {
        //设置图标
        return $this->setParams('icon', $icon)->setParams('only_show_icon', $only_show_icon);
    }

    /**
     * 设置显示/提示文字
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:18:13
     * @param string $text
     * @return $this
     */
    public function text($text = '')
    {
        //设置显示文字
        return $this->setParams('guard_name', $text);
    }

    /**
     * 设置主题
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:19:06
     * @param string $theme
     * @return $this
     */
    public function theme($theme = 'primary')
    {
        //设置主题
        return $this->setParams('theme', $theme);
    }

    /**
     * 设置参数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:11:59
     * @param $key
     * @param $value
     * @return $this
     */
    protected function setParams($key, $value)
    {
        //设置参数
        $this->button[$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 设置自定义参数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:12:06
     * @param $key
     * @param $value
     * @return $this
     */
    public function extra($key, $value)
    {
        //设置参数
        $this->button['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 获取按钮信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:08:45
     * @return array
     */
    public function get()
    {
        //返回按钮信息
        return $this->button;
    }

}
