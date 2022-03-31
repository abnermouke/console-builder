<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Tools;

/**
 * 表单按钮构建器
 * Class FormButtonBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Tools
 */
class FormButtonBuilder
{

    //执行成功后刷新页面
    public const AJAX_AFTER_RELOAD = 'reload';
    //执行成功后返回或刷新页面（不存在返回按钮时）
    public const AJAX_AFTER_BACK = 'back_or_reload';
    //执行成功后刷新页面（需绑定modal以及table，先关闭modal然后刷新表格内容，不满足时将执行AJAX_AFTER_BACK）
    public const AJAX_AFTER_REFRESH_TABLE = 'refresh_table_after_modal_close';


    /**
     * 按钮信息
     * @var array
     */
    private $button = [
        'type' => 'link', 'title' => '', 'theme' => 'primary', 'redirect_uri' => 'javascript:;', 'redirect_target' => false, 'method' => 'get', 'confirm_tip' => '', 'extras' => [], 'after_ajax' => ''
    ];

    /**
     * 请求前确认
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:47:36
     * @param string $tip 提示文字
     * @return FormButtonBuilder
     */
    public function confirm_before_query($tip = '请确认继续此操作!')
    {
        //设置提示确认
        return $this->setParams('confirm_tip', $tip);
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
     * @param string $url
     * @param $method
     * @param string $after ajax执行完毕后表格操作
     * @param array $params 默认请求参数
     * @return FormButtonBuilder
     */
    public function ajax($url, $method, $after = self::AJAX_AFTER_BACK, $params = [])
    {
        //设置ajax请求
        return $this->setParams('type', 'ajax')->setParams('is_ajax', true)->setParams('redirect_uri', $url)->setParams('redirect_target', false)->setParams('method', $method)->setParams('after_ajax', $after)->extra('params', $params);
    }

    /**
     * 设置显示文字
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:18:13
     * @param string $text
     * @return $this
     */
    public function title($text = '')
    {
        //设置显示文字
        return $this->setParams('title', $text);
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
