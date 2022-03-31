<?php


namespace Abnermouke\ConsoleBuilder\Builders\Table\Filters;

use Abnermouke\EasyBuilder\Module\BaseModel;

/**
 * switch筛选构建器
 * Class SwitchFilterBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Table\Filters
 */
class SwitchFilterBuilder extends BasicFilterBuilder
{

    /**
     * switch构建器
     * SwitchFilterBuilder constructor.
     */
    public function __construct()
    {
        //设置类型
        $this->type('switch')->col(2)->on()->off();
    }

    /**
     * 设置开启值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:47:48
     * @param int $value 开启值
     * @return SwitchFilterBuilder
     */
    public function on($value = BaseModel::SWITCH_ON)
    {
        //设置开启值
        return $this->extra('on', $value);
    }

    /**
     * 设置关闭值
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-18 11:47:48
     * @param int $value 关闭值
     * @return SwitchFilterBuilder
     */
    public function off($value = BaseModel::SWITCH_OFF)
    {
        //设置关闭值
        return $this->extra('off', $value);
    }

}
