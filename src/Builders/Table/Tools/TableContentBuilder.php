<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Tools;

use Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

/**
 * 表格构建器内容构建处理器
 * Class TableContentBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Tools
 */
class TableContentBuilder
{

    private $builder = [
        'signature' => '',
        'sign' => '',
        'theme' => '',
        'template' => '',
        'actions' =>[],
        'fields' => [],
        'page' => 0,
        'page_size' => 0,
        'checkbox' => '',
        'default_show_fields' => [],
        'data' => [],
        'sub_query_url' => '',
        'sub_level' => 1,
        'sub_max_level' => 0,
        'sub_sign' => '',
        'sub_bind_filed' => '',
        'column_count' => 0,
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
            //解析签名内容
            $builder = json_decode(Crypt::decryptString($signature), true);
            //设置基础内容
            $this->builder = array_merge($this->builder, $builder);
            //设置渲染对象
            $this->builder['template'] = 'vendor.abnermouke.console.builder.table.'.strtolower($this->builder['theme']).'.content';
            //设置签名
            $this->builder['table_signature'] = $signature;
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
        //配置页码
        $this->builder['page'] = (int)data_get($data, 'page', (int)config('console_builder.table.default_page', 1));
        $this->builder['page_size'] = (int)data_get($data, 'page_size', (int)config('console_builder.table.default_page_size', 20));
        $this->builder['default_show_fields'] = data_get($data, 'shows', []);
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置查询数据
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-21 00:54:06
     * @param $lists array 根据条件查询到的数据
     * @return $this
     */
    public function setLists($lists)
    {
        //设置查询内容
        $this->builder['data'] = $lists;
        //返回当前实例对象
        return $this;
    }

    /**
     * 获取子列表表单
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-26 14:24:24
     * @param $query_url
     * @param string $bind_field
     * @param int $max_level 0：不限制层级；>0具体层级
     * @return $this
     * @throws \Exception
     */
    public function setSubTable($query_url, $bind_field = '', $max_level = 0)
    {
        //设置子列表操作
        $this->builder['sub_query_url'] = ValidateLibrary::link($query_url) ? $query_url : '';
        //设置子列表绑定ID
        $this->builder['sub_bind_filed'] = $bind_field;
        //设置子列表绑定ID
        $this->builder['sub_max_level'] = (int)$max_level;
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
        //调试参数
        if ($debug) {
            //打印参数
            dd($this->builder);
        }
        //整理栏目数量
        $this->builder['column_count'] = count($this->builder['fields']) + ($this->builder['actions'] ? 1 : 0) + ($this->builder['checkbox'] ? 1 : 0) + ($this->builder['sub_query_url'] ? 1 : 0);
        //加密核心配置（字段、标识、主题等）为签名，用于与后台通讯
        $this->builder['signature'] = Crypt::encryptString(json_encode(Arr::only($this->builder, ['sign', 'theme', 'fields', 'actions', 'sub_level', 'column_count', 'default_show_fields', 'action_group', 'sub_max_level'])));
        //渲染页面
        return ['html' => view()->make($this->builder['template'], $this->builder)->render()];
    }

}
