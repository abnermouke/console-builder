<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target=".acbf_{{ $sign }}_item_{{ $field }}_radio_item" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ $default_value }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
        @foreach(data_get($extras, 'options', []) as $value => $guard_name)
            <div class="col">
                <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 {{ $default_value === $value ? 'active' : '' }}" data-kt-button="true">
                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                        <input class="form-check-input acbf_{{ $sign }}_item_{{ $field }}_radio_item" type="radio" id="acbf_{{ $sign }}_item_{{ $field }}_{{ $value }}" name="{{ $field }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} value="{{ $value }}" @if($default_value === $value) checked="checked" @endif>
                    </span>
                    <span class="ms-5">
                        <span class="fs-4 fw-bolder text-gray-800 d-block">{{ $guard_name }}</span>
                    </span>
                </label>
            </div>
        @endforeach
    </div>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
