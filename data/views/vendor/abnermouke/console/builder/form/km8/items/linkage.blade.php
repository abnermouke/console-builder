<div class="{{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-json-path="{{ data_get($extras, 'json_path', '') }}" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-key="{{ data_get($extras, 'default_key_value', '') }}" data-level="{{ data_get($extras, 'level', 2) }}" data-names="{{ json_encode(data_get($extras, 'names', [])) }}" data-default-value="{{ json_encode(object_2_array($default_value), JSON_UNESCAPED_UNICODE) }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <input type="hidden" id="acbf_{{ $sign }}_item_{{ $field }}" autocomplete="off" value="{{ json_encode(object_2_array($default_value), JSON_UNESCAPED_UNICODE) }}">
    <div class="row fv-row" id="acbf_{{ $sign }}_item_{{ $field }}_box">
        @for($i = 1; $i <= (int)data_get($extras, 'level', 2); $i++)
            <div class="col-{{ (int)data_get($extras, 'item_col', 3) }} mb-3">
                <select name="{{ $field }}_{{ $i }}" data-level="{{ $i }}" data-keys="[]" class="form-select form-select-solid acbf_{{ $sign }}_item_{{ $field }}_linkage_item" data-placeholder="{{ data_get($extras, 'placeholder', '') }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}>
                    <option value="{{ data_get($extras, 'default_key_value', '') }}" selected class="default_option">请选择</option>
                </select>
            </div>
        @endfor
    </div>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
