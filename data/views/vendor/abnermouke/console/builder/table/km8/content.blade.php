<div class="card card-flush ">
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed text-left fs-6 gy-5" id="acbt_{{ $sign }}_table_box" data-checkbox="{{ $checkbox }}" data-total-count="{{ $data['total_count'] }}" data-matched-count="{{ $data['matched_count'] }}">
                <thead id="acbt_{{ $sign }}_table_thead">
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    @if($checkbox)
                        <th class="w-10px pe-2 export_ignore">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" id="acbt_{{ $sign }}_table_select_all" type="checkbox"/>
                            </div>
                        </th>
                    @endif
                    @foreach($fields as $field => $setting)
                        <th class="acbt_table_thead_th @if(!in_array($field, $default_show_fields)) d-none @endif" data-field="{{ $field }}">{{ $setting['guard_name'] }}</th>
                    @endforeach
                    @if($actions)
                        <th class="text-end export_ignore">操作</th>
                    @endif
                </tr>
                </thead>
                <tbody class="text-gray-600 fw-bold" id="acbt_{{ $sign }}_table_tbody">
                @if(isset($data['lists']) && $data['lists'] && !empty($data['lists']))
                    @foreach($data['lists'] as $k => $list)
                        <tr class="acbt_{{ $sign }}_table_tbody_tr" id="acbt_{{ $sign }}_table_tbody_tr_{{ $k }}">
                            @if($checkbox)
                                <td class="acbt_table_tbody_td_checkbox export_ignore" data-field="{{ $checkbox }}">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input acbt_{{ $sign }}_table_select_item" type="checkbox" value="{{ data_get($list, $checkbox, '') }}" />
                                    </div>
                                </td>
                            @endif
                            @foreach($fields as $field => $setting)
                                @include('vendor.abnermouke.console.builder.table.km8.contents.'.$setting['type'], array_merge($setting, ['__data__' => $list, '__sign__' => $sign, '__checkbox__' => $checkbox, '__default_show_fields__' => $default_show_fields]))
                            @endforeach
                            @if($actions)
                                <td class="acbt_{{ $sign }}_table_tbody_td_actions text-end export_ignore">
                                    @if(count($actions) > 2)
                                        <a href="javascript:;" class="btn btn-light btn-active-light-primary btn-sm acbt_{{ $sign }}_table_action_box" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="acbt_{{ $sign }}_table_action_box_{{ $k }}">操作 <i class="la la-angle-down"></i></a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4 acbt_{{ $sign }}_table_action_menu" id="acbt_{{ $sign }}_table_action_menu_{{ $k }}" data-kt-menu="true">
                                            @foreach($actions as $action)
                                                <div class="menu-item px-2 my-2">
                                                    <a href="javascript:;" class="menu-link px-3 acbt_{{ $sign }}_table_action_item text-{{ $action['theme'] }}" data-ajax-after="{{ $action['after_ajax'] }}" data-method="{{ $action['method'] }}" data-type="{{ $action['type'] }}" data-query-url="{{ get_acbt_link($action['redirect_uri'], $list) }}" data-target-redirect="{{ (int)$action['redirect_target'] }}" data-confirm-tip="{{ $action['confirm_tip'] }}" data-param-fields="{{ json_encode(\Illuminate\Support\Arr::only($list, $action['param_fields'])) }}" data-extras="{{ json_encode($action['extras']) }}">{!! $action['icon'] ? '<i class="'.$action['icon'].' me-1  text-'.$action['theme'].'"></i>' : '' !!}{{ $action['guard_name'] }}</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        @foreach($actions as $action)
                                            <a href="javascript:;" class="btn acbt_{{ $sign }}_table_action_item btn-sm btn-light-{{ $action['theme'] }} mb-1 btn-icon"  data-ajax-after="{{ $action['after_ajax'] }}" data-method="{{ $action['method'] }}" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="{{ $action['guard_name'] }}" data-type="{{ $action['type'] }}" data-query-url="{{ get_acbt_link($action['redirect_uri'], $list) }}" data-target-redirect="{{ (int)$action['redirect_target'] }}" data-confirm-tip="{{ $action['confirm_tip'] }}" data-param-fields="{{ json_encode(\Illuminate\Support\Arr::only($list, $actions[0]['param_fields'])) }}" data-extras="{{ json_encode($action['extras']) }}">{!! $action['icon'] ? '<i class="'.$action['icon'].'"></i>' : $action['guard_name'] !!}</a>
                                        @endforeach
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12">
                            <div class="pt-lg-10 mt-5 mb-10 text-center">
                                <h4 class="fw-bolder text-gray-800 mb-5">暂无相关数据展示</h4>
                                <div class="fw-bold text-muted">No relevant data, please try to change the search criteria to see more highlights !</div>
                            </div>
                            <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom h-150px mt-10" style="background-image: url({{ proxy_assets('themes/km8/media/illustrations/sketchy-1/18.png', 'abnermouke') }})"></div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('vendor.abnermouke.console.builder.table.km8.pagination', array_merge($data, compact('sign')))
</div>
