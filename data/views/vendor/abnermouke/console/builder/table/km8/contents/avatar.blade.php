<td class="acbt_table_tbody_td @if(!in_array($field, $__default_show_fields__)) d-none @endif" data-field="{{ $field }}">
    <div class="symbol-group symbol-hover mb-1">
        @if($avatars = data_get($__data__, $field, []))
            @foreach($avatars as $ava)
                <div class="symbol symbol-circle symbol-40px">
                    @if($ava = get_acbt_link($ava, $__data__, ''))
                        @if(\Abnermouke\EasyBuilder\Library\Currency\ValidateLibrary::link($ava))
                            <img src="{{ $ava }}" alt="{{ $ava }}" />
                        @else
                            <div class="symbol-label bg-light-primary">
                                <span class="fs-7 text-info">{{ abbr_acbt_string($ava) }}</span>
                            </div>
                        @endif
                    @else
                        <div class="symbol-label bg-light-primary">
                            <span class="fs-7 text-info">UNKNOWN</span>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <span class="fs-7 text-info">{!! $empty_value ? $empty_value : '---' !!}</span>
        @endif
    </div>
    @if($description = decode_acbt_template($description_template, $__data__, ''))
        <div class="fs-7 text-muted">{{ $description }}</div>
    @endif
</td>
