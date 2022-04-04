<div id="kt_aside" class="aside card d-none" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle" data-kt-sticky="true" data-kt-sticky-name="aside-sticky" data-kt-sticky-offset="{default: false, lg: '50px'}" data-kt-sticky-release-offset="{lg: '100px'}" data-kt-sticky-width="{lg: '265px'}" data-kt-sticky-left="auto" data-kt-sticky-top="135px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95" data-kt-sticky-released="true">
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-2 my-lg-3" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_footer', lg: '#kt_header, #kt_aside_footer, #kt_footer'}" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                @foreach((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('menus', []) as $menu)
                    @php
                        if ((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', []) && isset((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])[$menu['alias']])) {
                            $menu = array_merge($menu, (new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])[$menu['alias']]);
                        }
                    @endphp
                    @if($menu['redirect_uri'])
                        <div class="menu-item aside-obj" data-did="{{ $menu['id'] }}" data-route-name="{{ $menu['route_name'] }}" data-menu-type="section" data-parent-did="{{ $menu['parent_id'] }}">
                            <a class="menu-link" href="{{ $menu['redirect_uri'] }}" title="{{ $menu['guard_name'] }}">
                                @if(!empty($menu['icon']))
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="$menu['icon'] fs-3"></i>
                                        </span>
                                    </span>
                                @endif
                                <span class="menu-title">{{ $menu['guard_name'] }}</span>
                            </a>
                        </div>
                    @else
                        <div class="menu-content px-7 pt-5 pb-3 aside-obj" data-did="{{ $menu['id'] }}" data-route-name="{{ $menu['route_name'] }}" data-menu-type="section" data-parent-did="{{ $menu['parent_id'] }}">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $menu['guard_name'] }}</span>
                        </div>
                    @endif
                    {!! \Abnermouke\ConsoleBuilder\Builders\ConsoleBuilderMenuTemplateTool::km8_aside($menu, (new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])) !!}
                @endforeach
            </div>
        </div>
    </div>
</div>
