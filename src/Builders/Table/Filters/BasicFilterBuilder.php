<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Filters;

/**
 * 表格构建器基础筛选构建器
 * Class ConsoleTableBasicFilterBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Filters
 */
class BasicFilterBuilder
{

    /**
     * 筛选项
     * @var array
     */
    protected $filter = [
        'type' => '', 'field' => '', 'guard_name' => '', 'default_value' => '', 'custom' => false, 'extras' => [], 'col_number' => 2
    ];

    /**
     * 设置默认值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:23:18
     * @param $value mixed 默认值
     * @param bool $custom 是否为自定义默认值（非系统默认）
     * @return $this
     */
    public function default_value($value, $custom = true)
    {
        //判断是否设置有效值
        if (strlen($value) > 0) {
            //设置默认值
            return $this->setParam('default_value', $value)->setParam('custom', $custom);
        } else {
            //返回当前实例
            return $this;
        }
    }

    /**
     * 设置宽度栏数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:28:35
     * @param int $col_number
     * @return $this
     */
    public function col($col_number = 2)
    {
        //判断数值
        if ((int)$col_number > 12) {
            //设置最大为12
            $col_number = 12;
        } elseif ((int)$col_number < 2) {
            //设置最小为2
            $col_number = 2;
        }
        //设置宽度栏数
        return $this->setParam('col_number', (int)$col_number);
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
     * 设置字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:31:44
     * @param $field string 显示字段
     * @return $this
     */
    public function field($field)
    {
        //设置显示名称
        return $this->setParam('field', $field);
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
        $this->filter[$key] = $value;
        //返回当前实例
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
        $this->filter['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }


    /**
     * 获取筛选内容信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 02:36:16
     * @return array
     */
    public function get()
    {
        //返回实例内容
        return $this->filter;
    }



}
