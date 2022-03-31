<div class="col-lg-{{ $col_number }} acbt_filter_item" data-type="{{ $type }}" data-field="{{ $field }}" data-target=".acbt_filter_of_{{ $field }}">
    <label class="fs-6 form-label fw-bolder text-dark">{{ $guard_name }}</label>
    <div class="nav-group nav-group-fluid">
        @foreach(data_get($extras, 'options', []) as $value => $name)
            <label>
                <input type="radio" class="btn-check acbt_filter_of_{{ $field }}" name="{{ $field }}" value="{{ $value }}" @if($value === $default_value) checked="checked" @endif />
                <span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">{{ $name }}</span>
            </label>
        @endforeach
    </div>
</div>
