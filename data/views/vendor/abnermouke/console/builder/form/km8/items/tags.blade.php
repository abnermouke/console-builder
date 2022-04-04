<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ json_encode(object_2_array($default_value), JSON_UNESCAPED_UNICODE) }}" data-whitelist="{{ json_encode(object_2_array(data_get($extras, 'whitelist', [])), JSON_UNESCAPED_UNICODE) }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <input type="text" class="form-control form-control-solid" autocomplete="off" id="acbf_{{ $sign }}_item_{{ $field }}" placeholder="{{ data_get($extras, 'placeholder', '') }}" value="{{ implode(',', object_2_array($default_value)) }}" name="{{ $field }}" {!! (int)data_get($extras, 'max_length', 0) > 0 ? 'maxlength="'.data_get($extras, 'max_length', 0).'"' : '' !!}  {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}/>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
