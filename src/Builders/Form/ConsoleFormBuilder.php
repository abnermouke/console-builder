<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form;

use Abnermouke\ConsoleBuilder\Builders\Form\Items\BasicItemBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormAlertBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormButtonBuilder;
use Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormStructureBuilder;
use Illuminate\Support\Str;

/**
 * 通用表单构建器
 * Class ConsoleFormBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form
 */
class ConsoleFormBuilder
{

    // 构建参数
    private $builder = [
        'sign' => '',
        'theme' => '',
        'template' => '',
        'items' => [],
        'default_show_fields' => [],
        'submit' => [],
        'back' => [],
        'alert' => [],
        'title' => '',
        'description' => '',
        'structures' => [],
        'triggers' => [],
        'data' => [],
        'space' => 10,
        'bind_modal_id' => '',
        'bind_table_id' => '',
        'bind_table_parent_sign' => ''
    ];

    /**
     * 构造函数
     * ConsoleFormBuilder constructor.
     * @param string $theme 主题
     */
    public function __construct($theme = '')
    {
        //配置基础信息
        $this->setSign(Str::random(10))->setSpace()->setTheme($theme ? $theme : config('console_builder.default_theme'));
    }

    /**
     * 设置在指定ID modal中构建
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 17:48:15
     * @param $table_id
     * @param $modal_id
     * @param $table_parent_sign
     * @return \Abnermouke\ConsoleBuilder\Builders\Form\ConsoleFormBuilder
     */
    public function bindTable($table_id, $modal_id, $table_parent_sign)
    {
        //判断参数
        if ($table_id && $modal_id) {
            //设置绑定模态框ID
            $this->builder['bind_table_id'] = $table_id;
            $this->builder['bind_modal_id'] = $modal_id;
            $this->builder['bind_table_parent_sign'] = $table_parent_sign;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 添加字段显示结构
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:22:11
     * @param $builder
     * @return $this
     */
    public function addStructure($builder)
    {
        //判断是否传入结构
        $structure = is_object($builder) ? $builder->get() : $builder;
        //添加默认信息
        if (!empty($structure['fields'])) {
            //设置筛选项
            $this->builder['structures'][] = $structure;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * alert提示
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 17:38:12
     * @param $builder object|array Alert构建结果
     * @return $this
     */
    public function alert($builder)
    {
        //判断是否传入对象
        $alert = is_object($builder) ? $builder->get() : $builder;
        //添加默认信息
        if (data_get($alert, 'title', false)) {
            //设置筛选项
            $this->builder['alert'] = $alert;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 初始化返回按钮内容
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 17:38:54
     * @param $builder
     * @return $this
     */
    public function back($builder)
    {
        //判断是否传入对象
        $back = is_object($builder) ? $builder->get() : $builder;
        //添加默认信息
        if (data_get($back, 'redirect_uri', false)) {
            //设置筛选项
            $this->builder['back'] = $back;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 初始化提交按钮内容
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 03:01:18
     * @param $builder
     * @return $this
     */
    public function submit($builder)
    {
        //判断是否传入对象
        $submit = is_object($builder) ? $builder->get() : $builder;
        //添加默认信息
        if (data_get($submit, 'redirect_uri', false)) {
            //设置筛选项
            $this->builder['submit'] = $submit;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置Structure之间上下间距
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-22 13:10:04
     * @param int $space
     * @return $this
     */
    public function setSpace($space = 10)
    {
        //设置上下间距
        $this->builder['space'] = (int)$space;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置标题与描述
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 03:01:09
     * @param $title
     * @param string $description
     * @return $this
     */
    public function setTitle($title, $description = '')
    {
        //设置标题描述
        $this->builder['title'] = $title;
        $this->builder['description'] = $description;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置唯一标识
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 03:00:59
     * @param $sign
     * @return $this
     */
    protected function setSign($sign)
    {
        //设置表格唯一标示
        $this->builder['sign'] = $sign;
        //返回当前实例对象
        return $this;
    }

    /**
     * 生成Alert构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:02:38
     * @return FormAlertBuilder
     */
    public function buildAlert()
    {
        //返回构建对象
        return new FormAlertBuilder();
    }

    /**
     * 生成按钮构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:03:13
     * @return FormButtonBuilder
     */
    public function buildButton()
    {
        //返回构建对象
        return new FormButtonBuilder();
    }

    /**
     * 生成结构构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:03:13
     * @return FormStructureBuilder
     */
    public function buildStructure()
    {
        //返回构建对象
        return new FormStructureBuilder();
    }

    /**
     * 设置主题信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 03:00:38
     * @param $theme
     * @return $this
     */
    public function setTheme($theme)
    {
        //设置表格主题
        $this->builder['theme'] = strtolower($theme);
        //设置渲染对象
        $this->builder['template'] = 'vendor.abnermouke.console.builder.form.'.strtolower($theme).'.master';
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置表单项信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-24 15:20:24
     * @param \Closure $builder
     * @return $this
     */
    public function setItems(\Closure $builder)
    {
        //设置内容配置信息
        $this->builder['items'] = $builder()->get();
        //返回当前实例
        return $this;
    }

    /**
     * 设置数据
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 03:05:35
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        //判断信息
        if ($data) {
            //设置数据
            $this->builder['data'] = $data;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 重置默认值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-31 11:20:42
     * @return bool
     */
    private function initDefaultValues()
    {
        //循环所有字段
        foreach ($this->builder['items'] as $field => $config) {
            //根据类型处理
            switch ($config['type']) {
                case 'linkage':
                    //判断是否存在默认key
                    $config['default_value'] = $config['extras']['default_key_value'] ? [(string)$config['extras']['default_key_value']] : [];
                    //判断内容是否存在
                    if ($data = data_get($this->builder['data'], $field, '')) {
                        //设置默认值
                        $config['default_value'] = is_string($data) ? explode(',', $data) : $data;
                    }
                    break;
                case 'checkbox':
                case 'image_checkbox':
                case 'normal_checkbox':
                case 'tags':
                case 'values':
                    //判断内容是否存在
                    if ($data = data_get($this->builder['data'], $field, '')) {
                        //设置默认值
                        $config['default_value'] = is_string($data) ? explode(',', $data) : $data;
                    }
                    break;
                case 'files':
                    //判断内容是否存在
                    if ($data = data_get($this->builder['data'], $field, '')) {
                        //设置默认值
                        $config['default_value'] = $data !== '[]' ? (is_string($data) ? explode(',', $data) : $data) : object_2_array($data);
                    } else {
                        $config['default_value'] = [];
                    }
                    break;
                case 'input':
                    //设置默认值信息
                    $default_value = data_get($this->builder['data'], $field, $config['default_value']);;
                    //判断是否为金额
                    if ($config['extras']['input_type'] === 'number' && data_get($config, 'extras.ratio', 0) > 0 && (int)$default_value > 0) {
                        //设置默认信息
                        $default_value = $default_value/(int)$config['extras']['ratio'];
                    }
                    //设置默认信息
                    $config['default_value'] = $default_value;
                    break;
                default:
                    //设置默认信息
                    $config['default_value'] = data_get($this->builder['data'], $field, $config['default_value']);
                    break;
            }
            //判断值类型
            switch ($config['value_type']) {
                case BasicItemBuilder::VALUE_TYPE_OF_INTEGRAL:
                    //设置int值
                    $config['default_value'] = (int)$config['default_value'];
                    break;
                case BasicItemBuilder::VALUE_TYPE_OF_FLOAT:
                    //设置float值
                    $config['default_value'] = (float)$config['default_value'];
                    break;
            }
            //设置信息
            $this->builder['items'][$field] = $config;
        }
        //返回成功
        return true;
    }

    /**
     * 设置字段触发
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-31 11:38:20
     * @return bool
     */
    private function initTriggerFileds()
    {
        //循环所有字段
        foreach ($this->builder['items'] as $field => $config) {
            //判断是否为radio或者switch
            if (in_array($config['type'], ['radio', 'normal_radio', 'image_radio', 'switch']) && $config['triggers']) {
                //循环触发
                foreach ($config['triggers'] as $value => $rules) {
                    //判断存在规则
                    if ($rules) {
                        //判断当前的值
                        if ($value === $config['default_value']) {
                            //循环显示字段
                            foreach ($rules as $show_field) {
                                //设置显示
                                data_set($this->builder, 'items.'.$show_field.'.hidden', false);
                            }
                        } else {
                            //循环显示字段
                            foreach ($rules as $show_field) {
                                //设置隐藏
                                data_set($this->builder, 'items.'.$show_field.'.hidden', true);
                            }
                        }
                    }
                }
            }
        }
        //返回成功
        return true;
    }


    /**
     * 渲染构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 15:31:57
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function render()
    {
        //初始化信息
        $this->builder['items'] = array_column($this->builder['items'], null, 'field');
        //重置默认值
        $this->initDefaultValues();
        //设置触发字段
        $this->initTriggerFileds();
        //判断是否绑定信息
        if ($this->builder['bind_modal_id'] && $this->builder['bind_table_id']) {
            //设置关闭modal后刷新表格
            data_set($this->builder, 'submit.after_ajax', FormButtonBuilder::AJAX_AFTER_REFRESH_TABLE);
        }
        //判断结构
        if (!$this->builder['structures']) {
            //生成实例
            $structure = $this->buildStructure();
            //循环字段
            foreach ($this->builder['items'] as $field => $item) {
                //添加字段
                $structure->addFiled($field, 12);
            }
            //设置默认结构
            $this->addStructure($structure);
        }
        //调试参数
        if ((int)request()->get('__acbf_debug__', 0) === 1) {
            //打印参数
            dd($this->builder);
        }
        //渲染页面
        return view()->make($this->builder['template'], $this->builder)->render();
    }

}
