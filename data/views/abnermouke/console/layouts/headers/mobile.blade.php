<div class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0 drawer drawer-start" id="kt_header_navs" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_navs_toggle" data-kt-swapper="true" data-kt-swapper-mode="append" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header'}" style="width: 250px !important;">
    <div class="d-lg-flex container-xxl w-100">
        <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">
            <div class="header-tabs overflow-auto mx-4 ms-lg-10 mb-5 mb-lg-0" id="kt_header_tabs" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
                <ul class="nav flex-nowrap text-nowrap" id="menu_tops">
                    @foreach((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('menus', []) as $menu)
                        <li class="nav-item">
                            <a class="nav-link menu-top" data-route-name="{{ $menu['route_name'] }}" data-parent-did="{{ $menu['parent_id'] }}" data-redirect-uri="{{ $menu['redirect_uri'] }}" data-sub-count="{{ count(data_get($menu, 'subs', [])) }}" data-bs-toggle="tab" href="#kt_header_navs_tab_{{ $menu['id'] }}">{{ $menu['guard_name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-content" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: false}" data-kt-scroll-height="auto" data-kt-scroll-offset="70px">
                @foreach((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('menus', []) as $menu)
                    @if(data_get($menu, 'subs', []))
                        {{-- add class: active show--}}
                        <div class="tab-pane fade active show" id="kt_header_navs_tab_{{ $menu['id'] }}">
                            <div class="header-menu flex-column align-items-stretch flex-lg-row">
                                <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold align-items-stretch flex-grow-1" id="#kt_header_menu" data-kt-menu="true">
                                    @foreach($menu['subs'] as $sub_menu)
                                        @if(data_get($sub_menu, 'subs', []))
                                            <div data-kt-menu-trigger="{{ config('console_builder.menus.trigger') }}" data-kt-menu-placement="{{ config('console_builder.menus.placement') }}" class="menu-item menu-lg-down-accordion me-lg-1">
                                                    <span class="menu-link py-3" data-route-name="{{ $sub_menu['route_name'] }}" data-parent-did="{{ $sub_menu['parent_id'] }}" data-redirect-uri="{{ $sub_menu['redirect_uri'] }}" data-sub-count="{{ count($sub_menu['subs']) }}" href="{{ $sub_menu['redirect_uri'] }}">
                                                        <span class="menu-title">{{ $sub_menu['guard_name'] }}</span>
                                                        <span class="menu-arrow d-lg-none"></span>
                                                    </span>
                                                {!! \App\Builders\Abnermouke\Console\ConsoleBuilderMenuTemplateTool::km8($sub_menu) !!}
                                            </div>
                                        @else
                                            <div class="menu-item me-lg-1">
                                                <a class="menu-link py-3" data-route-name="{{ $sub_menu['route_name'] }}" data-parent-did="{{ $sub_menu['parent_id'] }}" data-redirect-uri="{{ $sub_menu['redirect_uri'] }}" data-sub-count="0" href="{{ $sub_menu['redirect_uri'] }}">
                                                    <span class="menu-title">菜单1</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
