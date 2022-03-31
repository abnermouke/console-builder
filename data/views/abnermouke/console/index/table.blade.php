{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '表格构建器')

{{--是否显示侧边栏--}}
@section('enable_aside', 1)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
        ($builder = (new \App\Builders\Abnermouke\Console\Table\ConsoleTableBuilder(route('abnermouke.console.table'))))
        ->addButton($builder->buildBotton()->text('创建信息')->url(route('abnermouke.console.oauth.index'), 'get')->icon('la la-plus')->id_suffix('create_new_one')->confirm_before_query('是否确定需要创建新信息？'))
        ->addButton($builder->buildBotton()->text('导出信息')->theme('info')->url(route('abnermouke.console.index'), 'get', true)->icon('la la-file-export', true)->id_suffix('export'))
        ->addButton($builder->buildBotton()->text('删除选中')->theme('danger')->ajax(route('abnermouke.console.delete'), 'post', route('abnermouke.console.oauth.index'))->icon('la la-trash', true)->id_suffix('trash_selected')->confirm_before_query('是否确认删除您选中的记录？'))
        ->setCheckbox('id', ['trash_selected'])
        ->setFields(function () use ($builder) {
            return ($fieldBuilder = new \App\Builders\Abnermouke\Console\Table\Tools\TableFieldsBuilder())
            ->addField($fieldBuilder->buildTexts('texts', '双文本')->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_STATUS_THEME, 'is_locked')->template('{guard_name}')->description('{alias}'))
            ->addField($fieldBuilder->buildProject('project', '项目')->template('{guard_name}')->description('ID：{id}')->show(false))
            ->addField($fieldBuilder->buildAvatar('friends', '朋友')->description('Team Member')->show(false))
            ->addField($fieldBuilder->buildRating('is_locked', '评分')->description('Rating')->show(false)->setFilter($builder->filterAsInput()->dialer(0, 5, 0.1, 1)))
            ->addField($fieldBuilder->buildOption('is_full_permission', '状态')->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_SWITCH_THEME)->options(\App\Model\Abnermouke\Console\Roles::TYPE_GROUPS['__switch__'])->show(false)->setFilter($builder->filterAsSelect()->options(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'])))
            ->addField($fieldBuilder->buildString('guard_name', '角色名称')->bold())
            ->addField($fieldBuilder->buildString('is_locked', '价格')->bold()->price(2, 100)->theme('danger'))
            ->addField($fieldBuilder->buildString('admin_count', '管理员数量')->number()->bold()->setFilter($builder->filterAsInput()->number(0, 100)))
            ->addField($fieldBuilder->buildDate('created_at', '时间')->format('Y-m-d H:i:s')->setFilter($builder->filterAsInput()->date('Y-m-d H:i:ss')))
            ->addField($fieldBuilder->buildDate('updated_at', '友好时间')->friendly());
        })
        ->addFilter($builder->filterAsInput()->tags()->field('tags')->guard_name('标签')->placeholder('请输入标签'))
        ->addFilter($builder->filterAsInput()->date_range()->field('ranges')->guard_name('时间区间'))
        ->addFilter($builder->filterAsGroup()->options(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'])->field('group')->guard_name('组合'))
        ->addFilter($builder->filterAsSwitch()->field('swicth')->guard_name('仅显示有货'))
        ->addAction($builder->buildAction()->text('编辑')->icon('la la-edit')->theme('primary')->form(route('abnermouke.console.index', ['id' => '__ID__', 'action' => 'form']), 'get', []))
        ->addAction($builder->buildAction()->text('删除')->icon('la la-trash')->theme('danger')->ajax(route('abnermouke.console.delete'), 'post', ['id'])->confirm_before_query('是否确认继续删除当前数据？'))
        ->render();
    !!}
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
