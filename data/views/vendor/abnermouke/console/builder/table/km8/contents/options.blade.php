<td class="acbt_table_tbody_td {{ !$__custom_field__ ? 'acbt_table_tbody_td_master' : '' }} @if(!in_array($field, $__default_show_fields__)) d-none @endif" data-field="{{ $field }}">
    <div class="badge badge-light-{{ $theme_options && $theme_options_trigger_field ? data_get($theme_options, data_get($__data__, $theme_options_trigger_field, ''), $theme) : $theme }} text-center fw-bolder px-4 py-3">{{ data_get(data_get($extras, 'options', []), decode_acbt_template($template, $__data__, $empty_value), $empty_value) }}</div>
    @if($description = decode_acbt_template($description_template, $__data__, ''))
        <div class="fs-7 text-muted">{!! $description !!}</div>
    @endif
</td>
