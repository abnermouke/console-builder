{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '管理团队操作记录')

{{--是否显示侧边栏--}}
@section('enable_aside', 0)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
        ($builder = new \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder(route('abnermouke.console.admins.logs.lists'), \App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::TABLE_WITH_KM8))
        ->setFields(function () use ($builder) {
            return ($fieldBuilder = new \Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableFieldsBuilder())
                ->addField($fieldBuilder->buildTexts('texts', '管理员信息')->template('{content}')->description('{nickname}'))
                ->addField($fieldBuilder->buildString('ip', '操作IP')->bold()->theme('primary'))
                ->addField($fieldBuilder->buildDate('created_at', '创建时间')->format('Y-m-d H:i:s'));
        })
        ->addFilter($builder->filterAsInput()->field('__keyword__')->guard_name('关键词搜索')->placeholder('请输入管理员昵称/用户名/操作内容等关键词检索')->col(8))
        ->addFilter($builder->filterAsSelect()->field('admin_id')->guard_name('管理员')->options(array_column((new \App\Repository\Abnermouke\Console\AdminRepository())->get([], ['id', 'nickname']), 'nickname', 'id'))->col(4))
        ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('created_at')->guard_name('创建时间')->col(6))
        ->render()
    !!}
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
