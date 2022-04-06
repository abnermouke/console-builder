{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '帮助文档')

{{--是否显示侧边栏--}}
@section('enable_aside', 0)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
        ($builder = new \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder(route('abnermouke.console.help.docs.lists'), \App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::TABLE_WITH_KM8))
        ->addButton($builder->buildBotton()->form(route('abnermouke.console.help.docs.detail', ['id' => 0]), 'post')->text('新增文档')->icon('fa fa-plus'))
        ->addButton($builder->buildBotton()->ajax(route('abnermouke.console.help.docs.delete'), 'post')->text('删除选中文档')->icon('fa fa-trash')->theme('danger')->id_suffix('delete_selected')->confirm_before_query('帮助文档删除后不可恢复，是否继续？'))
        ->setFields(function () {
            return ($fieldBuilder = new \Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableFieldsBuilder())
                ->addField($fieldBuilder->buildTexts('project', '文档信息')->bold()->template('{title}')->description('{description}'))
                ->addField($fieldBuilder->buildString('alias', '标识')->bold()->theme('primary'))
                ->addField($fieldBuilder->buildOption('type', '文档类型')->bold()->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_STATUS_THEME)->options(\App\Model\Abnermouke\Console\HelpDocs::TYPE_GROUPS['type']))
                 ->addField($fieldBuilder->buildDate('created_at', '创建时间')->show(false))
                ->addField($fieldBuilder->buildDate('updated_at', '更新时间')->friendly());
        })
        ->addFilter($builder->filterAsInput()->field('__keyword__')->guard_name('关键词搜索')->placeholder('请输入标题/标识/内容等关键词检索')->col(6))
        ->addFilter($builder->filterAsSelect()->field('type')->guard_name('文档类型')->options(\App\Model\Abnermouke\Console\HelpDocs::TYPE_GROUPS['type'])->col(6))
        ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('created_at')->guard_name('创建时间'))
        ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('updated_at')->guard_name('更新时间'))
        ->addAction($builder->buildAction()->form(route('abnermouke.console.help.docs.detail', ['id' => '__ID__']), 'post')->text('编辑文档')->icon('fa fa-edit'))
        ->setCheckbox('id', ['delete_selected'])
        ->render()
    !!}
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
