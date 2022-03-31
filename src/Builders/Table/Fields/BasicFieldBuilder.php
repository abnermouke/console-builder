<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Fields;

/**
 * 表格构建器基础字段构建器
 * Class ConsoleTableBasicFieldBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Fields
 */
class BasicFieldBuilder
{

    //默认参数
    protected $filed = [
        'type' => '', 'guard_name' => '', 'field' => '', 'empty_value' => '---', 'bold' => false, 'template' => '', 'link' => '', 'theme' => 'dark', 'theme_options_trigger_field' => '',
        'theme_options' => [], 'description_template' => '', 'show' => true, 'filter' => false, 'extras' => []
    ];

    /**
     * 设置点击跳转链接
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:23:41
     * @param string $link 将自动替换链接中__ __包含字段，如__ID__将被当前项对应id字段内容替换
     * @return $this
     */
    public function link($link = '')
    {
        //设置点击跳转链接
        return $this->setParam('link', $link);
    }

    /**
     * 设置默认文本主题色
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 03:16:09
     * @param $theme string 主题色 primary/danger等
     * @return $this
     */
    public function theme($theme)
    {
        //设置默认显示主题
        return $this->setParam('theme', $theme);
    }

    /**
     * 设置多主题规则
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:29:06
     * @param $options array 主题规则  ConsoleBuilderBasicTheme 中配置
     * @param string $trigger_field 主题触发字段，默认为当前字段
     * @return $this
     */
    public function theme_options($options, $trigger_field = '')
    {
        //设置多主题选项
        return $this->setParam('theme_options', $options)->setParam('theme_options_trigger_field', ($trigger_field ? $trigger_field : $this->filed['field']));
    }

    /**
     * 设置字段值不可展示时默认填充符
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:33:49
     * @param $value string 填充符
     * @return $this
     */
    public function empty($value = '---')
    {
        //设置字段值为空/不存在/null时默认展示内容
        return $this->setParam('empty_value', $value);
    }

    /**
     * 设置字段显示名称
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:31:44
     * @param $guard_name string 显示名称
     * @return $this
     */
    public function guard_name($guard_name)
    {
        //设置显示名称
        return $this->setParam('guard_name', $guard_name);
    }

    /**
     * 配置字段名
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:33:09
     * @param $field string 字段名
     * @return $this
     */
    protected function field($field)
    {
        //设置字段信息
        return $this->setParam('field', $field)->setParam('template', '{'.$field.'}')->setParam('theme_options_trigger_field', $field);
    }

    /**
     * 配置类型
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:33:09
     * @param $type string 字段类型
     * @return $this
     */
    protected function type($type)
    {
        //设置字段类型
        return $this->setParam('type', $type);
    }

    /**
     * 设置使用加粗字体显示
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:17:58
     * @param bool $bold 是否加粗
     * @return $this
     */
    public function bold($bold = true)
    {
        //设置加粗显示
        return $this->setParam('bold', $bold);
    }

    /**
     * 设置默认显示字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:21:56
     * @param bool $show
     * @return $this
     */
    public function show($show = true)
    {
        //设置默认显示
        return $this->setParam('show', $show);
    }

    /**
     * 设置内容描述
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:20:18
     * @param string $template {}包含字段将动态获取当前项对应字段内容并显示
     * @return $this
     */
    public function description($template = '')
    {
        //设置内容描述
        return $this->setParam('description_template', $template);
    }

    /**
     * 设置字段值展示模版
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:20:18
     * @param string $template {}包含字段将动态获取当前项对应字段内容并显示
     * @return $this
     */
    public function template($template)
    {
        //设置内容描述
        return $this->setParam('template', $template);
    }

    /**
     * 设置公共参数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:15:34
     * @param $key string 设置对象
     * @param $value mixed 设置对象对应值
     * @return $this
     */
    protected function setParam($key, $value)
    {
        //设置公共参数
        $this->filed[$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 设置字段筛选规则
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:37:41
     * @param object|array $filter 筛选规则
     * @return $this
     */
    public function setFilter($filter)
    {
        //设置字段筛选规则
        if ($this->filed['filter'] = is_object($filter) ? $filter->get() : $filter) {
            //判断是否设置名称
            $this->filed['filter']['guard_name'] = $this->filed['filter']['guard_name'] ? $this->filed['filter']['guard_name'] : $this->filed['guard_name'];
            $this->filed['filter']['field'] = $this->filed['filter']['field'] ? $this->filed['filter']['field'] : $this->filed['field'];
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 自定义额外导入信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:19:15
     * @param $key string 设置对象
     * @param $value mixed 设置对象对应值
     * @return $this
     */
    public function extra($key, $value)
    {
        //自定义额外导入信息
        $this->filed['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 获取字段内容信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:36:16
     * @return array
     */
    public function get()
    {
        //返回实例内容
        return $this->filed;
    }

}
