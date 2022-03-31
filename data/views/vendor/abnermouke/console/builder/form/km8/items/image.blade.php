<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ $default_value }}" data-uploader-url="{{ data_get($extras, 'uploader_url', route('abnermouke.console.uploader')) }}" data-upload-dictionary="{{ data_get($extras, 'dictionary', 'abnermouke/console/builder/uploader/images') }}" data-cropper-css-path="{{ proxy_assets('themes/km8/plugins/cropper/cropper.bundle.css', 'abnermouke') }}" data-cropper-js-path="{{ proxy_assets('themes/km8/plugins/cropper/cropper.bundle.js', 'abnermouke') }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <div class="fv-row" id="acbf_{{ $sign }}_item_{{ $field }}_upload_box">
        <div class="h-{{ data_get($extras, 'box_height', 200) }}px w-{{ data_get($extras, 'box_width', 200) }}px bg-light-{{ \Illuminate\Support\Arr::random(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_THEME_ALIAS) }} mb-2" style="{{ $default_value ? 'background: url('.$default_value.');' : '' }}background-position: left;background-repeat: no-repeat" id="acbf_{{ $sign }}_item_{{ $field }}_wrapper">
        </div>
        <div class="fv-row mt-1">
            <input type="file" accept="{{ data_get($extras, 'accept', 'image/*') }}" data-width="{{ data_get($extras, 'width', 200) }}" data-height="{{ data_get($extras, 'height', 200) }}" class="d-none" id="acbf_{{ $sign }}_item_{{ $field }}_uploader" value="" autocomplete="off" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}>
            <input type="hidden" id="acbf_{{ $sign }}_item_{{ $field }}" autocomplete="off" value="{{ $default_value }}">
            <button id="acbf_{{ $sign }}_item_{{ $field }}_trigger" class="btn btn-light-primary btn-sm me-3 my-3">更改图片</button>
            <button id="acbf_{{ $sign }}_item_{{ $field }}_remover" class="btn btn-light-danger btn-sm me-3 my-3">移除图片</button>
        </div>
    </div>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
