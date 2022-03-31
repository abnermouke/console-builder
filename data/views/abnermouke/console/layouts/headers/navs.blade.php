<div class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0" id="kt_header_navs" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_navs_toggle" data-kt-swapper="true" data-kt-swapper-mode="append" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header'}">
    <div class="d-lg-flex container-xxl w-100">
        <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">
            @if(\Abnermouke\EasyBuilder\Library\Currency\DeviceLibrary::pc())
                <div class="tab-content" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: false}" data-kt-scroll-height="auto" data-kt-scroll-offset="70px">
                    @foreach((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('menus', []) as $menu)
                        @if(data_get($menu, 'subs', []))
                            <div class="tab-pane fade" id="kt_header_navs_tab_{{ $menu['id'] }}">
                                <div class="header-menu flex-column align-items-stretch flex-lg-row">
                                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold align-items-stretch flex-grow-1" id="#kt_header_menu" data-kt-menu="true">
                                        @foreach($menu['subs'] as $sub_menu)
                                            @php
                                                if ((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', []) && isset((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])[$sub_menu['alias']])) {
                                                    $sub_menu = array_merge($sub_menu, (new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])[$sub_menu['alias']]);
                                                }
                                            @endphp
                                            @if(data_get($sub_menu, 'subs', []))
                                                <div data-kt-menu-trigger="{{ config('console_builder.menus.trigger') }}" data-kt-menu-placement="{{ config('console_builder.menus.placement') }}" class="menu-item menu-lg-down-accordion me-lg-1 menu-obj" data-did="{{ $sub_menu['id'] }}" data-menu-type="tab" data-parent-did="{{ $sub_menu['parent_id'] }}"  data-redirect-uri="{{ $sub_menu['redirect_uri'] ? $sub_menu['redirect_uri'] : 'javascript:;' }}" data-guard-name="{{ $sub_menu['guard_name'] }}">
                                                    <span class="menu-link py-3 @if($sub_menu['pulse_theme']) pulse pulse-{{ $sub_menu['pulse_theme'] }} @endif" data-route-name="{{ $sub_menu['route_name'] }}" data-parent-did="{{ $sub_menu['parent_id'] }}" data-redirect-uri="{{ $sub_menu['redirect_uri'] }}" data-sub-count="{{ count($sub_menu['subs']) }}" href="{{ $sub_menu['redirect_uri'] }}"  data-did="{{ $sub_menu['id'] }}">
                                                        {!! (!empty($sub_menu['icon']) ? ' <span class="menu-icon"><i class="'.$sub_menu['icon'].'"></i></span>' : '') !!}
                                                        <span class="menu-title">
                                                            {{ $sub_menu['guard_name'] }}
                                                            @if((int)data_get($sub_menu, 'number', 0) > 0)
                                                                <span class="badge badge-light-{{ $sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary' }} badge-circle fw-bold fs-9 px-2 ms-2">{{ (int)data_get($sub_menu, 'number', 0) }}</span>
                                                            @endif
                                                        </span>
                                                        <span class="menu-arrow d-lg-none"></span>
                                                        @if($sub_menu['pulse_theme'])
                                                            <span class="pulse-ring"></span>
                                                        @endif
                                                    </span>
                                                    {!! \App\Builders\Abnermouke\Console\ConsoleBuilderMenuTemplateTool::km8($sub_menu, (new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])) !!}
                                                </div>
                                                @else
                                                <div class="menu-item me-lg-1 menu-obj" data-did="{{ $sub_menu['id'] }}" data-menu-type="tab" data-parent-did="{{ $sub_menu['parent_id'] }}" data-redirect-uri="{{ $sub_menu['redirect_uri'] ? $sub_menu['redirect_uri'] : 'javascript:;' }}" data-guard-name="{{ $sub_menu['guard_name'] }}">
                                                    <a class="menu-link py-3 @if($sub_menu['pulse_theme']) pulse pulse-{{ $sub_menu['pulse_theme'] }} @endif" data-menu-type="link" data-route-name="{{ $sub_menu['route_name'] }}" data-parent-did="{{ $sub_menu['parent_id'] }}" data-redirect-uri="{{ $sub_menu['redirect_uri'] }}" data-sub-count="0" href="{{ $sub_menu['redirect_uri'] }}" data-did="{{ $sub_menu['id'] }}">
                                                        {!! (!empty($sub_menu['icon']) ? ' <span class="menu-icon"><i class="'.$sub_menu['icon'].'"></i></span>' : '') !!}
                                                        <span class="menu-title">
                                                            {{ $sub_menu['guard_name'] }}
                                                            @if((int)data_get($sub_menu, 'number', 0) > 0)
                                                                <span class="badge badge-light-{{ $sub_menu['number_theme'] ? $sub_menu['number_theme'] : 'primary' }} badge-circle fw-bold fs-9 px-2 ms-2">{{ (int)data_get($sub_menu, 'number', 0) }}</span>
                                                            @endif
                                                        </span>
                                                        @if($sub_menu['pulse_theme'])
                                                            <span class="pulse-ring"></span>
                                                        @endif
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
            @endif
        </div>
    </div>
</div>

