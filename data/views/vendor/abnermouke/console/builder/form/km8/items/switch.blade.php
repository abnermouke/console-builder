<div class="d-flex flex-stack {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ $default_value }}">
    <div class="me-5">
        <label class="fs-6 fw-bold">
            <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
            @if($tip)
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
            @endif
        </label>
        <div class="fs-7 fw-bold text-muted">{!! $description !!}</div>
    </div>
    <label class="form-check form-switch form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" id="acbf_{{ $sign }}_item_{{ $field }}" name="{{ $field }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} @if(\Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_ON === $default_value) checked="checked" @endif data-on-value="{{ data_get($extras, 'on', \Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_ON) }}" data-off-value="{{ data_get($extras, 'off', \Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_OFF) }}"/>
        <span class="form-check-label fw-bold text-muted">{{ data_get($extras, 'allow_text', '允许') }}</span>
    </label>
</div>
<div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
