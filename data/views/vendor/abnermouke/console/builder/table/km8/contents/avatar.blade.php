<td class="acbt_table_tbody_td @if(!in_array($field, $__default_show_fields__)) d-none @endif" data-field="{{ $field }}">
    <div class="symbol-group symbol-hover mb-1">
        @if($avatars = data_get($__data__, $field, []))
            @foreach($avatars as $ava)
                <div class="symbol symbol-circle symbol-25px">
                    @if($ava = get_acbt_link($ava, $__data__, '') && \Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary::link($ava))
                        <img src="{{ $ava }}" alt="{{ $ava }}" />
                    @else
                        <div class="symbol-label bg-light-primary">
                            <span class="fs-7 text-{{ \Illuminate\Support\Arr::random(array_values(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_STATUS_THEME)) }}"> {{ strtoupper(\Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary::hasZh($thumb_abbr = mb_substr($thumb_link, 0, 1)) ? pinyin_abbr($thumb_abbr) : $thumb_abbr) }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
    @if($description = decode_acbt_template($description_template, $__data__, ''))
        <div class="fs-7 text-muted">{{ $description }}</div>
    @endif
</td>
