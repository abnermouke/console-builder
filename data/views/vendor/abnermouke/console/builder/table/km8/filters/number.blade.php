<div class="col-lg-{{ $col_number }} acbt_filter_item" data-type="{{ $type }}" data-field="{{ $field }}" data-target="#acbt_filter_of_{{ $field }}">
    <label class="fs-6 form-label fw-bolder text-dark">{{ $guard_name }}</label>
    <input type="number" @if(is_numeric($extras['min'])) min="{{ $extras['min'] }}" @endif @if(is_numeric($extras['max'])) max="{{ $extras['max'] }}" @endif class="form-control form-control form-control-solid" name="{{ $field }}" placeholder="{{ data_get($extras, 'placeholder', $guard_name) }}" id="acbt_filter_of_{{ $field }}" value="{{ $default_value }}" />
</div>
