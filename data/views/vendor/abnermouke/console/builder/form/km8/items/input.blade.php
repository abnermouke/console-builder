<div class="d-flex flex-column {{ $hidden ? 'd-none' : '' }} acbf_{{ $sign }}_item_box" data-target="#acbf_{{ $sign }}_item_{{ $field }}" data-required="{{ $required ? 1 : 0 }}" data-type="{{ $type }}" data-field="{{ $field }}" data-triggers="{{ json_encode($triggers) }}" data-default-value="{{ $default_value }}">
    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
        <span class="{{ $required ? 'required' : '' }}">{{ $guard_name }}</span>
        @if($tip)
            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{!! $tip !!}"></i>
        @endif
    </label>
    @if(data_get($extras, 'prepend', false) || data_get($extras, 'append', false))
        <div class="input-group input-group-solid">
            @if($prepends = data_get($extras, 'prepend', []))
                @foreach($prepends as $prepend)
                    <span class="input-group-text">
                        @if(!empty($prepend['icon']))
                            <i class="{{ $prepend['icon'] }}  fs-3" data-bs-toggle="tooltip" title="{{ $prepend['content'] }}"></i>
                        @else
                            {{ $prepend['content'] }}
                        @endif
                    </span>
                @endforeach
            @endif
    @endif
            <input type="{{ data_get($extras, 'input_type', 'text')  }}" class="form-control form-control-solid" data-input-mode="{{ data_get($extras, 'input_mode', 'text')  }}" data-format="{{ data_get($extras, 'format', '') }}" data-date-range="{{ data_get($extras, 'range', false) ? 1 : 0 }}" autocomplete="off" id="acbf_{{ $sign }}_item_{{ $field }}" placeholder="{{ data_get($extras, 'placeholder', '') }}" value="{{ $default_value }}" name="{{ $field }}" {!! (int)data_get($extras, 'max_length', 0) > 0 ? 'maxlength="'.data_get($extras, 'max_length', 0).'"' : '' !!}  {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}/>
     @if(data_get($extras, 'append', false) || data_get($extras, 'prepend', false))
            @if($appends = data_get($extras, 'append', []))
                @foreach($appends as $append)
                    @if(data_get($extras, 'clipboard', false) && $append['icon'] === 'la la-copy')
                        <span class="input-group-text cursor-pointer" data-bs-toggle="tooltip" title="{{ $append['content'] }}" data-action-type="clipboard" data-clipboard-target="#acbf_{{ $sign }}_item_{{ $field }}"><i class="{{ $append['icon'] }} fs-3"></i></span>
                    @elseif($append['icon'] === 'la la-link' && $extras['input_type'] == 'url')
                        <span class="input-group-text cursor-pointer" data-bs-toggle="tooltip" title="{{ $append['content'] }}" data-action-type="link" data-link-target="#acbf_{{ $sign }}_item_{{ $field }}"><i class="{{ $append['icon'] }} fs-3"></i></span>
                    @else
                        <span class="input-group-text">
                            @if(!empty($append['icon']))
                                <i class="{{ $append['icon'] }} fs-3" data-bs-toggle="tooltip" title="{{ $append['content'] }}"></i>
                            @else
                                {{ $append['content'] }}
                            @endif
                        </span>
                    @endif
                @endforeach
            @endif
        </div>
    @endif
    @if($description)
        <div class="fs-7 fw-bold text-muted my-1">{!! $description !!}</div>
    @endif
    <div class="fs-7 fw-bold text-warning my-2 d-none" id="acbf_{{ $sign }}_item_{{ $field }}_edited_warning">最近更新时间：<span class="edited_time fw-bold">{{ auto_datetime() }}</span></div>
</div>
