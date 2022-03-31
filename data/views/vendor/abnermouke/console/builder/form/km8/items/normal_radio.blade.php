<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target=".acbf_{{ $sign }}_item_{{ $field }}_radio_item" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ $default_value }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    @foreach(data_get($extras, 'options', []) as $value => $guard_name)
        <div class="d-flex fv-row my-5">
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input me-3  acbf_{{ $sign }}_item_{{ $field }}_radio_item" type="radio" id="acbf_{{ $sign }}_item_{{ $field }}_{{ $value }}" name="{{ $field }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} value="{{ $value }}" @if($default_value === $value) checked="checked" @endif>
                <label class="form-check-label" for="acbf_{{ $sign }}_item_{{ $field }}_{{ $value }}">
                    <div class="fw-bolder text-gray-800">{{ $guard_name }}</div>
                    <div class="text-gray-600">{!! data_get($extras, 'descriptions.'.$value, '') !!}</div>
                </label>
            </div>
        </div>
    @endforeach
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
