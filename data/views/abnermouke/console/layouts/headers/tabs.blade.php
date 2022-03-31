<div class="align-self-end overflow-auto" id="kt_brand_tabs">
    @if(\Abnermouke\EasyBuilder\Library\Currency\DeviceLibrary::pc())
        <div class="header-tabs overflow-auto mx-4 ms-lg-10 mb-5 mb-lg-0" id="kt_header_tabs" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
            <ul class="nav flex-nowrap text-nowrap" id="menu_tops">
                @foreach((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('menus', []) as $menu)
                    @php
                        if ((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', []) && isset((new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])[$menu['alias']])) {
                            $menu = array_merge($menu, (new \App\Handler\Cache\Data\Abnermouke\Console\MenuCacheHandler())->get('customs', [])[$menu['alias']]);
                        }
                    @endphp
                    <li class="nav-item menu-obj" data-menu-type="nav" data-did="{{ $menu['id'] }}" data-redirect-uri="{{ $menu['redirect_uri'] ? $menu['redirect_uri'] : 'javascript:;' }}" data-guard-name="{{ $menu['guard_name'] }}">
                        <a class="nav-link" data-route-name="{{ $menu['route_name'] }}" data-parent-did="{{ $menu['parent_id'] }}" data-redirect-uri="{{ $menu['redirect_uri'] }}" data-sub-count="{{ count(data_get($menu, 'subs', [])) }}" data-bs-toggle="tab" href="#kt_header_navs_tab_{{ $menu['id'] }}">
                            {!! (!empty($menu['icon']) ? '<i class="'.$menu['icon'].'"></i> ' : '') !!}{{ $menu['guard_name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
