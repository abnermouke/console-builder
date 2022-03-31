<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Tools;


/**
 * 表单结构构建器
 * Class FormStructureBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Tools
 */
class FormStructureBuilder
{
    /**
     * 结构信息
     * @var array
     */
    private $structure = [
        'title' => '', 'fields' => [], 'description' => '', 'alert' => [], 'extras' => []
    ];


    /**
     * 设置标题
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 18:27:14
     * @param $title
     * @param string $description
     * @return FormStructureBuilder
     */
    public function title($title, $description = '')
    {
        //设置标题
        return $this->setParams('title', $title)->description($description);
    }

    /**
     * 设置提示
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 18:27:20
     * @param string $description
     * @return $this
     */
    public function description($description = '')
    {
        //设置描述
        return $this->setParams('description', $description);
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
        if (!empty($alert['title'])) {
            //设置筛选项
            $this->structure['alert'] = $alert;
        }
        //返回当前实例对象
        return $this;
    }

    /**
     * 设置字段结构
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:18:20
     * @param $fields array 字段
     * @param array $cols 对应显示栏数
     * @return $this
     */
    public function setFields($fields, $cols = [])
    {
        //判断字段信息
        if ($fields) {
            //设置默认信息
            $this->setParams('fields', []);
            //循环字段信息
            foreach ($fields as $k => $field) {
                //添加字段
                $this->addFiled($field, data_get($cols, (int)$k, 12));
            }
        }
        //返回当前实例
        return $this;
    }

    /**
     * 添加包含字段（触发字段将自动包含至此结构中）
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:16:50
     * @param $filed string 字段名
     * @param int $col 对应显示栏数（最小：3）
     * @return $this
     */
    public function addFiled($filed, $col = 12)
    {
        //添加字段信息
        $this->structure['fields'][$filed] = (int)$col < 3 ? 3 :  (int)$col;
        //返回当前实例
        return $this;
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
        $this->structure[$key] = $value;
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
        $this->structure['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 获取结构信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:08:45
     * @return array
     */
    public function get()
    {
        //返回按钮信息
        return $this->structure;
    }

}
