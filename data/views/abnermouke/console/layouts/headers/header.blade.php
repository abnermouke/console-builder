<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    <div class="header-top d-flex align-items-stretch flex-grow-1">
        <div class="d-flex container-xxl align-items-stretch">
            <div class="d-flex align-items-center align-items-lg-stretch me-5 flex-row-fluid">
                <button class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px ms-n2 me-2" id="kt_header_navs_toggle">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
                            <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
                        </svg>
                    </span>
                </button>
                <a href="{{ route('abnermouke.console.index') }}" class="d-flex align-items-center">
                    <img alt="Logo" src="{{ $console_configs['APP_LOGO'] }}" class="h-30px h-lg-30px" />
                </a>
                @include('abnermouke.console.layouts.headers.tabs')
            </div>
            <div class="d-flex align-items-center flex-row-auto">

                <div class="d-flex align-items-center ms-1">
                    <a href="javascript:;" class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px" data-bs-toggle="tooltip" data-bs-placement="bottom" title="刷新系统权限节点">
                        <i class="fonticon-repeat fs-2"></i>
                    </a>
                </div>
                @php
                    $current_auth = current_auth(false, config('console_builder.session_prefix'));
                @endphp
                <div class="d-flex align-items-center ms-1" id="kt_header_user_menu_toggle">
                    <div class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 px-2 px-md-3" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <div class="d-none d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4">
                            <span class="text-white opacity-75 fs-8 fw-bold lh-1 mb-1">{{ data_get($current_auth, 'nickname', '未知') }}</span>
                            <span class="text-white fs-8 fw-bolder lh-1">{{ data_get($current_auth, 'role_name', '未知') }}</span>
                        </div>
                        <div class="symbol symbol-30px symbol-md-40px">
                            @if(empty(data_get($current_auth, 'avatar', '')))
                                <div class="symbol-label fs-2 fw-bold text-success">{{ data_get($current_auth, 'nickname_abbr', 'X') }}</div>
                            @else
                                <img src="{{ data_get($current_auth, 'avatar', '') }}" alt="image" />
                            @endif
                        </div>
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    @if(empty(data_get($current_auth, 'avatar', '')))
                                        <div class="symbol-label fs-2 fw-bold text-success">{{ data_get($current_auth, 'nickname_abbr', 'X') }}</div>
                                    @else
                                        <img src="{{ data_get($current_auth, 'avatar', '') }}" alt="image" />
                                    @endif
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bolder d-flex align-items-center fs-5">{{ data_get($current_auth, 'nickname', '未知') }}
                                        <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">ID：{{ data_get($current_auth, 'id', 0) }}</span></div>
                                    <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ data_get($current_auth, 'email', '未知') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="javascript:;" id="edit_admin_password" class="menu-link px-5">修改密码</a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="javascript:;" class="menu-link px-5">
                                <span class="menu-text">操作IP</span>
                                <span class="menu-badge">
                                    <span class="badge badge-light-danger pe-2 fw-bolder fs-7">{{ data_get($current_auth, 'ip', '0.0.0.0') }}</span>
                                </span>
                            </a>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="{{ route('abnermouke.console.oauth.sign.out') }}" class="menu-link px-5">退出登录</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('abnermouke.console.layouts.headers.navs')
</div>
