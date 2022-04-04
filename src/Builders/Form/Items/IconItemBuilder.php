<?php


namespace Abnermouke\ConsoleBuilder\Builders\Form\Items;

/**
 * icon图标选择构建器
 * Class IconItemBuilder
 * @package Abnermouke\ConsoleBuilder\Builders\Form\Items
 */
class IconItemBuilder extends BasicItemBuilder
{

    /**
     * 构造函数
     * IconItemBuilder constructor.
     * @param $field string 字段名
     * @param $guard_name string 显示名称
     * @throws \Exception
     */
    public function __construct($field, $guard_name)
    {
        //设置基础信息
        $this->setParam('type', 'icon')->field($field)->guard_name($guard_name)->options()->placeholder('请选择'.$guard_name)->value_type(BasicItemBuilder::VALUE_TYPE_OF_STRING);
    }

    /**
     * 设置占位符信息
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 00:36:02
     * @param string $placeholder
     * @return IconItemBuilder
     */
    public function placeholder($placeholder = '')
    {
        //设置占位符信息
        return $this->extra('placeholder', $placeholder);
    }

    /**
     * 设置选择项
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-23 01:00:36
     * @param int $default_value
     * @return IconItemBuilder
     * @throws \Exception
     */
    public function options($options = [], $default_value = '__WITHOUT_SELECTED_OPTION__')
    {
        //设置选项
        $options = $options ? $options : [
            '通用类' => explode(',', 'fa-adjust,fa-anchor,fa-archive,fa-file,fa-asterisk,fa-at,fa-ban,fa-barcode,fa-bars,fa-bed,fa-beer,fa-bell,fa-bell-slash,fa-bicycle,fa-binoculars,fa-birthday-cake,fa-bolt,fa-bomb,fa-book,fa-bookmark,fa-briefcase,fa-bug,fa-building,fa-bullhorn,fa-bullseye,fa-bus,fa-calculator,fa-calendar,fa-camera,fa-camera-retro,fa-car,fa-cart-arrow-down,fa-cart-plus,fa-certificate,fa-check,fa-check-circle,fa-check-square,fa-child,fa-circle,fa-cloud,fa-code,fa-coffee,fa-cog,fa-cogs,fa-comment,fa-comments,fa-compass,fa-copyright,fa-credit-card,fa-crop,fa-crosshairs,fa-cube,fa-cubes,fa-database,fa-desktop,fa-download,fa-edit,fa-ellipsis-h,fa-ellipsis-v,fa-envelope,fa-envelope-square,fa-eraser,fa-exclamation,fa-exclamation-circle,fa-exclamation-triangle,fa-eye,fa-eye-slash,fa-fax,fa-female,fa-fighter-jet,fa-film,fa-filter,fa-fire,fa-fire-extinguisher,fa-flag,fa-flag-checkered,fa-flask,fa-folder,fa-folder-open,fa-gamepad,fa-gavel,fa-genderless,fa-gift,fa-globe,fa-graduation-cap,fa-headphones,fa-heart,fa-heartbeat,fa-history,fa-home,fa-hotel,fa-image,fa-inbox,fa-info,fa-info-circle,fa-key,fa-language,fa-laptop,fa-leaf,fa-life-ring,fa-location-arrow,fa-lock,fa-magic,fa-magnet,fa-male,fa-map-marker,fa-microphone,fa-microphone-slash,fa-minus,fa-minus-circle,fa-minus-square,fa-motorcycle,fa-music,fa-paint-brush,fa-paper-plane,fa-paw,fa-phone,fa-phone-square,fa-plane,fa-plug,fa-plus,fa-plus-circle,fa-plus-square,fa-power-off,fa-print,fa-puzzle-piece,fa-qrcode,fa-question,fa-question-circle,fa-quote-left,fa-quote-right,fa-random,fa-recycle,fa-reply,fa-reply-all,fa-retweet,fa-road,fa-rocket,fa-rss,fa-rss-square,fa-search,fa-search-minus,fa-search-plus,fa-server,fa-share,fa-share-alt,fa-share-alt-square,fa-share-square,fa-ship,fa-shopping-cart,fa-signal,fa-sitemap,fa-sort,fa-sort-down,fa-sort-up,fa-space-shuttle,fa-spinner,fa-square,fa-star,fa-street-view,fa-suitcase,fa-tablet,fa-tag,fa-tags,fa-tasks,fa-taxi,fa-terminal,fa-thumbs-down,fa-thumbs-up,fa-times,fa-times-circle,fa-tint,fa-toggle-off,fa-toggle-on,fa-trash,fa-tree,fa-trophy,fa-truck,fa-tty,fa-umbrella,fa-university,fa-unlock,fa-unlock-alt,fa-upload,fa-user,fa-user-plus,fa-user-secret,fa-user-times,fa-users,fa-volume-down,fa-volume-off,fa-volume-up,fa-wheelchair,fa-wifi,fa-wrench'),
            '运输工具' => explode(',', 'fa-ambulance,fa-car,fa-bicycle,fa-bus,fa-taxi,fa-fighter-jet,fa-motorcycle,fa-plane,fa-rocket,fa-ship,fa-space-shuttle,fa-subway,fa-train,fa-truck,fa-wheelchair'),
            '性别' => explode(',', 'fa-genderless,fa-mars,fa-mars-double,fa-mars-stroke,fa-mars-stroke-h,fa-mars-stroke-v,fa-mercury,fa-neuter,fa-transgender,fa-transgender-alt,fa-venus,fa-venus-double,fa-venus-mars'),
            '旋转加载' => explode(',', 'fa-cog,fa-spinner'),
            '表单控件' => explode(',', 'fa-check-square,fa-circle,fa-minus-square,fa-plus-square,fa-square'),
            '支付方式' => explode(',', 'fa-credit-card'),
            '文本编辑' => explode(',', 'fa-align-center,fa-align-justify,fa-align-left,fa-align-right,fa-bold,fa-font,fa-italic,fa-underline,fa-text-width,fa-text-height,fa-strikethrough,fa-subscript,fa-superscript,fa-link,fa-clipboard,fa-paste,fa-copy,fa-cut,fa-columns,fa-eraser,fa-save,fa-undo,fa-outdent,fa-indent,fa-list,fa-list-alt,fa-list-ol,fa-list-ul,fa-paperclip,fa-paragraph,fa-table,fa-th,fa-th-large,fa-th-list'),
            '方向性' => explode(',', 'fa-angle-double-down,fa-angle-double-left,fa-angle-double-right,fa-angle-double-up,fa-angle-down,fa-angle-left,fa-angle-right,fa-angle-up,fa-arrow-circle-down,fa-arrow-circle-left,fa-arrow-circle-right,fa-arrow-circle-up,fa-arrow-down,fa-arrow-left,fa-arrow-right,fa-arrow-up,fa-arrows-alt,fa-caret-down,fa-caret-left,fa-caret-right,fa-caret-up,fa-chevron-circle-down,fa-chevron-circle-left,fa-chevron-circle-right,fa-chevron-circle-up,fa-chevron-down,fa-chevron-left,fa-chevron-right,fa-chevron-up'),
            '播放器控件' => explode(',', 'fa-arrows-alt,fa-backward,fa-compress,fa-eject,fa-expand,fa-fast-backward,fa-fast-forward,fa-forward,fa-pause,fa-play,fa-play-circle,fa-step-backward,fa-step-forward,fa-stop,fa-volume-off,fa-volume-down,fa-volume-up,fa-random'),
            '医疗' => explode(',', 'fa-ambulance,fa-h-square,fa-heart,fa-heartbeat,fa-medkit,fa-plus-square,fa-stethoscope,fa-user-md,fa-wheelchair'),
        ];
        //设置选择项
        return $this->extra('options', $options)->default_value($default_value);
    }

}
