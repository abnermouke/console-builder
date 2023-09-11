<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-upload-dictionary="{{ data_get($extras, 'dictionary', 'abnermouke/console/builder/uploader/images') }}" data-default-value="" data-upload-url="{{ route('abnermouke.console.uploader') }}" data-javascript-file="{{ proxy_assets('themes/km8/js/builder/ckeditor/ckeditor.js', 'abnermouke') }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <div class="d-none" id="acbf_{{ $sign }}_item_{{ $field }}_default_value_content">{!! $default_value !!}</div>
    <textarea class="form-select form-select-solid" autocomplete="off" id="acbf_{{ $sign }}_item_{{ $field }}" placeholder="{{ data_get($extras, 'placeholder', '') }}" rows="{{ data_get($extras, 'row', 3) }}" {!! (int)data_get($extras, 'max_length', 0) > 0 ? 'maxlength="'.data_get($extras, 'max_length', 0).'"' : '' !!} {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} name="{{ $field }}">{!! $default_value !!}</textarea>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>