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
                $content .= '<div data-kt-menu-trigger="'.$triggers.'" data-kt-menu-placement="'.$placement.'" class="menu-item menu-lg-down-accordion menu-obj" data-did="'.$sub_menu['id'].'" data-menu-type="item" data-parent-did="'.$sub_menu['parent_id'].'" data-redirect-uri="'.($sub_menu['redirect_uri'] ? $sub_menu['redirect_uri'] : 'javascript:;').'" data-guard-name="'.$sub_menu['guard_name'].'">
                            <span class="menu-link py-3 '.(isset($sub_menu['pulse_theme']) ? 'pulse pulse-'.$sub_menu['pulse_theme'] : '').'" data-route-names="'.implode(',', $sub_menu['permission_nodes']).'" data-parent-did="'.$sub_menu['parent_id'].'" data-redirect-uri="'.$sub_menu['redirect_uri'].'" data-sub-count="0" href="'.$sub_menu['redirect_uri'].'" data-did="'.$sub_menu['id'].'">
                                '.(!empty($sub_menu['icon']) ? ' <span class="menu-icon"><i class="'.$sub_menu['icon'].'"></i></span>' : ' <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>').'
                                <span class="menu-title">
                                '.$sub_menu['guard_name'].((int)data_get($sub_menu, 'number', 0) > 0 ? (' <span class="badge badge-light-'.(isset($sub_menu['number_theme']) ? $sub_menu['number_theme'] : 'primary').' bg-hover-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' badge-circle fw-bold fs-9 px-2 ms-2">'.(int)data_get($sub_menu, 'number', 0).'</span>') : '').'
                                </span>
                                <span class="menu-arrow"></span>
                                '.(isset($sub_menu['pulse_theme']) ? ' <span class="pulse-ring"></span>' : '').'
                            </span>';
                //继续追加样式
                $content .= self::km8($sub_menu, $customs, $triggers, $placement).'</div>';
            } else {
                //新增无子菜单样式
                $content .= '<div class="menu-item menu-obj" data-did="'.$sub_menu['id'].'" data-menu-type="item" data-parent-did="'.$sub_menu['parent_id'].'"  data-redirect-uri="'.($sub_menu['redirect_uri'] ? $sub_menu['redirect_uri'] : 'javascript:;').'" data-guard-name="'.$sub_menu['guard_name'].'">
                            <a class="menu-link py-3 '.(isset($sub_menu['pulse_theme']) ? 'pulse pulse-'.$sub_menu['pulse_theme'] : '').'" data-menu-type="link" href="'.$sub_menu['redirect_uri'].'"  data-route-names="'.implode(',', $sub_menu['permission_nodes']).'" data-parent-did="'.$sub_menu['parent_id'].'" data-redirect-uri="'.$sub_menu['redirect_uri'].'" data-sub-count="0" href="'.$sub_menu['redirect_uri'].'" data-did="'.$sub_menu['id'].'">
                                '.(!empty($sub_menu['icon']) ? ' <span class="menu-icon"><i class="'.$sub_menu['icon'].'"></i></span>' : ' <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>').'
                                <span class="menu-title">
                               '.$sub_menu['guard_name'].((int)data_get($sub_menu, 'number', 0) > 0 ? (' <span class="badge badge-light-'.(isset($sub_menu['number_theme']) ? $sub_menu['number_theme'] : 'primary').' bg-hover-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' badge-circle fw-bold fs-9 px-2 ms-2">'.(int)data_get($sub_menu, 'number', 0).'</span>') : '').'
                                </span>
                                 '.(isset($sub_menu['pulse_theme']) ? ' <span class="pulse-ring"></span>' : '').'
                            </a>
                        </div>';
            }
        }
        //添加末尾标签
        $content .= '</div>';
        //返回html
        return $content;
    }

    /**
     * km8主题递归侧边栏html
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-03 23:00:28
     * @param $menu array 菜单信息
     * @param array $customs array 自定义替换信息
     * @param string $trigger
     * @return string
     */
    public static function km8_aside($menu, $customs = [], $trigger = 'click')
    {
        //整理基础模版
        $content = '';
        //循环子菜单
        foreach ($menu['subs'] as $sub_menu) {
            //处理菜单信息
            if ($customs && isset($customs[$sub_menu['alias']])) {
                //替换信息
                $sub_menu = array_merge($sub_menu, $customs[$sub_menu['alias']]);
            }
            //判断是否存在子菜单
            if ($sub_menus = data_get($sub_menu, 'subs', [])) {
                //添加内容
                $content .= '<div data-kt-menu-trigger="'.$trigger.'" class="menu-item menu-accordion aside-obj"  data-route-name="'.$menu['route_name'].'" data-did="'.$sub_menu['id'] .'" data-menu-type="accordion" data-parent-did="'.$sub_menu['parent_id'].'">
                                <span class="menu-link '.(isset($sub_menu['pulse_theme']) ? 'pulse pulse-'.$sub_menu['pulse_theme'] : '').'">
                                    '.(!empty($sub_menu['icon']) ? '<span class="menu-icon"><span class="svg-icon svg-icon-2"><i class="'.$sub_menu['icon'].' fs-3"></i></span></span>' : '').'
                                    <span class="menu-title">
                                        '.$sub_menu['guard_name'].((int)data_get($sub_menu, 'number', 0) > 0 ? (' <span class="badge badge-light-'.(isset($sub_menu['number_theme']) ? $sub_menu['number_theme'] : 'primary').' bg-hover-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' badge-circle fw-bold fs-9 px-2 ms-2">'.(int)data_get($sub_menu, 'number', 0).'</span>') : '').'
                                    </span>
                                    '.(isset($sub_menu['pulse_theme']) ? ' <span class="pulse-ring"></span>' : '').'
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion menu-active-bg">';
                //追加样式
                $content .= self::km8_aside($sub_menu, $customs, $trigger).'</div></div>';
            } else {
                //添加内容
                $content .= '<div class="menu-item aside-obj" data-route-name="'.$menu['route_name'].'" data-did="'.$sub_menu['id'] .'" data-menu-type="item" data-parent-did="'.$sub_menu['parent_id'].'">
                                <a class="menu-link '.(isset($sub_menu['pulse_theme']) ? 'pulse pulse-'.$sub_menu['pulse_theme'] : '').'" href="'.$sub_menu['redirect_uri'].'">
                                    '.(!empty($sub_menu['icon']) ? '<span class="menu-icon"><span class="svg-icon svg-icon-2"><i class="'.$sub_menu['icon'].' fs-3"></i></span></span>' : '').'
                                    <span class="menu-title">
                                        '.$sub_menu['guard_name'].((int)data_get($sub_menu, 'number', 0) > 0 ? (' <span class="badge badge-light-'.(isset($sub_menu['number_theme']) ? $sub_menu['number_theme'] : 'primary').' bg-hover-'.($sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary').' badge-circle fw-bold fs-9 px-2 ms-2">'.(int)data_get($sub_menu, 'number', 0).'</span>') : '').'
                                    </span>
                                    '.(isset($sub_menu['pulse_theme']) ? ' <span class="pulse-ring"></span>' : '').'
                                </a>
                            </div>';
            }
        }
        //返回html
        return $content;
    }

}
