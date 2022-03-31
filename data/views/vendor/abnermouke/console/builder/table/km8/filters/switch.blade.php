<div class="col-lg-{{ $col_number }} acbt_filter_item" data-type="{{ $type }}" data-field="{{ $field }}" data-target="#acbt_filter_of_{{ $field }}">
    <label class="fs-6 form-label fw-bolder text-dark">{{ $guard_name }}</label>
    <div class="form-check form-switch form-check-custom form-check-solid mt-1">
        <input class="form-check-input" id="acbt_filter_of_{{ $field }}" name="{{ $field }}" type="checkbox" @if(data_get($extras, 'on', \Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_ON) == $default_value) checked @endif data-on-value="{{ data_get($extras, 'on', \Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_ON) }}" data-off-value="{{ data_get($extras, 'off', \Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_OFF) }}"/>
{{--        <label class="form-check-label" for="flexSwitchChecked">开启状态</label>--}}
    </div>
</div>
