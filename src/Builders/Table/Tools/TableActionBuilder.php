<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Tools;


use Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder;

/**
 * 表格构建器数据操作构建处理器
 * Class TableActionBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Tools
 */
class TableActionBuilder
{
    /**
     * 操作信息
     * @var array
     */
    private $action = [
        'type' => 'link', 'guard_name' => '', 'theme' => 'primary', 'redirect_uri' => 'javascript:;', 'redirect_target' => false, 'icon' => '', 'method' => 'get', 'param_fields' => [], 'confirm_tip' => '', 'extras' => [], 'after_ajax' => '', 'conditions' => [], 'condition_mode' => '&&'
    ];

    /**
     * 请求前确认
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:47:36
     * @param string $tip 提示文字
     * @return TableActionBuilder
     */
    public function confirm_before_query($tip = '请确认继续此操作!')
    {
        //设置提示确认
        return $this->setParams('confirm_tip', $tip);
    }

    /**
     * 将某些字段的值做为默认参数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 18:39:43
     * @param array $fields 字段名（可多个，不存在的自动剔除）
     * @return $this
     */
    public function param_fields($fields = [])
    {
        //设置默认参数字段
        return $this->setParams('param_fields', $fields);
    }

    /**
     * 设置跳转/请求链接
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:40:56
     * @param $url string 跳转链接
     * @param $param_fields array 将某些字段的值做为默认参数
     * @param string $method 请求方式
     * @param false $target 是否新开（get时使用）
     * @return $this
     */
    public function url($url, $param_fields = [], $method = 'get', $target = false)
    {
        //判断是否非get请求方式
        if ($method !== 'get') {
            //设置ajax请求方式
            $this->setParams('is_ajax', true);
        }
        //设置跳转/请求链接
        return $this->setParams('redirect_uri', $url)->setParams('method', $method)->setParams('redirect_target', $target)->param_fields($param_fields);
    }

    /**
     * 设置ajax请求
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:44:25
     * @param $url string 请求链接
     * @param $method string 请求方式
     * @param $param_fields array 将某些字段的值做为默认参数
     * @param string $after ajax执行完毕后表格操作 refresh：刷新当前列表（当前条件）；reload：页面刷新；其他：请给链接（执行完毕后跳转到对应链接）
     * @return TableActionBuilder
     */
    public function ajax($url, $method, $param_fields = [], $after = 'refresh')
    {
        //设置ajax请求
        return $this->setParams('type', 'ajax')->setParams('redirect_uri', $url)->setParams('redirect_target', false)->setParams('method', $method)->setParams('after_ajax', $after)->param_fields($param_fields);
    }

    /**
     * 设置modal模态框请求（modal弹窗）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:44:25
     * @param $bind_modal_target string 绑定现成的模态框ID(不存在将自动生成随机模态框加载动态内容)
     * @param $url string 请求链接
     * @param $method string 请求方式
     * @param $param_fields array 将某些字段的值做为默认参数
     * @param string $after ajax执行完毕后表格操作 refresh：刷新当前列表（当前条件）；reload：页面刷新；其他：请给链接（执行完毕后跳转到对应链接）
     * @return TableActionBuilder
     */
    public function modal($bind_modal_target, $url, $method, $param_fields = [], $after = 'refresh')
    {
        //设置ajax请求
        return $this->setParams('type', 'modal')->setParams('redirect_uri', $url)->setParams('redirect_target', false)->setParams('method', $method)->setParams('after_ajax', $after)->param_fields($param_fields)->extra('modal_size', 'lg')->extra('modal_target', $bind_modal_target);
    }

    /**
     * 设置form表单触发（modal弹窗）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-31 17:10:14
     * @param $url
     * @param $method
     * @param array $param_fields
     * @return TableActionBuilder
     */
    public function form($url, $method, $param_fields = [])
    {
        //设置form表单触发
        return $this->setParams('type', 'form')->setParams('redirect_uri', $url)->setParams('redirect_target', false)->setParams('method', $method)->param_fields($param_fields)->extra('modal_size', 'lg');
    }

    /**
     * 设置图标信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:38:50
     * @param $icon string 设置图标
     * @return TableActionBuilder
     */
    public function icon($icon)
    {
        //设置图标
        return $this->setParams('icon', $icon);
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
    public function theme($theme = '')
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
        $this->action[$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 设置显示条件连接关系
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-25 10:48:45
     * @param string $mode （&&、||）
     * @return $this
     */
    public function condition_mode($mode = '&&') {
        //返回当前实例
        return $this->setParams('condition_mode', $mode);
    }

    /**
     * 新增显示条件
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-25 10:47:45
     * @param $field string 字段名
     * @param $operator string 运算符（=, >=, >, <=, <, in, not-in）
     * @param $value mixed 条件值（in, not-in为数组）
     * @param string $type 值类型（int：整形，string：字符串，float：浮点型）
     * @return $this\
     */
    public function condition($field, $operator, $value, $type = ConsoleTableBuilder::VALUE_TYPE_OF_STRING)
    {
        //添加显示条件
        $this->action['conditions'][] = compact('field', 'operator', 'value', 'type');
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
        $this->action['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 获取操作信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:08:45
     * @return array
     */
    public function get()
    {
        //返回按钮信息
        return $this->action;
    }

}
