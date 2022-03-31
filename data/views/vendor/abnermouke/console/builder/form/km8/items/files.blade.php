<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-multiple="{{ data_get($extras, 'multiple', false) ? 1 : 0 }}" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}"  data-uploader-url="{{ data_get($extras, 'uploader_url', route('abnermouke.console.uploader')) }}" data-upload-dictionary="{{ data_get($extras, 'dictionary', 'abnermouke/console/builder/uploader/files') }}" data-default-value="{{ json_encode(object_2_array($default_value), JSON_UNESCAPED_UNICODE) }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    <div class="dropzone-queue dropzone py-10 px-5 bg-light-primary" id="acbf_{{ $sign }}_item_{{ $field }}_upload_box">
        <div class="text-center text-muted {{ object_2_array($default_value) ? 'd-none' : '' }}" id="acbf_{{ $sign }}_item_{{ $field }}_upload_without_item">暂无文件</div>
        <div class="dropzone-items wm-200px scroll-x" id="acbf_{{ $sign }}_item_{{ $field }}_upload_items">
            @foreach(object_2_array($default_value) as $link)
                <div class="dropzone-item acbf_{{ $sign }}_item_{{ $field }}_upload_item" data-link="{{ $link }}">
                    <div class="dropzone-file">
                        <div class="dropzone-filename">
                            <span>{{ @basename($link) }}</span>
                        </div>
                    </div>
                    <div class="dropzone-toolbar acbf_{{ $sign }}_item_{{ $field }}_upload_item_toolbar">
                        <span class="dropzone-start acbf_{{ $sign }}_item_{{ $field }}_upload_item_trigger" data-trigger="preview" data-bs-toggle="tooltip" data-bs-dismiss="click" title="预览/查看文件内容">
                            <i class="bi bi-eye fs-3"></i>
                        </span>
                        <span class="dropzone-start acbf_{{ $sign }}_item_{{ $field }}_upload_item_trigger" data-trigger="prev" data-bs-toggle="tooltip" data-bs-dismiss="click" title="上移文件排序">
                            <i class="bi bi-arrow-up fs-3"></i>
                        </span>
                        <span class="dropzone-start acbf_{{ $sign }}_item_{{ $field }}_upload_item_trigger" data-trigger="next" data-bs-toggle="tooltip" data-bs-dismiss="click" title="下移文件排序">
                            <i class="bi bi-arrow-down fs-3"></i>
                        </span>
                        <span class="dropzone-delete acbf_{{ $sign }}_item_{{ $field }}_upload_item_trigger" data-trigger="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="删除当前文件" data-bs-delay-hide="500">
                            <i class="bi bi-x fs-1"></i>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <input type="file" {{  data_get($extras, 'multiple', false) ? 'multiple' : '' }} accept="{{ data_get($extras, 'accept', '*/*') }}" class="d-none" id="acbf_{{ $sign }}_item_{{ $field }}_uploader" value="" autocomplete="off" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}>
    <input type="hidden" id="acbf_{{ $sign }}_item_{{ $field }}" autocomplete="off" value="{{ json_encode(object_2_array($default_value), JSON_UNESCAPED_UNICODE) }}">
    <button id="acbf_{{ $sign }}_item_{{ $field }}_trigger" class="btn btn-light-primary btn-sm me-3 my-3">点击选择文件</button> <span class="text-muted">文件右侧可对当前文件进行预览、排序、删除等操作，展示顺序以实际上传速度为准。</span>
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
