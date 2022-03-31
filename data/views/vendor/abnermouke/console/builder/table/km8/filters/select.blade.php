<div class="col-lg-{{ $col_number }} acbt_filter_item" data-type="{{ $type }}" data-field="{{ $field }}" data-target="#acbt_filter_of_{{ $field }}">
    <label class="fs-6 form-label fw-bolder text-dark">{{ $guard_name }}</label>
    <select class="form-select form-select-solid" id="acbt_filter_of_{{ $field }}" name="{{ $field }}" data-control="select2"  data-allow-clear="true" data-placeholder="选择{{ $guard_name }}">
        @foreach(data_get($extras, 'options', []) as $value => $name)
            <option value="{{ $value }}" @if($value == $default_value) selected @endif>{{ $name }}</option>
        @endforeach
    </select>
</div>
