<td class="acbt_table_tbody_td @if(!in_array($field, $__default_show_fields__)) d-none @endif text-{{ $theme_options && $theme_options_trigger_field ? data_get($theme_options, data_get($__data__, $theme_options_trigger_field, ''), $theme) : $theme }} {{ $bold ? 'fw-bold' : '' }}" data-field="{{ $field }}">
    @php
        if ($price_value = decode_acbt_template($template, $__data__, false)) {
            if (($ratio = (int)data_get($extras, 'ratio', 0)) > 0) {
                $price_value = floatval($price_value) / $ratio;
            }
            $price_value = number_format(floatval($price_value), data_get($extras, 'decimal', 2));
        }
    @endphp
    @if($pre_image = data_get($extras, 'pre_image', false))<img src="{{ get_acbt_link($pre_image, $__data__) }}" class="{{ data_get($extras, 'image_class', 'w-20px') }} me-3" alt="">@endif{{ $price_value ? ((data_get($extras, 'prefix', '')).' '.$price_value.' '.(data_get($extras, 'suffix', ''))) : $empty_value }}
    @if($description = decode_acbt_template($description_template, $__data__, ''))
        <div class="fs-7 text-muted mt-1">{!! $description !!}</div>
    @endif
</td>
