<div id="acbt_{{ $sign }}" class="acb-table-builder" data-source-path="{{ proxy_assets('themes/km8/js/builder', 'abnermouke') }}" data-sign="{{ $sign }}" data-action="{{ $query_url }}" data-method="{{ $query_method }}" data-page="{{ $page }}" data-page-size="{{ $page_size }}" data-search-mode="{{ $advance_search ? 'advance' : 'basic' }}" data-custom-filter="{{ $custom_filter ? 1 : 0 }}" data-build="0" data-checkbox-trigger-buttons="{{ $checkbox_trigger_buttons ? implode(',', $checkbox_trigger_buttons) : '' }}">
    <div class="card mb-3" id="acbt_{{ $sign }}_filters_box">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center fs-4 me-5 {{ !$advance_search ? 'd-none' : '' }}" id="acbt_{{ $sign }}_filter_of_advance_using">
                    正在使用高级搜索
                </div>
                <div class="position-relative w-md-400px md-2 me-5 {{ $advance_search ? 'd-none' : '' }}" id="acbt_{{ $sign }}_filter_of_basic_input">
                    <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                        </svg>
                    </span>
                    <input type="text" class="form-control form-control-solid ps-10" id="acbt_{{ $sign }}_filter_of_basic" name="{{ $default_search_field }}" value="" placeholder="请输入{{ $default_search_tip }}搜索" />
                </div>
                <div class="d-flex align-items-center {{ $advance_search ? 'd-none' : '' }}" id="acbt_{{ $sign }}_filter_of_basic_button">
                    <button type="button" id="acbt_{{ $sign }}_filter_of_basic_to_submit" class="btn btn-sm btn-primary me-5">立即搜索</button>
                </div>
                @if($filters)
                    <div class="d-flex align-items-center">
                        <a id="acbt_{{ $sign }}_filter_of_advance_trigger" class="btn btn-link me-5 {{ !$advance_search ? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#acbt_{{ $sign }}_advance_filters_box" aria-expanded="{{ $advance_search ? 'true' : 'false' }}">{{ !$advance_search ? '高级搜索' : '普通搜索' }}</a>
                    </div>
                @endif
            </div>
            @if($filters)
                <div class="collapse {{ $advance_search ? 'show' : '' }}" id="acbt_{{ $sign }}_advance_filters_box">
                    <div class="separator separator-dashed mt-9 mb-6"></div>
                    <div class="row g-8 mb-8" id="acbt_{{ $sign }}_advance_filters">
                        @foreach($filters as $filter)
                            @include('vendor.abnermouke.console.builder.table.km8.filters.'.$filter['type'], $filter)
                        @endforeach
                    </div>
                    <div class="separator separator-dashed mt-9 mb-6"></div>
                    <div class="row g-8 mb-8">
                        <div class="d-flex align-items-center">
                            <button type="button" id="acbt_{{ $sign }}_filter_of_advance_to_submit" class="btn btn-sm btn-primary me-5">确认搜索</button>
                            <button type="button" id="acbt_{{ $sign }}_filter_of_advance_to_reset" class="btn btn-sm btn-light-dark me-5">清空条件</button>
                            <span class="text-muted">更改筛选项或排序项后请点击确认筛选按钮进行查询。</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="d-none" id="acbt_{{ $sign }}_signature">{!! $signature !!}</div>
    <div class="d-none" id="acbt_{{ $sign }}_buttons">
        @foreach($buttons as $button)
            <a class="btn btn-light btn-{{ $button['theme'] }} btn-flex h-35px h-lg-40px me-2 @if($checkbox_trigger_buttons && in_array($button['id_suffix'], $checkbox_trigger_buttons)) d-none @endif acbt_button" data-bind-checkbox="{{ $checkbox_trigger_buttons && in_array($button['id_suffix'], $checkbox_trigger_buttons) ? 1 : 0 }}" id="acbt_{{ $sign }}_button{{ $button['id_suffix'] ? ('_'.$button['id_suffix']) : '' }}" data-ajax-after="{{ $button['after_ajax'] }}" data-method="{{ $button['method'] }}" data-type="{{ $button['type'] }}" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="{{ $button['guard_name'] }}" href="javascript:;" data-query-url="{{ $button['redirect_uri'] }}" data-target-redirect="{{ (int)$button['redirect_target'] }}" data-confirm-tip="{{ $button['confirm_tip'] }}" data-params="[]" data-extras="{{ json_encode($button['extras']) }}">
                @if($button['only_show_icon'])
                    <i class="{{ $button['icon'] }} fs-1"></i>
                @else
                    @if($button['icon']) <i class="{{ $button['icon'] }} fs-1"></i> @endif {{ $button['guard_name'] }}
                @endif
            </a>
        @endforeach
    </div>
    <div class="d-flex flex-wrap flex-stack pb-3">
        <div class="d-flex flex-wrap align-items-center my-1">
            <h6 class="text-muted font-weight-bold me-5 my-1">总共 <span class="text-dark" id="acbt_{{ $sign }}_data_total_count"> --- </span> 条数据，符合筛选条件的有 <span class="text-dark" id="acbt_{{ $sign }}_data_matched_count"> --- </span> 条</h6>
        </div>
        <div class="d-flex flex-wrap my-1">
            <ul class="nav nav-pills me-2 mb-2 mb-sm-0">
                <li class="nav-item m-0 ms-2">
                    <a class="btn btn-sm btn-icon btn-light btn-secondary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="自定义列表显示项">
                        <i class="fonticon-pause"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown w-200px w-md-200px" data-kt-menu="true">
                        <div class="px-7 py-4">
                            <div class="fs-7 text-dark fw-bolder">自定义显示字段</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5 pt-1" id="acbt_{{ $sign }}_fields">
                            @foreach($show_fields as $field => $guard_name)
                                <div class="form-check form-check-custom form-check-solid form-check-sm my-3">
                                    <input type="checkbox" name="acbt_{{ $sign }}_field" id="acbt_{{ $sign }}_field_{{ $field }}" class="form-check-input" value="{{ $field }}">
                                    <label for="acbt_{{ $sign }}_field_{{ $field }}" class="form-check-label">{{ $guard_name }}</label>
                                </div>
                            @endforeach
                            <div class="separator separator-dashed mt-3 mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-sm btn-active-light-primary fw-bold me-2 px-6" data-kt-menu-dismiss="true" id="acbt_{{ $sign }}_fields_to_reset" data-default-fields="{{ implode(',', $default_show_fields) }}">重置</button>
                                <button type="submit" class="btn btn-primary  btn-sm fw-bold px-6" data-kt-menu-dismiss="true" id="acbt_{{ $sign }}_fields_to_submit">确定</button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item m-0 ms-2">
                    <a class="btn btn-sm btn-icon btn-light btn-secondary" data-plugin-import-path="{{ proxy_assets('themes/km8/js/builder/table2excel/jquery.table2excel.min.js', 'abnermouke') }}" id="acbt_{{ $sign }}_export" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="导出当前列表为EXCEL">
                        <i class="la la-file-download"></i>
                    </a>
                </li>
            </ul>
            <div class="d-flex me-2 mb-2 mb-sm-0">
                <select name="acbt_{{ $sign }}_page_size" id="acbt_{{ $sign }}_page_size" data-control="select2" data-hide-search="true" data-placeholder="每页显示条数" class="form-select form-select-sm form-select-solid min-w-100px ms-2">
                    <option value="10" @if((int)$page_size === 10) selected @endif>每页10条</option>
                    <option value="20" @if((int)$page_size === 20) selected @endif>每页20条</option>
                    <option value="50" @if((int)$page_size === 50) selected @endif>每页50条</option>
                    <option value="100" @if((int)$page_size === 100) selected @endif>每页100条</option>
                </select>
            </div>
            <div class="d-flex my-0">
                <select name="acbt_{{ $sign }}_sorts" id="acbt_{{ $sign }}_sorts" data-control="select2" data-hide-search="true" data-placeholder="排序规则" class="form-select form-select-sm form-select-solid min-w-100px ms-2">
                    @foreach($sorts as $alias => $guard_name)
                        <option value="{{ $alias }}">{{ $guard_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="tab-content min-h-300px" id="acbt_{{ $sign }}_content">

    </div>
</div>
<script>
    window.onload = function () {
        //引入实例对象
        createExtraJs('{{ proxy_assets('themes/km8/js/builder/table-builder.js', 'abnermouke') }}', $.table_builder, function () {
            //创建处理实例对象
            $.table_builder.init('{{ $sign }}');
        });
    };
</script>
