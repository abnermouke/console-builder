{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '管理员权限节点')

{{--是否显示侧边栏--}}
@section('enable_aside', 1)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
        ($builder = (new \Abnermouke\ConsoleBuilder\Builders\Form\ConsoleFormBuilder()))
            ->setTitle($role['guard_name'], '<span class="badge badge-light-primary me-3">ID：'.$role['id'].'</span><span class="badge badge-light-danger me-3">角色标识：'.$role['alias'].'</span><span class="badge badge-light-info me-3">'.((int)$role['is_full_permission'] === \App\Model\Abnermouke\Console\Roles::SWITCH_ON ? '满权限' : '自定义权限').'</span><span class="badge badge-light-warning me-3">'.((int)$role['is_locked'] === \App\Model\Abnermouke\Console\Roles::SWITCH_ON ? '已锁定' : '未锁定').'</span><span class="badge badge-light-dark me-3">绑定管理员数量：'.$role['admin_count'].'</span>')
            ->submit($builder->buildButton()->title('确认配置节点')->ajax(route('abnermouke.console.admins.roles.nodes.store', ['id' => (int)$role['id']]), 'post', \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormButtonBuilder::AJAX_AFTER_BACK)->confirm_before_query('节点配置成功后将立即生效，确认继续？'))
            ->back($builder->buildButton()->title('返回列表')->url(route('abnermouke.console.admins.roles.index'))->theme('info'))
            ->setItems(function () use ($groups, $aliases) {
                return ($formItemBuilder = (new \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormItemsBuilder()))
                    ->addItem($formItemBuilder->buildCheckbox('aliases', '权限节点')->options_with_groups($groups));
            })
            ->setData(['aliases' => $aliases])
            ->render()
    !!}
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
