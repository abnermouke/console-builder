@if(!$bind_modal_id)
    <div class="card">
        <div class="card-body">
@endif
            <div id="acbf_{{ $sign }}" class="acb-form-builder form" data-bind-modal-id="{{ $bind_modal_id }}" data-bind-table-id="{{ $bind_table_id }}" data-sign="{{ $sign }}" data-builed="0" data-domain="{{ config('app.url') }}">
                @if($title)
                    <div id="acbf_{{ $sign }}_titles">
                        <h3 class="mb-5">{{ $title }}</h3>
                        @if($description)<div class="text-muted fw-bold fs-7">{!! $description !!}</div>@endif
                    </div>
                @endif
                @if($alert)
                    <div class="alert my-5 {{ $alert['dismissible'] ? 'alert-dismissible' : '' }} {{ $alert['bg_light'] ? 'bg-light-'.$alert['theme'] : 'bg-'.$alert['theme'] }} {{ $alert['bolder'] ? ('border border-'.$alert['bold_style'].' border-'.$alert['theme']) : '' }} d-flex flex-column flex-sm-row p-5 mb-10">
                        @if($alert['icon'])
                            <span class="text-{{ $alert['theme'] }} me-4 mb-5 mb-sm-0 {{ $alert['icon'] }}"></span>
                        @endif
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <h5 class="mb-1">{{ $alert['title'] }}</h5>
                            @if($alert['description'])<span>{{ $alert['description'] }}</span>@endif
                        </div>
                        @if($alert['dismissible'])
                            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                <i class="bi bi-x fs-1 text-{{ $alert['theme'] }}"></i>
                            </button>
                        @endif
                    </div>
                @endif
                @if(!$bind_modal_id)
                    <div class="separator separator-dashed my-3"></div>
                @endif
                @foreach($structures as $structure)
                    <div class="row g-9 my-3 acbf_{{ $sign }}_structure_group" data-group-alias="{{ md5(implode(',', array_keys($structure['fields']))) }}" data-fields="{{ implode(',', array_keys($structure['fields'])) }}">
                        @if($structure['title'])
                            <div>
                                <h5 class="mb-3">{{ $structure['title'] }}</h5>
                                @if($structure['description'])<div class="text-muted fw-bold fs-7">{!! $structure['description'] !!}</div>@endif
                            </div>
                        @endif
                        @if($structure['alert'])
                            <div class="alert mt-5 {{ $structure['alert']['dismissible'] ? 'alert-dismissible' : '' }} {{ $structure['alert']['bg_light'] ? 'bg-light-'.$structure['alert']['theme'] : 'bg-'.$structure['alert']['theme'] }} {{ $structure['alert']['bolder'] ? ('border border-'.$structure['alert']['bold_style'].' border-'.$structure['alert']['theme']) : '' }} d-flex flex-column flex-sm-row p-5 mb-10">
                                @if($structure['alert']['icon'])
                                    <span class="text-{{ $structure['alert']['theme'] }} me-4 mb-5 mb-sm-0 {{ $structure['alert']['icon'] }}"></span>
                            </span>
                                @endif
                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <h5 class="mb-1">{{ $structure['alert']['title'] }}</h5>
                                    @if($structure['alert']['description'])<span>{{ $structure['alert']['description'] }}</span>@endif
                                </div>
                                @if($structure['alert']['dismissible'])
                                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                        <i class="bi bi-x fs-1 text-{{ $structure['alert']['theme'] }}"></i>
                                    </button>
                                @endif
                            </div>
                        @endif
                        @foreach($structure['fields'] as $field => $col)
                            @if($item = data_get($items, $field, false))
                                <div class="col-md-{{ $col }} fv-row my-5">
                                    @include('vendor.abnermouke.console.builder.form.km8.items.'.$item['type'], array_merge($item, ['sign' => $sign, 'group_alias' => md5(implode(',', $structure['fields']))]))
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="separator separator-dashed my-10" id="acbf_{{ $sign }}_structure_{{ md5(implode(',', array_keys($structure['fields']))) }}_separator"></div>
                @endforeach
                <div class="text-center mt-10" id="acbf_{{ $sign }}_buttons">
                    @if($back)
                        <button data-type="{{ $back['type'] }}" data-did="acbf_{{ $sign }}_back_button" class="btn btn-sm btn-{{ $back['theme'] }} me-3 acbf_button" data-query-url="{{ $back['redirect_uri'] }}" data-method="{{ $back['method'] }}" data-confirm-tip="{{ $back['confirm_tip'] }}" data-redirect-traget="{{ $back['redirect_target'] ? 1 : 0 }}" data-after-ajax="{{ $back['after_ajax'] }}" data-extras="{{ json_encode($back['extras']) }}">
                            <span class="indicator-label">{{ $back['title'] }}</span>
                        </button>
                    @endif
                    @if($submit)
                        <button data-type="{{ $submit['type'] }}" data-did="acbf_{{ $sign }}_submit_button" class="btn btn-sm btn-{{ $submit['theme'] }} me-3 acbf_button" data-query-url="{{ $submit['redirect_uri'] }}" data-method="{{ $submit['method'] }}" data-confirm-tip="{{ $submit['confirm_tip'] }}" data-redirect-traget="{{ $submit['redirect_target'] ? 1 : 0 }}" data-after-ajax="{{ $submit['after_ajax'] }}" data-extras="{{ json_encode($submit['extras']) }}">
                            <span class="indicator-label">{{ $submit['title'] }}</span>
                        </button>
                    @endif
                </div>
            </div>
@if(!$bind_modal_id)
        </div>
    </div>
@endif
@if(!$bind_modal_id)
    <script>
        window.onload = function () {
            //引入实例对象
            createExtraJs('{{ proxy_assets('themes/km8/js/builder/form-builder.js', 'abnermouke') }}', $.form_builder, function () {
                //创建处理实例对象
                $.form_builder.init('{{ $sign }}');
            });
        };
    </script>
@endif
