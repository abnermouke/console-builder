<div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
        <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
            <h1 class="d-flex text-dark fw-bolder m-0 fs-3"><span id="kt_toolbar_breadcrumb_title"></span></h1>
            <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7" id="kt_toolbar_breadcrumbs"></ul>
        </div>
        <div class="d-flex align-items-center" id="kt_dashboard_toolbar_items">
            {{--PC设备访问--}}
            @if(\Abnermouke\EasyBuilder\Library\Currency\DeviceLibrary::pc())
                <a href="javascript:;" class="btn btn-flex btn-secondary h-35px h-lg-40px px-5" id="kt_dashboard_show_aside">
                    <span class="me-4">
                        <span class="text-dark fw-bold me-1">显示侧边菜单:</span>
                    </span>
                    <div class="form-check form-switch form-check-custom form-check-solid" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="可快捷显示侧边菜单或隐藏">
                        <input class="form-check-input h-20px w-30px" type="checkbox" id="show_aside"/>
                    </div>
                </a>
            @endif
        </div>
    </div>
</div>
