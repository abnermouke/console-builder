<div class="col-lg-{{ $col_number }} acbt_filter_item" data-type="{{ $type }}" data-field="{{ $field }}" data-target="#acbt_filter_of_{{ $field }}">
    <label class="fs-6 form-label fw-bolder text-dark">{{ $guard_name }}</label>
    <div class="position-relative" data-kt-dialer="true" data-kt-dialer-min="{{ $extras['min'] }}" data-kt-dialer-max="{{ $extras['max'] }}" data-kt-dialer-step="{{ $extras['step'] }}" data-kt-dialer-decimals="{{ $extras['decimals'] }}">
        <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
            <span class="svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                    <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="black" />
                </svg>
            </span>
        </button>
        <input type="text" class="form-control form-control-solid border-0 ps-12" id="acbt_filter_of_{{ $field }}" data-kt-dialer-control="input" placeholder="{{ data_get($extras, 'placeholder', $guard_name) }}" name="{{ $field }}" value="{{ $default_value }}" />
        <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
            <span class="svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                    <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="black" />
                    <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="black" />
                </svg>
            </span>
        </button>
    </div>
</div>
