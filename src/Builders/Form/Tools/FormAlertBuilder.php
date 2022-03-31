<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Tools;

/**
 * 表单提示构建器
 * Class FormAlertBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Tools
 */
class FormAlertBuilder
{
    /**
     * 提示信息
     * @var array
     */
    private $alert = ['title' => '', 'description' => '', 'theme' => 'primary', 'bg_light' => true, 'bolder' => false, 'bold_style' => 'dashed', 'dismissible' => true, 'icon' => '', 'extras' => []];

    /**
     * 设置标题
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 18:27:14
     * @param $title
     * @param string $description
     * @return FormAlertBuilder
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
     * 设置主题
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 18:27:27
     * @param string $theme
     * @param bool $bg_light
     * @return FormAlertBuilder
     */
    public function theme($theme = 'primary', $bg_light = true)
    {
        //设置主题
        return $this->setParams('theme', $theme)->setParams('bg_light', $bg_light);

    }

    /**
     * 设置边框
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 18:27:39
     * @param $bolder
     * @param string $bolder_style
     * @return FormAlertBuilder
     */
    public function bolder($bolder, $bolder_style = 'dashed')
    {
        //设置边框
        return $this->setParams('bolder', $bolder)->setParams('bold_style', $bolder_style);
    }

    /**
     * 设置可关闭
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 18:27:46
     * @param bool $dismissible
     * @return $this
     */
    public function dismissible($dismissible = true)
    {
        //设置可关闭
        return $this->setParams('dismissible', $dismissible);
    }

    /**
     * 设置图标
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-22 18:27:53
     * @param $icon
     * @return $this
     */
    public function icon($icon)
    {
        //设置显示图标
        return $this->setParams('icon', $icon);
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
        $this->alert[$key] = $value;
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
        $this->alert['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 获取提示信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-19 15:08:45
     * @return array
     */
    public function get()
    {
        //返回按钮信息
        return $this->alert;
    }




}
