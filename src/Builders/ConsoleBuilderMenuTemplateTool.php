<?php


namespace Abnermouke\ConsoleBuilder\Builders;

/**
 * 控制台菜单模版处理工具
 * Class ConsoleBuilderMenuTemplateTool
 * @package Abnermouke\ConsoleBuilder\Builders
 */
class ConsoleBuilderMenuTemplateTool
{

    /**
     * km8主题递归目录html
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-17 02:53:39
     * @param $menu array 菜单信息
     * @param array $customs array 自定义替换信息
     * @param string $triggers 触发方式 （默认：点击，大屏：hover）
     * @param string $placement
     * @return string
     */
    public static function km8($menu, $customs = [], $triggers = "{default:'click', lg: 'hover'}", $placement = 'right-start')
    {
        //整理基础模版
        $content = '<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">';
        //循环子菜单
        foreach ($menu['subs'] as $sub_menu) {
            //处理菜单信息
            if ($customs && isset($customs[$sub_menu['alias']])) {
                //替换信息
                $sub_menu = array_merge($sub_menu, $customs[$sub_menu['alias']]);
            }
            //判断是否存在子菜单
            if ($sub_menus = data_get($sub_menu, 'subs', [])) {
                //新增有子菜单样式
                $content .= '<div data-kt-menu-trigger="'.$triggers.'" data-kt-menu-placement="'.$placement.'" class="menu-item menu-lg-down-accordion menu-obj" data-did="'.$sub_menu['id'].'" data-menu-type="item" data-parent-did="'.$sub_menu['parent_id'].'">
                            <span class="menu-link py-3 '.($sub_menu['pulse_theme'] ? 'pulse pulse-'.$sub_menu['pulse_theme'] : '').'" data-route-name="'.$sub_menu['route_name'].'" data-parent-did="'.$sub_menu['parent_id'].'" data-redirect-uri="'.$sub_menu['redirect_uri'].'" data-sub-count="0" href="'.$sub_menu['redirect_uri'].'" data-did="'.$sub_menu['id'].'">
                                '.(!empty($sub_menu['icon']) ? ' <span class="menu-icon"><i class="'.$sub_menu['icon'].'"></i></span>' : ' <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>').'
                                <span class="menu-title">
                                '.$sub_menu['guard_name'].((int)data_get($sub_menu, 'number', 0) > 0 ? (' <span class="badge badge-light-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' bg-hover-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' badge-circle fw-bold fs-9 px-2 ms-2">'.(int)data_get($sub_menu, 'number', 0).'</span>') : '').'
                                </span>
                                <span class="menu-arrow"></span>
                                '.($sub_menu['pulse_theme'] ? ' <span class="pulse-ring"></span>' : '').'
                            </span>';
                //继续追加样式
                $content .= self::km8($sub_menu, $customs, $triggers, $placement).'</div>';
            } else {
                //新增无子菜单样式
                $content .= '<div class="menu-item menu-obj" data-did="'.$sub_menu['id'].'" data-menu-type="item" data-parent-did="'.$sub_menu['parent_id'].'">
                            <a class="menu-link py-3 '.($sub_menu['pulse_theme'] ? 'pulse pulse-'.$sub_menu['pulse_theme'] : '').'" data-menu-type="link" href="'.$sub_menu['redirect_uri'].'"  data-route-name="'.$sub_menu['route_name'].'" data-parent-did="'.$sub_menu['parent_id'].'" data-redirect-uri="'.$sub_menu['redirect_uri'].'" data-sub-count="0" href="'.$sub_menu['redirect_uri'].'" data-did="'.$sub_menu['id'].'">
                                '.(!empty($sub_menu['icon']) ? ' <span class="menu-icon"><i class="'.$sub_menu['icon'].'"></i></span>' : ' <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>').'
                                <span class="menu-title">
                               '.$sub_menu['guard_name'].((int)data_get($sub_menu, 'number', 0) > 0 ? (' <span class="badge badge-light-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' bg-hover-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' badge-circle fw-bold fs-9 px-2 ms-2">'.(int)data_get($sub_menu, 'number', 0).'</span>') : '').'
                                </span>
                                 '.($sub_menu['pulse_theme'] ? ' <span class="pulse-ring"></span>' : '').'
                            </a>
                        </div>';
            }
        }
        //添加末尾标签
        $content .= '</div>';
        //返回html
        return $content;
    }

}
