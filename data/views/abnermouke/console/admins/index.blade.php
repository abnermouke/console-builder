{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '管理团队')

{{--是否显示侧边栏--}}
@section('enable_aside', 0)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
        ($builder = new \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder(route('abnermouke.console.admins.lists'), \App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::TABLE_WITH_KM8))
        ->addButton($builder->buildBotton()->form(route('abnermouke.console.admins.detail', ['id' => 0]), 'post')->text('新增管理员')->icon('fa fa-plus'))
        ->setFields(function () use ($builder) {
            return ($fieldBuilder = new \Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableFieldsBuilder())
                ->addField($fieldBuilder->buildString('id', '#')->bold())
                ->addField($fieldBuilder->buildProject('project', '管理员信息')->thumb('__AVATAR__')->template('{nickname}')->description('电话：{mobile}，邮箱：{email}'))
                ->addField($fieldBuilder->buildString('role_name', '权限角色')->bold()->theme('primary'))
                ->addField($fieldBuilder->buildString('wechat_open_id', '微信授权ID')->bold()->show(false))
                ->addField($fieldBuilder->buildString('login_count', '累计登录次数')->number()->theme('info')->show(false))
                ->addField($fieldBuilder->buildOption('status', '状态')->options(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__status__'])->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_STATUS_THEME))
                ->addField($fieldBuilder->buildDate('created_at', '创建时间')->format()->show(false))
                ->addField($fieldBuilder->buildDate('updated_at', '更新时间')->friendly());
        })
        ->addFilter($builder->filterAsSelect()->field('status')->guard_name('状态')->options(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__status__'])->col(3))
        ->addFilter($builder->filterAsSelect()->field('role_id')->guard_name('权限角色')->options(array_column((new \App\Repository\Abnermouke\Console\RoleRepository())->get([], ['id', 'guard_name']), 'guard_name', 'id'))->col(3))
        ->addFilter($builder->filterAsInput()->field('__keyword__')->guard_name('关键词搜索')->placeholder('请输入ID/用户名/昵称/手机号码/邮箱等关键词检索')->col(6))
        ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('created_at')->guard_name('创建时间'))
        ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('updated_at')->guard_name('更新时间'))
        ->addAction($builder->buildAction()->form(route('abnermouke.console.admins.detail', ['id' => '__ID__']), 'post')->text('编辑信息')->icon('fa fa-edit'))
        ->addAction($builder->buildAction()->modal('admin_wechat_oauth_qrcode_modal', ((int)(new \App\Handler\Cache\Data\Abnermouke\Console\ConfigCacheHandler())->get('CONSOLE_WECHAT_OAUTH') === \App\Model\Abnermouke\Console\Configs::SWITCH_ON ? route('abnermouke.console.admins.qrcode', ['id' => '__ID__']) : ''), 'post')->text('微信授权码')->icon('fa fa-qrcode')->theme('info'))
        ->addAction($builder->buildAction()->ajax(route('abnermouke.console.admins.status', ['id' => '__ID__']), 'post')->text('更改状态')->icon('fa fa-exchange-alt')->confirm_before_query('更改状态后，原本已禁用账户将重新开放，启用中的用户将禁止使用，是否继续?')->theme('success'))
        ->addSort('login_count', '登录次数')
        ->render()
    !!}
@endsection

{{--自定义弹窗--}}
@section('popups')
    <div class="modal fade acb_table_form_modal" id="admin_wechat_oauth_qrcode_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-dialog mw-650px">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal" id="admin_wechat_oauth_qrcode_modal_close_icon">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--自定义javascript--}}
@section('script')

@endsection
