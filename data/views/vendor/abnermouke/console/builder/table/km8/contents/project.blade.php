<td class="acbt_table_tbody_td {{ !$__custom_field__ ? 'acbt_table_tbody_td_master' : '' }} @if(!in_array($field, $__default_show_fields__)) d-none @endif d-flex align-items-center" data-field="{{ $field }}">
    <div class="symbol {{ data_get($extras, 'circle', false) ? 'symbol-circle' : '' }} {{ data_get($extras, 'thumb_class', 'symbol-50px') }} overflow-hidden me-3">
        <a href="{{ get_acbt_link($link, $__data__) }}">
            <div class="symbol-label">
                @if($thumb_link = get_acbt_link($extras['thumb_link'], $__data__, abbr_acbt_template($template, $__data__, $empty_value)))
                    @if(\Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary::link($thumb_link))
                        <img src="{{ $thumb_link }}" alt="{{ $thumb_link }}" class="w-100" />
                    @else
                        {{ strtoupper(\Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary::hasZh($thumb_abbr = mb_substr($thumb_link, 0, 1)) ? pinyin_abbr($thumb_abbr) : $thumb_abbr) }}
                    @endif
                @else
                    {{ strtoupper(\Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary::hasZh($thumb_abbr = mb_substr($thumb_link, 0, 1)) ? pinyin_abbr($thumb_abbr) : $thumb_abbr) }}
                @endif
            </div>
        </a>
    </div>
    <div class="d-flex flex-column">
        <a href="{{ get_acbt_link($link, $__data__) }}" class="text-{{ $theme_options && $theme_options_trigger_field ? data_get($theme_options, data_get($__data__, $theme_options_trigger_field, ''), $theme) : $theme }} mb-1">{{ decode_acbt_template($template, $__data__, $empty_value) }}</a>
        @if($description = decode_acbt_template($description_template, $__data__, ''))
            <span class="fs-7">{!! $description !!}</span>
        @endif
    </div>
</td>
