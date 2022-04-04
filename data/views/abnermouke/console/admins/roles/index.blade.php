{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '管理员角色')

{{--是否显示侧边栏--}}
@section('enable_aside', 0)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
            ($builder = new \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder(route('abnermouke.console.admins.roles.lists'), \App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::TABLE_WITH_KM8))
            ->addButton($builder->buildBotton()->form(route('abnermouke.console.admins.roles.detail', ['id' => 0]), 'post')->text('添加权限角色')->icon('fa fa-plus'))
            ->addButton($builder->buildBotton()->ajax(route('abnermouke.console.admins.roles.delete'), 'post')->text('删除选中')->icon('fa fa-trash')->theme('danger')->id_suffix('delete_selected')->confirm_before_query('请确认该角色无人绑定，否则将删除失败，是否继续？'))
            ->setCheckbox('id', ['delete_selected'])
            ->setFields(function () use ($builder) {
                return ($fieldBuilder = new \Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableFieldsBuilder())
                    ->addField($fieldBuilder->buildTexts('texts', '权限角色')->template('{guard_name}')->description('{alias}')->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_SWITCH_THEME, 'is_full_permission'))
                    ->addField($fieldBuilder->buildOption('is_locked', '是否锁定')->options(\App\Model\Abnermouke\Console\Roles::TYPE_GROUPS['__switch__'])->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_SWITCH_THEME))
                    ->addField($fieldBuilder->buildOption('is_full_permission', '是否满权限')->options(\App\Model\Abnermouke\Console\Roles::TYPE_GROUPS['__switch__'])->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_SWITCH_THEME))
                    ->addField($fieldBuilder->buildAvatar('avatars', '绑定管理员'))
                    ->addField($fieldBuilder->buildDate('created_at', '创建时间')->format('Y-m-d H:i:s')->show(false))
                    ->addField($fieldBuilder->buildDate('updated_at', '更新时间')->format('Y-m-d H:i:s'));
            })
            ->addFilter($builder->filterAsInput()->field('__keyword__')->guard_name('关键词搜索')->placeholder('请输入权限角色名称/标识等关键词检索'))
            ->addFilter($builder->filterAsSwitch()->field('is_locked')->guard_name('锁定')->on(\App\Model\Abnermouke\Console\Roles::SWITCH_ON)->off(\App\Model\Abnermouke\Console\Roles::SWITCH_OFF))
            ->addFilter($builder->filterAsSwitch()->field('is_full_permission')->guard_name('满权限角色')->on(\App\Model\Abnermouke\Console\Roles::SWITCH_ON)->off(\App\Model\Abnermouke\Console\Roles::SWITCH_OFF))
            ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('created_at')->guard_name('创建时间'))
            ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('updated_at')->guard_name('编辑时间'))
            ->addAction($builder->buildAction()->form(route('abnermouke.console.admins.roles.detail', ['id' => '__ID__']), 'post')->text('编辑信息')->icon('fa fa-edit'))
            ->addAction($builder->buildAction()->url(route('abnermouke.console.admins.roles.nodes.index', ['id' => '__ID__']), [], 'get')->text('配置权限')->icon('fa fa-cogs'))
            ->render()
        !!}
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
