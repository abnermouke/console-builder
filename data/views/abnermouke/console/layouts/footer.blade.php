<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
    <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-bold me-1">{{ auto_datetime('Y') }}©</span>
            <a href="{{ config('app.url') }}" target="_blank" class="text-gray-800 text-hover-primary">{!! data_get($console_configs, 'APP_TITLE', 'Console控制台') !!}</a>
        </div>
        <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
{{--            <li class="menu-item">--}}
{{--                <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>--}}
{{--            </li>--}}
        </ul>
    </div>
</div>
