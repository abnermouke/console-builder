<td class="acbt_table_tbody_td @if(!in_array($field, $__default_show_fields__)) d-none @endif" data-field="{{ $field }}">
    <div class="rating">
        @php
            $rating_value = (int)data_get($__data__, $field, 0);
        @endphp
        @for($i = 1; $i <=5; $i++)
            <div class="rating-label me-1 {{ (int)$rating_value >= (int)$i ? 'checked' : '' }}">
                <i class="bi bi-star-fill fs-6s"></i>
            </div>
        @endfor
    </div>
    @if($description = decode_acbt_template($description_template, $__data__, ''))
        <span class="text-muted text-muted d-block fs-7 mt-1">{!! $description !!}</span>
    @endif
</td>
