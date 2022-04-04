{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '菜单配置')

{{--是否显示侧边栏--}}
@section('enable_aside', 1)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    @foreach($menus as $menu)
        <div class="card mb-5 mb-xl-10">
            <div class="card-header">
                <div class="card-title">
                    <h3>{{ $menu['guard_name'] }}</h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-info me-2 menu_trigger_insert" data-query-url="{{ route('abnermouke.console.menus.detail', ['parent_id' => $menu['id'], 'id' => 0]) }}">添加子菜单</button>
                    <button type="button" class="btn btn-sm btn-primary me-2 menu_trigger_edit" data-query-url="{{ route('abnermouke.console.menus.detail', ['parent_id' => $menu['parent_id'], 'id' => $menu['id']]) }}">编辑</button>
                    <button type="button" class="btn btn-sm btn-danger menu_trigger_delete" data-query-url="{{ route('abnermouke.console.menus.delete', ['id' => $menu['id']]) }}">删除</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row gx-9 gy-6">
                    @foreach(data_get($menu, 'sub_menus', []) as $sub)
                        <div class="col-xl-4">
                            <div class="card card-dashed border p-6">
                                <div class="d-flex align-items-center mb-8">
                                    <div class="flex-grow-1">
                                        <span class="text-gray-800 fw-bolder fs-6">{{ $sub['guard_name'] }}</span>
                                    </div>
                                    <span class="badge badge-light-info fs-8 fw-bolder cursor-pointer me-2 menu_trigger_insert" data-query-url="{{ route('abnermouke.console.menus.detail', ['parent_id' => $sub['id'], 'id' => 0]) }}">添加子菜单</span>
                                    <span class="badge badge-light-primary fs-8 fw-bolder cursor-pointer me-2 menu_trigger_edit" data-query-url="{{ route('abnermouke.console.menus.detail', ['parent_id' => $sub['parent_id'], 'id' => $sub['id']]) }}">编辑</span>
                                    <span class="badge badge-light-danger fs-8 cursor-pointer fw-bolder menu_trigger_delete" data-query-url="{{ route('abnermouke.console.menus.delete', ['id' => $sub['id']]) }}">删除</span>
                                </div>
                                <div class="h-lg-100px h-sm-auto overflow-auto">
                                    @foreach(data_get($sub, 'sub_menus', []) as $child)
                                        <div class="d-flex align-items-center mb-8">
                                            <div class="flex-grow-1">
                                                <span class="text-muted fw-bold d-block ps-{{ (int)$sub['level'] * 2 }}">{{ $child['guard_name'] }}</span>
                                            </div>
                                            <span class="badge badge-light-primary fs-8 fw-bolder cursor-pointer me-2 menu_trigger_edit" data-query-url="{{ route('abnermouke.console.menus.detail', ['parent_id' => $child['id'], 'id' => $child['id']]) }}">编辑</span>
                                            <span class="badge badge-light-danger fs-8 cursor-pointer fw-bolder menu_trigger_delete" data-query-url="{{ route('abnermouke.console.menus.delete', ['id' => $child['id']]) }}">删除</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
    <div id="menu_trigger_buttons" class="d-none">
        <button class="btn btn-sm btn-primary me-3 menu_trigger_buttons menu_trigger_insert" id="menu_trigger_insert_button"  data-query-url="{{ route('abnermouke.console.menus.detail', ['parent_id' => 0, 'id' => 0]) }}">添加顶部菜单</button>
    </div>
    <div class="modal fade" id="menu_trigger_modal" data-source-path="{{ proxy_assets('themes/km8/js/builder', 'abnermouke') }}">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-5">
                    <h5 class="modal-title">菜单信息</h5>
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2 acb_table_form_modal_close_icon" data-bs-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body mh-700px overflow-auto"></div>
            </div>
        </div>
    </div>
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')
    <script src="{{ proxy_assets('themes/km8/pages/menus/js/index.js', 'abnermouke') }}"></script>
@endsection
