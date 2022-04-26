<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Tools;

use Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder;
use Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

/**
 * 表格构建器子集内容构建处理器
 * Class TableSubContentBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Tools
 */
class TableSubContentBuilder
{
    /**
     * 构建器内容
     * @var array
     */
    private $builder = [
        'parent_sign' => '',
        'sub_sign' => '',
        'signature' => '',
        'sign' => '',
        'theme' => '',
        'template' => '',
        'actions' =>[],
        'fields' => [],
        'data' => [],
        'sub_query_url' => '',
        'default_show_fields' => [],
        'sub_level' => 1,
        'sub_max_level' => 0,
        'checkbox' => false,
        'column_count' => 0,
        'action_group' => false,
        'custom_actions' => false,
        'custom_field' => false,
        'sub_bind_filed' => '',
    ];

    /**
     * 构造函数
     * TableContentBuilder constructor.
     * @param false $data
     */
    public function __construct($data = false)
    {
        //设置请求内容
        $data && $this->setQueryContent($data);
    }

    /**
     * 同步列表配置
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 00:47:27
     * @param $signature string 构建列表签名
     * @return $this
     */
    private function syncSignature($signature)
    {
        //判断信息
        if ($signature) {
            //拆分签名
            $signatureArr = explode('&&@@##&&', $signature);
            //设置子集编码
            $this->builder['parent_sign'] = Arr::last($signatureArr);
            //重置签名
            $signature = str_replace('&&@@##&&'.$this->builder['parent_sign'], '', $signature);
            //解析签名内容
            $builder = json_decode(Crypt::decryptString($signature), true);
            //设置基础内容
            $this->builder = array_merge($this->builder, Arr::only($builder, ['sign', 'theme', 'actions', 'fields', 'sub_level', 'column_count', 'default_show_fields', 'action_group', 'sub_bind_filed', 'sub_max_level']));
            //设置渲染对象
            $this->builder['template'] = 'vendor.abnermouke.console.builder.table.'.strtolower($this->builder['theme']).'.subs';
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置请求内容（已解密）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 00:49:35
     * @param $data
     * @return $this
     */
    public function setQueryContent($data)
    {
        //配置签名内容
        $this->syncSignature(data_get($data, 'signature', ''));
        //设置默认显示字段
        $this->builder['default_show_fields'] = data_get($data, 'shows', []);
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置查询数据
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 00:54:06
     * @param $lists array 根据条件查询到的全部数据
     * @return $this
     */
    public function setLists($lists)
    {
        //设置查询内容
        $this->builder['data'] = [
            'total_count' => count($lists),
            'matched_count' => count($lists),
            'lists' => $lists,
            'total_pages' => 1,
            'page' => 1,
            'page_size' => count($lists)
        ];
        //返回当前实例对象
        return $this;
    }

    /**
     * 获取子集表单
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-25 15:14:25
     * @param $query_url
     * @return $this
     * @throws \Exception
     */
    public function setSubTable($query_url)
    {
        //设置子集操作
        $this->builder['sub_query_url'] = ValidateLibrary::link($query_url) ? $query_url : '';
        //返回当前实例对象
        return $this;
    }

    /**
     * 清空ACtion设置
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-26 18:05:40
     * @return $this
     */
    public function clearAction()
    {
        //设置自定义并清空按钮
        $this->builder['custom_actions'] = true;
        $this->builder['actions'] = [];
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
            //判断是否设置过自定义action
            if (!$this->builder['custom_actions']) {
                //清空action
                $this->clearAction();
            }
            //设置筛选项
            $this->builder['actions'][] = $action;
        }
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
        //设置默认显示字段
        $this->builder['default_show_fields'] = array_keys($this->builder['fields']);
        //设置自定义字段
        $this->builder['custom_field'] = true;
        //返回当前实例对象
        return $this;
    }

    /**
     * 渲染构建对象
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 00:58:37
     * @param false $debug 是否调试参数
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function render($debug = false)
    {
        //设置层级
        $this->builder['sub_level'] += 1;
        //重新生成签名
        $this->builder['signature'] = Crypt::encryptString(json_encode(Arr::only($this->builder, ['sign', 'theme', 'actions', 'fields', 'sub_level', 'column_count', 'default_show_fields', 'action_group', 'custom_fields', 'sub_sign', 'sub_bind_filed', 'sub_max_level'])));
        //调试参数
        if ($debug) {
            //打印参数
            dd($this->builder);
        }
        //渲染页面
        return ['html' => view()->make($this->builder['template'], $this->builder)->render()];
    }

}
