<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table;

use Abnermouke\ConsoleBuilder\Builders\Table\Filters\GroupFilterBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Filters\InputFilterBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Filters\SelectFilterBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Filters\SwitchFilterBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableActionBuilder;
use Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableButtonBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

/**
 * 通用表格构建器
 * Class ConsoleTableBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table
 */
class ConsoleTableBuilder
{

    //字符串结果类型
    public const VALUE_TYPE_OF_STRING = 'string';
    //INT结果类型
    public const VALUE_TYPE_OF_INTEGRAL = 'integral';
    //FLOAT结果类型
    public const VALUE_TYPE_OF_FLOAT = 'float';
    //Array结果类型
    public const VALUE_TYPE_OF_ARRAY = 'array';

    // 构建参数
    private $builder = [
        'sign' => '',
        'theme' => '',
        'template' => '',
        'query_url' => '',
        'query_method' => '',
        'buttons' => [],
        'actions' => [],
        'action_group' => false,
        'fields' => [],
        'page' => 0,
        'page_size' => 0,
        'sorts' => [],
        'filters' => [],
        'default_search_tip' => '',
        'default_search_field' => '',
        'checkbox' => '',
        'checkbox_trigger_buttons' => '',
        'default_show_fields' => [],
        'show_fields' => [],
        'hidden_tools' => [],
        'advance_search' => false,
        'custom_filter' => false,
    ];

    /**
     * 构造函数
     * ConsoleTableBuilder constructor.
     * @param $query_url string 列表处理链接
     * @param string $theme 列表主题
     */
    public function __construct($query_url, $theme = '')
    {
        //配置基础信息
        $this->setSign(Str::random(10))->setHiddenTools()->setTheme($theme ? $theme : config('console_builder.default_theme'))->setQueryUrl($query_url, 'post')->setDefaultPage((int)config('console_builder.table.default_page', 1))->setDefaultPageSize((int)config('console_builder.table.default_page_size', 20))->setDefaultSearchField()->addSort('default', '默认排序')->addSort('recently_created', '最近创建')->addSort('recently_updated', '最近更新');
    }

    /**
     * 设置表格唯一标识
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:48:45
     * @param $sign string 唯一标识
     * @return $this
     */
    public function setSign($sign)
    {
        //设置表格唯一标示
        $this->builder['sign'] = $sign;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置需隐藏的工具（filters：搜索工具，toolbars：操作工具）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-22 01:36:06
     * @param array $tools
     * @return $this
     */
    public function setHiddenTools($tools = [])
    {
        //设置表格显示模式
        $this->builder['hidden_tools'] = $tools;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置实例化主题
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:48:59
     * @param $theme string 主题 ConsoleBuilderBasicTheme 中配置
     * @return $this
     */
    public function setTheme($theme)
    {
        //设置表格主题
        $this->builder['theme'] = strtolower($theme);
        //设置渲染对象
        $this->builder['template'] = 'vendor.abnermouke.console.builder.table.'.strtolower($theme).'.master';
        //返回当前实例对象
        return $this;
    }

    /**
     * 数据处理链接
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:49:33
     * @param $url string 数据处理链接
     * @param string $method 请求方式
     * @return $this
     */
    public function setQueryUrl($url, $method = 'post')
    {
        //设置处理链接
        $this->builder['query_url'] = $url;
        $this->builder['query_method'] = strtolower($method);
        //返回当前实例对象
        return $this;
    }

    /**
     * 添加按钮
     * @Author Abnermouke <abnermouke@outlook.com>
     *
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:58:03
     * @param $button object|array 按钮实例或内容
     * @return $this
     */
    public function addButton($button)
    {
        //判断是否传入对象
        $button = is_object($button) ? $button->get() : $button;
        //添加默认信息
        if (!empty($button['guard_name'])) {
            //设置筛选项
            $this->builder['buttons'][] = $button;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 添加数据操作按钮
     * @Author Abnermouke <abnermouke@outlook.com>
     *
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:58:03
     * @param $action object|array 数据操作实例或内容
     * @return $this
     */
    public function addAction($action)
    {
        //判断是否传入对象
        $action = is_object($action) ? $action->get() : $action;
        //判断信息
        if (!empty($action['redirect_uri'])) {
            //设置筛选项
            $this->builder['actions'][] = $action;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置Action为组合下拉显示
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-25 11:30:04
     * @param bool $group
     * @return $this
     */
    public function setActionGroup($group = true)
    {
        //设置为组合下拉显示
        return $this->setParams('action_group', $group);
    }

    /**
     * 添加排序
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:51:43
     * @param $sort_alias string 排序标识
     * @param $guard_name string 排序方式提示
     * @return $this
     */
    public function addSort($sort_alias, $guard_name)
    {
        //添加排序规则
        $this->builder['sorts'][$sort_alias] = $guard_name;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置显示复选框
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 03:22:50
     * @param $field string 复选框value使用对应字段的值
     * @param array $trigger_button_id_suffixes 已添加的按钮中专供选中后使用的按钮id后缀（配置此项后，默认按钮将不展示，选中后才显示）
     * @return $this
     */
    public function setCheckbox($field, $trigger_button_id_suffixes = [])
    {
        //设置显示复选框
        $this->builder['checkbox'] = $field;
        //设置复选框选择后触发的按钮
        $this->builder['checkbox_trigger_buttons'] = is_string($trigger_button_id_suffixes) ? explode(',', $trigger_button_id_suffixes) : $trigger_button_id_suffixes;
        //返回当前实例对象
        return $this;
    }

    public function setSubTable($query_url)
    {

    }

    /**
     * 设置是否默认打开高级搜索
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 16:20:36
     * @param false $switch_on 是否开启
     * @return $this
     */
    public function setAdvanceSearch($switch_on = false)
    {
        //设置是否默认打开高级搜索
        $this->builder['advance_search'] = $switch_on;
        //返回当前实例对象
        return $this;
    }

    /**
     * 批量设置排序
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:53:05
     * @param array $sort_groups 排序组合 [['alias' => '', 'guard_name' => ''], ['alias' => '', 'guard_name' => '']]
     * @return $this
     */
    public function setSorts($sort_groups = [])
    {
        //设置排序规则
        $this->builder['sorts'] = $sort_groups;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置默认开始页码
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:53:56
     * @param int $page 页码
     * @return $this
     */
    public function setDefaultPage($page = 1)
    {
        //设置默认开始页码
        $this->builder['page'] = (int)$page >= 1 ? (int)$page : 1;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置默认每页获取条数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:54:10
     * @param int $page_size 每页获取条数
     * @return $this
     */
    public function setDefaultPageSize($page_size = 20)
    {
        //设置默认开始页码
        $this->builder['page_size'] = (int)$page_size <= 1 ? 20 : (int)$page_size;
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置表格字段信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:48:10
     * @param \Closure $fields 字段信息
     * @return $this
     */
    public function setFields(\Closure $fields)
    {
        //设置字段信息
        $this->builder['fields'] = $fields()->get();
        //返回当前实例对象
        return $this;
    }

    /**
     * 添加表格筛选项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 14:10:05
     * @param $filter
     * @return $this
     */
    public function addFilter($filter)
    {
        //判断是否传入对象
        $filter = is_object($filter) ? $filter->get() : $filter;
        //添加默认筛选信息
        if (!empty($filter['field'])) {
            //设置筛选项
            $this->builder['filters'][] = $filter;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置默认搜索字段名
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 01:57:53
     * @param string $default_search_tip 搜索内容提示
     * @param string $default_search_field 字段名
     * @return $this
     */
    public function setDefaultSearchField($default_search_tip = '关键词', $default_search_field = '__keyword__')
    {
        //设置默认搜索提示
        $this->builder['default_search_tip'] = $default_search_tip;
        //设置默认搜索字段名
        $this->builder['default_search_field'] = $default_search_field;
        //返回当前实例对象
        return $this;
    }

    /**
     * 创建按钮构建器
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:48:36
     * @return TableButtonBuilder
     */
    public function buildBotton()
    {
        //返回实例
        return new TableButtonBuilder();
    }


    /**
     * 创建数据操作构建器
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:48:36
     * @return TableActionBuilder
     */
    public function buildAction()
    {
        //返回实例
        return new TableActionBuilder();
    }


    /**
     * 使用分组筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 15:28:42
     * @return GroupFilterBuilder
     */
    public function filterAsGroup()
    {
        //返回构建信息
        return new GroupFilterBuilder();
    }

    /**
     * 使用文本筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 15:28:42
     * @return InputFilterBuilder
     */
    public function filterAsInput()
    {
        //返回构建信息
        return new InputFilterBuilder();
    }

    /**
     * 使用switch筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 15:28:42
     * @return SwitchFilterBuilder
     */
    public function filterAsSwitch()
    {
        //返回构建信息
        return new SwitchFilterBuilder();
    }

    /**
     * 使用select筛选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 15:28:42
     * @return SelectFilterBuilder
     */
    public function filterAsSelect()
    {
        //返回构建信息
        return new SelectFilterBuilder();
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
        //初始化字段信息
        $fields = [];
        //循环字段配置整理筛选配置
        foreach ($this->builder['fields'] as $field)
        {
            //判断是否默认显示
            if ($field['show']) {
                //添加默认显示
                $this->builder['default_show_fields'][] = $field['field'];
            }
            //判断是否设置筛选
            if ($field['filter']) {
                //判断是否自定义参数
                if (data_get($field, 'filter.custom', false)) {
                    //设置自定义搜索
                    $this->builder['advance_search'] = $this->builder['custom_filter'] = true;
                }
                //新增筛选项
                $this->builder['filters'][] = $field['filter'];
            }
            //设置字段信息
            $fields[$field['field']] = $field;
        }
        //设置字段信息
        $this->builder['fields'] = $fields;
        //设置所有可以显示的字段
        $this->builder['show_fields'] = array_column($fields, 'guard_name', 'field');
        //加密核心配置（字段、标识、主题等）为签名，用于与后台通讯
        $this->builder['signature'] = Crypt::encryptString(json_encode(Arr::only($this->builder, ['sign', 'theme', 'fields', 'checkbox', 'actions', 'action_group'])));
        //调试参数
        if ((int)request()->get('__acbt_debug__', 0) === 1) {
            //打印参数
            dd($this->builder);
        }
        //渲染页面
        return view()->make($this->builder['template'], $this->builder)->render();
    }

}
