<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * 基础表单项构建器
 * Class BasicItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class BasicItemBuilder
{

    //字符串结果类型
    public const VALUE_TYPE_OF_STRING = 'string';
    //INT结果类型
    public const VALUE_TYPE_OF_INTEGRAL = 'integral';
    //FLOAT结果类型
    public const VALUE_TYPE_OF_FLOAT = 'float';
    //对象结果类型
    public const VALUE_TYPE_OF_OBJECT = 'object';


    //表单项基础内容
    protected $item = [
        'type' => '', 'guard_name' => '', 'tip' => '', 'description' => false, 'required' => false,
        'field' => '', 'extras' => [], 'default_value' => '', 'readonly' => false,
        'disabled' => false, 'hidden' => false, 'triggers' => [], 'value_type' => BasicItemBuilder::VALUE_TYPE_OF_STRING
    ];

    /**
     * 设置只读
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param bool $readonly 是否只读
     * @return $this
     * @throws \Exception
     */
    public function readonly($readonly = true)
    {
        //设置只读
        return $this->setParam('readonly', $readonly);
    }

    /**
     * 设置禁用
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param bool $disabled 是否禁用
     * @return $this
     * @throws \Exception
     */
    public function disabled($disabled = true)
    {
        //设置禁用
        return $this->setParam('disabled', $disabled);
    }

    /**
     * 设置是否必选
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param bool $required 是否必选
     * @return $this
     * @throws \Exception
     */
    public function required($required = true)
    {
        //设置是否必选
        return $this->setParam('required', $required);
    }

    /**
     * 设置表单项描述信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param mixed $description 描述信息
     * @return $this
     * @throws \Exception
     */
    public function description($description = false)
    {
        //设置字段描述信息
        return $this->setParam('description', $description);
    }

    /**
     * 设置对应字段
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param $field string 字段名
     * @return $this
     * @throws \Exception
     */
    protected function field($field)
    {
        //设置对应字段
        return $this->setParam('field', $field);
    }

    /**
     * 设置显示名称
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param $guard_name string 显示名称
     * @return $this
     * @throws \Exception
     */
    public function guard_name($guard_name)
    {
        //设置显示名称
        return $this->setParam('guard_name', $guard_name);
    }

    /**
     * 设置显示提示
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param $tip string 提示内容
     * @return $this
     * @throws \Exception
     */
    public function tip($tip)
    {
        //设置显示名称
        return $this->setParam('tip', $tip);
    }

    /**
     * 设置默认值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param $value mixed 默认值
     * @return $this
     * @throws \Exception
     */
    public function default_value($value)
    {
        //设置默认值
        return $this->setParam('default_value', $value);
    }

    /**
     * 设置是否隐藏表单项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param bool $hide 是否隐藏
     * @return $this
     * @throws \Exception
     */
    public function hidden($hide = true)
    {
        //设置是否隐藏表单项
        return $this->setParam('hidden', $hide);
    }

    /**
     * 设置参数
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:28:59
     * @param $key string 设置对象
     * @param $value mixed 设置对象对应值
     * @return $this
     */
    protected function setParam($key, $value)
    {
        //设置公共参数
        $this->item[$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 添加触发规则
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:15:04
     * @param $value mixed 触发值
     * @param array $trigger_show_fields 显示字段
     * @return $this
     */
    protected function addTrigger($value, $trigger_show_fields = [])
    {
        //添加触发
        $this->item['triggers'][$value] = $trigger_show_fields;
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
     * @param $array_append
     * @return $this
     */
    public function extra($key, $value, $array_append = false)
    {
        //判断是否为数组新增内容
        if ($array_append) {
            //自定义额外导入信息
            $this->item['extras'][$key][] = $value;
        } else {
            //自定义额外导入信息
            $this->item['extras'][$key] = $value;
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置该项值的属性
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-04 11:56:45
     * @param string $type
     * @return $this
     */
    public function value_type($type = BasicItemBuilder::VALUE_TYPE_OF_STRING) {
        //设置value类型
        return $this->setParam('value_type', $type);
    }

    /**
     * 获取表单项内容
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:33:04
     * @return array
     */
    public function get()
    {
        //根据类型自定义处理
        switch ($this->item['type']) {
            case 'image':
                //判断宽度是否大于300
                if (($box_width = (int)data_get($this->item, 'extras.box_width', 200)) > 305) {
                    //设置宽度
                    $this->item['extras']['box_width'] = 305;
                    //计算高度
                    $this->item['extras']['box_height'] = (int)((int)$this->item['extras']['box_height'] * (305/$box_width));
                }
                break;
        }
        //返回表单项信息
        return $this->item;
    }



}
