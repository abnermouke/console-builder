<td class="acbt_table_tbody_td {{ !$__custom_field__ ? 'acbt_table_tbody_td_master' : '' }} @if(!in_array($field, $__default_show_fields__)) d-none @endif text-{{ $theme_options && $theme_options_trigger_field ? data_get($theme_options, data_get($__data__, $theme_options_trigger_field, ''), $theme) : $theme }} {{ $bold ? 'fw-bold' : '' }}" data-field="{{ $field }}">
    @if($pre_image = data_get($extras, 'pre_image', false))<img src="{{ get_acbt_link($pre_image, $__data__) }}" class="{{ data_get($extras, 'image_class', 'w-20px') }} me-3" alt="">@endif{{ ($number_value = decode_acbt_template($template, $__data__, false)) ? number_format(floatval($number_value), 0) : $empty_value }}
    @if($description = decode_acbt_template($description_template, $__data__, ''))
        <div class="fs-7 text-muted mt-1">{!! $description !!}</div>
    @endif
</td>
