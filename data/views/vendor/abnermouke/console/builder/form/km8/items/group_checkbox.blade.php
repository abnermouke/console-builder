<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target=".acbf_{{ $sign }}_item_{{ $field }}_checkbox_item" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ json_encode(object_2_array($default_value), JSON_UNESCAPED_UNICODE) }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <tbody class="text-gray-600 fw-bold">
                <tr>
                    <a href="javascript:;" class="btn btn-light btn-light-primary btn-sm my-3 mb-7 me-2" id="acbf_{{ $sign }}_item_{{ $field }}_checkbox_item_button_trigger_select_all">选中全部</a>
                    <a href="javascript:;" class="btn btn-light btn-light-danger btn-sm my-3 mb-7" id="acbf_{{ $sign }}_item_{{ $field }}_checkbox_item_button_trigger_select_none">取消全部选中</a>
                </tr>
                @foreach(data_get($extras, 'options', []) as $group_name => $options)
                    @if($options)
                        <tr>
                            <td class="text-gray-800">{{ $group_name }}</td>
                            <td>
                                <div class="d-flex">
                                    @foreach($options as $value => $name)
                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                        <input class="form-check-input acbf_{{ $sign }}_item_{{ $field }}_checkbox_item" type="checkbox" id="acbf_{{ $sign }}_item_{{ $field }}_{{ $value }}" name="{{ $field }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} value="{{ $value }}" @if(in_array($value, object_2_array($default_value))) checked="checked" @endif>
                                        <span class="form-check-label">{{ $name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
