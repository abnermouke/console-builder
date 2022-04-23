<td class="acbt_table_tbody_td @if(!in_array($field, $__default_show_fields__)) d-none @endif" data-field="{{ $field }}">
    <div class="position-relative ps-6 pe-3 py-2">
        <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-{{ $theme_options && $theme_options_trigger_field ? data_get($theme_options, data_get($__data__, $theme_options_trigger_field, ''), $theme) : $theme }}"></div>
        <a href="{{ get_acbt_link($link, $__data__) }}" class="mb-1 text-{{ $theme }} text-hover-primary fw-bolder">{{ decode_acbt_template($template, $__data__, $empty_value) }}</a>
        @if($description = decode_acbt_template($description_template, $__data__, ''))
            <div class="fs-7 text-muted">{!! $description !!}</div>
        @endif
    </div>
</td>
