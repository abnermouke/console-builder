<div class="{{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ $default_value }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <select class="form-select form-select-solid" data-control="select2" {{ data_get($extras, 'multiple', false) ? 'multiple' : '' }} @if(!data_get($extras, 'searchable', false)) data-hide-search="true" @endif autocomplete="off" id="acbf_{{ $sign }}_item_{{ $field }}" data-placeholder="{{ data_get($extras, 'placeholder', '') }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} name="{{ $field }}">
        <option value="__WITHOUT_SELECTED_OPTION__" @if($default_value === '__WITHOUT_SELECTED_OPTION__') selected @endif>{{ data_get($extras, 'placeholder', $guard_name) }}</option>
        @foreach($extras['options'] as $value => $guard_name)
            <option value="{{ $value }}" @if($value === $default_value) selected @endif>{{ $guard_name }}</option>
        @endforeach
    </select>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
