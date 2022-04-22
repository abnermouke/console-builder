/**
 * abnermouke/console-builder 控制台构建器 - 表格构建器
 * @type {{arrangeParams: (function(*, *): {search_mode: *, shows: [], sort_alias: *, filters: {}, page: *, page_size: *}), init: $.table_builder.init, setExportTrigger: $.table_builder.setExportTrigger, setColumnTrigger: $.table_builder.setColumnTrigger, setSortTrigger: $.table_builder.setSortTrigger, setAdvanceFilterTrigger: $.table_builder.setAdvanceFilterTrigger, setContentTrigger: $.table_builder.setContentTrigger, setDefaultParams: $.table_builder.setDefaultParams, setButtonTrigger: $.table_builder.setButtonTrigger, setPageSizeTrigger: $.table_builder.setPageSizeTrigger, setBasicFilterTrigger: $.table_builder.setBasicFilterTrigger, resetColumnShow: $.table_builder.resetColumnShow, requestLists: $.table_builder.requestLists, resetPagination: $.table_builder.resetPagination}}
 */
$.table_builder = {
    init: function (sign) {
        //获取表格信息
        var table = $("#acbt_" + sign);
        //设置默认参数
        this.setDefaultParams(table, sign);
        //设置基础搜索触发
        this.setBasicFilterTrigger(table, sign);
        //设置高级搜索触发
        this.setAdvanceFilterTrigger(table, sign);
        //设置排序触发
        this.setSortTrigger(table, sign);
        //设置每页查询条数触发
        this.setPageSizeTrigger(table, sign);
        //设置字段触发
        this.setColumnTrigger(table, sign);
        //设置导出触发
        this.setExportTrigger(table, sign);
        //设置刷新触发
        this.setRefreshTrigger(table, sign);
        //设置按钮
        this.setButtonTrigger(table, sign);
        //发起请求
        this.requestLists(table, sign);
        //设置构建完成
        table.attr('data-build', 1);
        //debug
        console.log('Console Builder - Table [' + sign + '] build success!');
    },
    setDefaultParams: function (table, sign) {
        //获取配置缓存
        var localStorageName = window.btoa(window.encodeURIComponent(table.attr('data-action') + '_params')),
            cacheParams = localStorage.getItem(localStorageName), custom_filter = table.attr('data-custom-filter');
        //获取缓存储存对象
        if (typeof (cacheParams) !== 'undefined' && cacheParams !== null && cacheParams.length > 0) {
            //判断是否自定义筛选
            if (parseInt(custom_filter) === 1) {
                //清空缓存
                localStorage.removeItem(localStorageName);
                //设置为空
                cacheParams = [];
            }
            //再次判断是否存在缓存参数
            if (cacheParams.length > 0) {
                //初始化参数信息
                cacheParams = JSON.parse(cacheParams);
                //恢复筛选条件
                if (typeof cacheParams['sort_alias'] !== 'undefined' && cacheParams['sort_alias'].length > 0) {
                    //设置排序条件
                    $("#acbt_"+sign+"_sorts").val(cacheParams['sort_alias']).change();
                }
                //恢复页码
                if (typeof cacheParams['page'] !== 'undefined' && cacheParams['page'].length > 0) {
                    //设置页码
                    table.attr('data-page', parseInt(cacheParams['page']));
                }
                //恢复每页获取条数
                if (typeof cacheParams['page_size'] !== 'undefined' && cacheParams['page_size'].length > 0) {
                    //设置每页获取条数
                    $("#acbt_"+sign+"_page_size").val(cacheParams['page_size']).change();
                    table.attr('data-page-size', parseInt(cacheParams['page_size']));
                }
                //恢复筛选条件
                if (typeof cacheParams['search_mode'] !== 'undefined' && cacheParams['search_mode'].length > 0 && typeof cacheParams['filters'] !== 'undefined' && !$.isEmptyObject(cacheParams['filters'])) {
                    //判断是否为基础筛选
                    if (cacheParams['search_mode'] === 'basic') {
                        //获取对象
                        var basic_input = $("#acbt_"+sign+"_filter_of_basic");
                        //判断参数
                        if (typeof cacheParams['filters'][basic_input.attr('name')] !== 'undefined' && cacheParams['filters'][basic_input.attr('name')].length > 0) {
                            //设置默认参数
                            basic_input.val(cacheParams['filters'][basic_input.attr('name')]).change();
                        }
                    } else {
                        //获取对象
                        var advance_filers = $("#acbt_"+sign+"_advance_filters_box"),
                            advance_trigger = $("#acbt_" + sign + "_filter_of_advance_trigger"),
                            advance_filter_text = $("#acbt_" + sign + "_filter_of_advance_using"),
                            basic_filter_input = $("#acbt_" + sign + "_filter_of_basic_input"),
                            basic_filter_button = $("#acbt_" + sign + "_filter_of_basic_button");
                        //设置显示
                        basic_filter_input.removeClass('d-none').addClass('d-none');
                        basic_filter_button.removeClass('d-none').addClass('d-none');
                        //显示高级搜索文案
                        advance_filter_text.removeClass('d-none');
                        //更改文案
                        advance_trigger.text('普通搜索');
                        advance_trigger.attr('aria-expanded', true);
                        advance_filers.removeClass('show').addClass('show');
                        //循环参数
                        $.each(cacheParams['filters'], function (field, value) {
                            //判断参数是否为空
                            if (value.length > 0) {
                                //获取对象
                                var filter = advance_filers.find('.acbt_filter_item[data-field="'+field+'"]'), filter_target = filter.attr('data-target');
                                //查询对应type
                                switch (filter.attr('data-type')) {
                                    case 'tags':
                                        //设置默认值
                                        $(filter_target).val(value.join(', ')).change();
                                        break;
                                    case 'date_range':
                                        //设置默认值
                                        $(filter_target).val(value.join(' 至 ')).change();
                                        break;
                                    case 'switch':
                                        //设置默认值
                                        if (value === $(filter_target).attr('data-on-value')) {
                                            //设置选中
                                            $(filter_target).prop('checked', true).change();
                                        } else {
                                            //设置不选中
                                            $(filter_target).prop('checked', false).change();
                                        }
                                        break;
                                    case 'group':
                                        //取消所有选中
                                        $(filter_target).prop('checked', false).change();
                                        //设置默认选中
                                        $(filter_target+"[value='"+value+"']").prop('checked', true).change();
                                        break;
                                    default:
                                        $(filter_target).val(value).change();
                                        break;
                                }
                            }
                        });
                    }
                    //设置搜索模式
                    table.attr('data-search-mode', cacheParams['search_mode']);
                }
            }
        }
    },
    setButtonTrigger: function (table, sign) {
        //获取基础对象
        var buttons = $("#acbt_" + sign + "_buttons"), toolbars = $("#kt_dashboard_toolbar_items"), __this = this,
            table_content = $("#acbt_" + sign + "_content"), table_box = $("#acbt_" + sign + "_table");
        //判断对象是否存在
        if (typeof (buttons) !== 'undefined' && parseInt(buttons.length) > 0) {
            //转移内容
            moveToToolbar(buttons.html(), '.acbt_button');
            //移除元素
            buttons.remove();
        }
        //循环按钮
        toolbars.find('.acbt_button').on('click', function () {
            //获取对象配置
            var confirm_tip = $(this).attr('data-confirm-tip'), query_url = $(this).attr('data-query-url'),
                method = $(this).attr('data-method'), type = $(this).attr('data-type'),
                target_redirect = $(this).attr('data-target-redirect'),
                extras = JSON.parse($(this).attr('data-extras')), ajax_after = $(this).attr('data-ajax-after'), bind_checkbox = $(this).attr('data-bind-checkbox'), checked_params = {}, table_box = $("#acbt_"+sign+"_table_box");
            //判断是否绑定checkbox
            if (parseInt(bind_checkbox) === 1) {
                //设置信息
                checked_params[table_box.attr('data-checkbox')] = [];
                //循环选中信息
                table_box.find('input.acbt_'+sign+'_table_select_item:checked').each(function () {
                    //添加value
                    checked_params[table_box.attr('data-checkbox')].push($(this).val());
                });
                //查询长度
                if (checked_params[table_box.attr('data-checkbox')].length <= 0) {
                    //提示错误
                    alertToast('请至少选择一项后操作', 2000, 'warning');
                    //返回失败
                    return false;
                }
                //设置参数
                extras['params'] = checked_params;
            }
            //封装统一执行内容
            var query_func = function () {
                //根据类型处理
                switch (type) {
                    case 'form':
                        //设置默认参数
                        var param_fields = {}, body = $('body'), bind_modal_id = 'acbt_'+sign+'_modal_with_form_of_'+randomString(8);
                        //添加标识
                        param_fields['table_sign'] = sign;
                        param_fields['bind_table_id'] = table.attr('id');
                        param_fields['bind_modal_id'] = bind_modal_id;
                        param_fields['params'] = {};
                        //判断参数默认是否存在
                        if (typeof (extras['params']) !== 'undefined') {
                            //设置默认参数
                            param_fields['params'] = extras['params'];
                        }
                        //加载loading
                        var loading = loadingStart(table_box, table[0], '正在加载...');
                        //创建请求
                        buildRequest(query_url, param_fields, method, true, function (res) {
                            //设置内容
                            var modal_html = '<div class="modal fade acb_table_form_modal" id="'+bind_modal_id+'"><div class="modal-dialog modal-dialog-centered modal-'+extras['modal_size']+'" role="document"><div class="modal-content"><div class="modal-header py-5"><h5 class="modal-title"></h5><button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2 acb_table_form_modal_close_icon" data-bs-dismiss="modal" aria-label="Close" id="'+bind_modal_id+'_close_icon"><i aria-hidden="true" class="fa fa-times"></i></button></div><div class="modal-body mh-700px overflow-auto">'+res.data['html']+'</div><div class="modal-footer" id="'+bind_modal_id+'_footer"></div></div></div></div>'
                            //添加内容
                            body.append(modal_html);
                            //显示弹窗
                            new bootstrap.Modal($("#"+bind_modal_id)[0], {backdrop: 'static', keyboard: false}).show();
                            //引入实例对象
                            createExtraJs(table.attr('data-source-path')+'/form-builder.js', $.form_builder, function () {
                                //创建处理实例对象
                                $.form_builder.init($("#"+bind_modal_id).find('.acb-form-builder.form').attr('data-sign'));
                            });
                            //触发关闭弹窗事件
                            $("#"+bind_modal_id).on('hidden.bs.modal', function () {
                                //删除弹窗
                                $("#"+bind_modal_id).remove();
                            });
                            //添加
                        }, function (res) {
                            //提示错误
                            alertToast(res.msg, 2000, 'error');
                        }, function () {
                            //关闭弹窗
                            loadingStop(loading, table_box);
                        })
                        break;
                    case 'link':
                        //判断是否存在参数
                        if (typeof (extras['params']) !== 'undefined' && !$.isEmptyObject(extras['params'])) {
                            //整理链接参数
                            var url_params = [];
                            //循环参数配置信息
                            $.each(extras['params'], function (i, item) {
                                //设置链接参数
                                url_params.push(i + '=' + item);
                            })
                            //设置链接信息
                            query_url += (query_url.indexOf('?') >= 0 ? '' : '?') + url_params.join('&');
                        }
                        //判断是否新开页面跳转
                        if (typeof (target_redirect) !== 'undefined' && target_redirect.length > 0 && parseInt(target_redirect) === 1) {
                            //新开页面打开链接
                            window.open(query_url);
                        } else {
                            //当前页面打开
                            window.location.href = query_url;
                        }
                        break;
                    case 'ajax':
                        //判断参数默认是否存在
                        if (typeof (extras['params']) == 'undefined') {
                            //设置默认参数
                            extras['params'] = {};
                        }
                        //加载loading
                        var loading = loadingStart(table_box, table[0], '正在处理...');
                        //创建请求
                        buildRequest(query_url, extras['params'], method, true, function (res) {
                            //根据配置处理
                            switch (ajax_after) {
                                case 'refresh':
                                    //刷新当前列表
                                    __this.requestLists(table, sign);
                                    break;
                                case 'reload':
                                    //刷新当前页面
                                    window.location.reload();
                                    break;
                                default:
                                    //跳转页面
                                    window.location.href = ajax_after;
                                    break;
                            }
                        }, function (res) {
                            //提示错误
                            alertToast(res.msg, 2000, 'error');
                        }, function () {
                            //关闭弹窗
                            loadingStop(loading, table_box);
                        })
                        break;
                }
            };
            //判断是否提示信息
            if (typeof (confirm_tip) !== 'undefined' && confirm_tip.length > 0) {
                //提示信息
                confirmPopup(confirm_tip, function () {
                    //执行内容
                    query_func();
                });
            } else {
                //直接执行内容
                query_func();
            }
        });
    },
    resetColumnShow: function (table, sign, show_fields) {
        //获取基础对象
        var fields = $("#acbt_" + sign + "_fields"), table_box = $("#acbt_"+sign+"_table_box");
        //整理字段信息
        show_fields = show_fields.split(',');
        //循环字段
        $.each(show_fields, function (i, item) {
            //设置选中
            fields.find('#acbt_' + sign + '_field_' + item).prop('checked', true).change();
        });
        //循环th
        table_box.find('.acbt_table_thead_th').each(function () {
            //获取字段
            var field = $(this).attr('data-field');
            //判断是否显示
            if (parseInt($.inArray(field, show_fields)) >= 0) {
                //显示对象
                $(this).removeClass('d-none');
                //显示内容
                table_box.find('.acbt_table_tbody_td[data-field="'+field+'"]').removeClass('d-none');
            } else {
                //显示对象
                $(this).removeClass('d-none').addClass('d-none');
                //显示内容
                table_box.find('.acbt_table_tbody_td[data-field="'+field+'"]').removeClass('d-none').addClass('d-none');
            }
        });
    },
    setRefreshTrigger: function (table, sign) {
        //获取处理对象
        var table_refresh = $("#acbt_"+sign+"_refresh"), _this = this;
        //设置导出触发
        table_refresh.on('click', function () {
            // 刷新列表
            _this.requestLists(table, sign);
        });
    },
    setExportTrigger: function (table, sign) {
        //获取处理对象
        var table_export = $("#acbt_"+sign+"_export");
        //引入实例对象
        createExtraJs(table_export.attr('data-plugin-import-path'), $.table2excel, function () {
            //设置导出触发
            table_export.on('click', function () {
                //获取对象
                var table_box = $("#acbt_"+sign+"_table_box"), loading = loadingStart(table_box, table[0], '正在导出数据...');
                //忽略隐藏项
                table_box.find('.acbt_table_thead_th').each(function () {
                    //判断是否存在隐藏
                    if ($(this).hasClass('d-none')) {
                        //添加样式
                        $(this).removeClass('export_ignore').addClass('export_ignore');
                    }
                });table_box.find('.acbt_table_tbody_td').each(function () {
                    //判断是否存在隐藏
                    if ($(this).hasClass('d-none')) {
                        //添加样式
                        $(this).removeClass('export_ignore').addClass('export_ignore');
                    }
                });
                //导出表格数据
                $("#acbt_"+sign+"_table_box").table2excel({
                    exclude: ".export_ignore",
                    name: "ConsoleBuilderExport",
                    filename: sign,
                    preserveColors: true,
                    exclude_img: true
                });
                //删除非必要样式
                table_box.find('.acbt_table_thead_th').removeClass('export_ignore');
                table_box.find('.acbt_table_tbody_td').removeClass('export_ignore');
                //关闭弹窗
                loadingStop(loading, table_box);
                //提示信息
                alertToast('导出当前列表成功，EXCEL如有空白请留意背景颜色是否与字体颜色一致！', 3500, 'info', '表格内容导出')
            });
        });
    },
    setColumnTrigger: function (table, sign) {
        //获取基础对象
        var fields = $("#acbt_" + sign + "_fields"), reset_field = $("#acbt_" + sign + "_fields_to_reset"),
            submit_field = $("#acbt_" + sign + "_fields_to_submit"), __this = this,
            default_fields = reset_field.attr('data-default-fields'),
            localStorageName = window.btoa(window.encodeURIComponent(table.attr('data-action') + '_fields')),
            cacheFields = localStorage.getItem(localStorageName);
        //获取缓存储存对象
        if (typeof (cacheFields) !== 'undefined' && cacheFields !== null && cacheFields.length > 0) {
            //使用缓存字段
            default_fields = cacheFields;
        }
        //重置显示栏
        __this.resetColumnShow(table, sign, default_fields);
        //重置触发
        reset_field.on('click', function () {
            //移除所有选中
            fields.find('input:checkbox').prop('checked', false).change();
            //设置默认显示字段
            default_fields = reset_field.attr('data-default-fields');
            //循环默认字段
            $.each(default_fields.split(','), function (i, item) {
                //设置选中
                fields.find('#acbt_' + sign + '_field_' + item).prop('checked', true).change();
            });
            //重置显示栏
            __this.resetColumnShow(table, sign, default_fields);
            //储存缓存
            localStorage.removeItem(localStorageName);
        });
        //更改触发
        submit_field.on('click', function () {
            //初始化默认字段
            default_fields = [];
            //循环字段
            fields.find('input:checkbox').each(function () {
                //判断是否选中
                if ($(this).is(':checked')) {
                    //添加默认字段
                    default_fields.push($(this).val());
                }
            });
            //判断长度
            if (default_fields.length <= 0) {
                //提示信息
                alertToast('请至少显示一个字段', 1500, 'info');
                //停止执行
                return true;
            } else {
                //重置字段
                default_fields = default_fields.join(',');
                //重置显示栏
                __this.resetColumnShow(table, sign, default_fields);
                //判断是否更改
                if (default_fields === reset_field.attr('data-default-fields')) {
                    //储存缓存
                    localStorage.removeItem(localStorageName);
                } else {
                    //储存缓存
                    localStorage.setItem(localStorageName, default_fields);
                }
            }
        });
    },
    setBasicFilterTrigger: function (table, sign) {
        //获取基础搜索对象
        var filter = $("#acbt_" + sign + "_filter_of_basic"),
            submit_filter = $("#acbt_" + sign + "_filter_of_basic_to_submit"), __this = this;
        //判断触发对象是否存在
        if (typeof (submit_filter) !== 'undefined' && parseInt(submit_filter.length) > 0) {
            //设置点击触发
            submit_filter.on('click', function () {
                //重置页码信息
                __this.resetPagination(table, sign);
                //请求列表
                __this.requestLists(table, sign);
            });
        }
    },
    setAdvanceFilterTrigger: function (table, sign) {
        //获取高级搜索对象
        var advance_trigger = $("#acbt_" + sign + "_filter_of_advance_trigger"),
            filters = $("#acbt_" + sign + "_advance_filters"),
            submit_filters = $("#acbt_" + sign + "_filter_of_advance_to_submit"),
            reset_filters = $("#acbt_" + sign + "_filter_of_advance_to_reset"), __this = this;
        //判断触发对象是否存在
        if (typeof (filters) !== 'undefined' && parseInt(filters.length) > 0) {
            //获取搜索对象
            var advance_filter_text = $("#acbt_" + sign + "_filter_of_advance_using"),
                basic_filter_input = $("#acbt_" + sign + "_filter_of_basic_input"),
                basic_filter_button = $("#acbt_" + sign + "_filter_of_basic_button");
            //点击监听
            advance_trigger.on('click', function () {
                //判断是否开启
                if (advance_trigger.attr('aria-expanded') === 'true') {
                    //隐藏基本搜索方式
                    basic_filter_input.removeClass('d-none').addClass('d-none');
                    basic_filter_button.removeClass('d-none').addClass('d-none');
                    //显示高级搜索文案
                    advance_filter_text.removeClass('d-none');
                    //更改文案
                    advance_trigger.text('普通搜索');
                    //设置搜索模式
                    table.attr('data-search-mode', 'advance');
                } else {
                    //展开基础搜索方式
                    basic_filter_input.removeClass('d-none');
                    basic_filter_button.removeClass('d-none');
                    //隐藏高级搜索文案
                    advance_filter_text.removeClass('d-none').addClass('d-none');
                    //更改文案
                    advance_trigger.text('高级搜索');
                    //设置搜索模式
                    table.attr('data-search-mode', 'basic');
                }
            });
        }
        //判断筛选对象是否存在
        if (typeof (filters) !== 'undefined' && parseInt(filters.length) > 0) {
            //循环筛选对象
            filters.find('.acbt_filter_item').each(function () {
                //获取内容
                var filter_type = $(this).attr('data-type'), filter_target = $(this).attr('data-target');
                //根据对应类型处理
                switch (filter_type) {
                    case 'tags':
                        //实例化标签
                        new Tagify(document.querySelector(filter_target));
                        break;
                    case 'date':
                    case 'date_range':
                        //获取显示格式
                        var filter_date_format = $(filter_target).attr('data-format'), filter_date_params = {
                            locale: "zh",
                            altFormat: filter_date_format,
                            dateFormat: filter_date_format,
                        };
                        //判断是否需要显示时间
                        if (filter_date_format.indexOf('H') >= 0 || filter_date_format.indexOf('h') >= 0 || filter_date_format.indexOf('i') >= 0 || filter_date_format.indexOf('s') >= 0) {
                            //添加小时支持
                            filter_date_params['enableTime'] = filter_date_params['time_24hr'] = true;
                        }
                        //判断是否为range
                        if (filter_type === 'date_range') {
                            //添加范围支持
                            filter_date_params['mode'] = 'range';
                        }
                        //实例化日期
                        $(filter_target).flatpickr(filter_date_params);
                        break;
                }
            });
        }
        //判断清空筛选项是否存在
        if (typeof (reset_filters) !== 'undefined' && parseInt(reset_filters.length) > 0) {
            //设置点击触发
            reset_filters.on('click', function () {
                //循环筛选对象
                filters.find('.acbt_filter_item').each(function () {
                    //获取内容
                    var filter_type = $(this).attr('data-type'), filter_target = $(this).attr('data-target');
                    //根据对应类型处理
                    switch (filter_type) {
                        case 'select':
                            //设置不选中
                            $(filter_target).find('option:selected').removeAttr('selected');
                            //延迟触发
                            setTimeout(function () {
                                $(filter_target).val('__WITHOUT_ANY_VALUE__').change();
                            }, 200);
                            break;
                        case 'group':
                            //设置不选中
                            $(filter_target).prop('checked', false).change();
                            $(filter_target+"[value='__IGNORE__']").prop('checked', true).change();
                            break;
                        case 'switch':
                            //设置不选中
                            $(filter_target).prop('checked', false).change();
                            break;
                        default:
                            //清空输入值
                            $(filter_target).val('').change();
                            break;
                    }
                });
                //重置页码信息
                __this.resetPagination(table, sign);
            });
        }
        //判断确认筛选项是否存在
        if (typeof (submit_filters) !== 'undefined' && parseInt(submit_filters.length) > 0) {
            //设置点击触发
            submit_filters.on('click', function () {
                //重置页码信息
                __this.resetPagination(table, sign);
                //请求列表
                __this.requestLists(table, sign);
            });
        }
    },
    setSortTrigger: function (table, sign) {
        //获取排序对象
        var table_sorts = $("#acbt_" + sign + "_sorts"), __this = this;
        //判断是否存在排序对象
        if (typeof (table_sorts) !== 'undefined' && parseInt(table_sorts.length) > 0) {
            //监听变化
            table_sorts.on('change', function () {
                //重置页码信息
                __this.resetPagination(table, sign);
                //请求列表
                __this.requestLists(table, sign);
            });
        }
    },
    setPageSizeTrigger: function (table, sign) {
        //获取每页条数配置对象
        var table_page_size = $("#acbt_" + sign + "_page_size"), __this = this;
        //判断是否存在对象
        if (typeof (table_page_size) !== 'undefined' && parseInt(table_page_size.length) > 0) {
            //监听变化
            table_page_size.on('change', function () {
                //设置参数
                table.attr('data-page-size', table_page_size.val());
                //重置页码信息
                __this.resetPagination(table, sign);
                //请求列表
                __this.requestLists(table, sign);
            });
        }
    },
    setContentTrigger: function (table, sign) {
        //获取处理对象
        var table_box = $("#acbt_"+sign+"_table_box"), table_body = $("#acbt_"+sign+"_table_tbody"), total_count = $("#acbt_"+sign+"_data_total_count"), matched_count = $("#acbt_"+sign+"_data_matched_count"), table_checkbox_select_all = table_box.find('#acbt_'+sign+'_table_select_all'), table_checkbox_trigger_buttons = table.attr('data-checkbox-trigger-buttons'), table_pagination= $("#acbt_"+sign+"_table_pagination"), table_actions =  table_body.find('.acbt_'+sign+'_table_tbody_td_actions'), __this = this;
        //判断是否存在对象
        if (typeof (table_box) !== 'undefined' && parseInt(table_box.length) > 0) {
            //设置统计数值
            total_count.text(parseInt(table_box.attr('data-total-count')));
            matched_count.text(parseInt(table_box.attr('data-matched-count')));
        }
        //判断是否存在checkbox
        if (typeof table_checkbox_select_all !== 'undefined' && table_checkbox_select_all.length > 0 && table_checkbox_trigger_buttons.length > 0) {
            //全选触发
            table_checkbox_select_all.on('change', function () {
                //判断是否选中
                if ($(this).is(':checked')) {
                    //设置选中
                    table_body.find('input.acbt_'+sign+'_table_select_item').prop('checked', true);
                    //滑动页面
                    scrollToObject($('body'));
                } else {
                    //设置全部不选中
                    table_body.find('input.acbt_'+sign+'_table_select_item').prop('checked', false);
                }
                //触发
                table_body.find('input.acbt_'+sign+'_table_select_item').eq(0).change();
            });
            //整理按钮后缀
            table_checkbox_trigger_buttons = table_checkbox_trigger_buttons.split(',');
            //设置触发
            table_body.find('input.acbt_'+sign+'_table_select_item').on('change', function () {
                //获取选中个数
                var checked_count = table_body.find('input.acbt_'+sign+'_table_select_item:checked').length;
                //判断是否大于0
                if (parseInt(checked_count) > 0) {
                    //判断长度一致
                    if (parseInt(checked_count) === parseInt(table_body.find('input.acbt_'+sign+'_table_select_item').length)) {
                        //设置全选
                        table_checkbox_select_all.prop('checked', true);
                    } else {
                        //取消全选
                        table_checkbox_select_all.prop('checked', false);
                    }
                    //显示触发按钮
                    $.each(table_checkbox_trigger_buttons, function (i, item) {
                        // 设置显示
                        $("#acbt_"+sign+"_button_"+item).removeClass('d-none');
                    });
                } else {
                    //取消全选
                    table_checkbox_select_all.prop('checked', false);
                    //隐藏触发按钮
                    $.each(table_checkbox_trigger_buttons, function (i, item) {
                        // 设置隐藏
                        $("#acbt_"+sign+"_button_"+item).removeClass('d-none').addClass('d-none');
                    });
                }
            });
            //取消全选
            table_checkbox_select_all.prop('checked', false).change();
            //隐藏触发按钮
            $.each(table_checkbox_trigger_buttons, function (i, item) {
                // 设置隐藏
                $("#acbt_"+sign+"_button_"+item).removeClass('d-none').addClass('d-none');
            });
        }
        //判断页码是否存在
        if (typeof table_pagination !== 'undefined' && table_pagination.length > 0) {
            //页码切换
            table_pagination.find('li.page-item').on('click', function () {
                //判断是否不可用
                if (!$(this).hasClass('disabled') && !$(this).hasClass('active')) {
                    //设置页码
                    table.attr('data-page', $(this).attr('data-page'));
                    //请求列表
                    __this.requestLists(table, sign);
                }
            });
        }
        //判断数据处理是否存在
        if (typeof table_actions !== 'undefined' && table_actions.length > 0) {
            //点击操作
            table_actions.find('.acbt_'+sign+'_table_action_item').on('click', function () {
                //获取对象配置
                var confirm_tip = $(this).attr('data-confirm-tip'), query_url = $(this).attr('data-query-url'),
                    method = $(this).attr('data-method'), type = $(this).attr('data-type'),
                    target_redirect = $(this).attr('data-target-redirect'),
                    extras = JSON.parse($(this).attr('data-extras')), ajax_after = $(this).attr('data-ajax-after'), param_fields = JSON.parse($(this).attr('data-param-fields'));
                //封装统一执行内容
                var query_func = function () {
                    //根据类型处理
                    switch (type) {
                        case 'form':
                            //判断参数默认是否存在
                            if (typeof (param_fields) == 'undefined' || $.isEmptyObject(param_fields)) {
                                //设置默认参数
                                param_fields = {};
                            }
                            //生成modal内容
                            var body = $('body'), bind_modal_id = 'acbt_'+sign+'_modal_with_form_of_'+randomString(8);
                            //添加标识
                            param_fields['table_sign'] = sign;
                            param_fields['bind_table_id'] = table.attr('id');
                            param_fields['bind_modal_id'] = bind_modal_id;
                            //加载loading
                            var loading = loadingStart(table_box, table[0], '正在加载...');
                            //创建请求
                            buildRequest(query_url, param_fields, method, true, function (res) {
                                //设置内容
                                var modal_html = '<div class="modal fade acb_table_form_modal" id="'+bind_modal_id+'" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-'+extras['modal_size']+'" role="document"><div class="modal-content"><div class="modal-header py-5"><h5 class="modal-title"></h5><button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2 acb_table_form_modal_close_icon" data-bs-dismiss="modal" aria-label="Close" id="'+bind_modal_id+'_close_icon"><i aria-hidden="true" class="fa fa-times"></i></button></div><div class="modal-body mh-700px overflow-auto">'+res.data['html']+'</div><div class="modal-footer" id="'+bind_modal_id+'_footer"></div></div></div></div>'
                                //添加内容
                                body.append(modal_html);
                                //显示弹窗
                                new bootstrap.Modal($("#"+bind_modal_id)[0], {backdrop: 'static', keyboard: false}).show();
                                //引入实例对象
                                createExtraJs(table.attr('data-source-path')+'/form-builder.js', $.form_builder, function () {
                                    //创建处理实例对象
                                    $.form_builder.init($("#"+bind_modal_id).find('.acb-form-builder.form').attr('data-sign'));
                                });
                                //触发关闭弹窗事件
                                $("#"+bind_modal_id).on('hidden.bs.modal', function () {
                                    //删除弹窗
                                    $("#"+bind_modal_id).remove();
                                });
                                //添加
                            }, function (res) {
                                //提示错误
                                alertToast(res.msg, 2000, 'error');
                            }, function () {
                                //关闭弹窗
                                loadingStop(loading, table_box);
                            })
                            break;
                        case 'modal':
                            //判断参数默认是否存在
                            if (typeof (param_fields) == 'undefined' || $.isEmptyObject(param_fields)) {
                                //设置默认参数
                                param_fields = {};
                            }
                            //生成modal内容
                            var body = $('body'), bind_modal_target = 'acbt_'+sign+'_modal_with_modal_of_'+randomString(8);
                            //判断是否设置target
                            if (typeof extras['modal_target'] !== 'undefined' && extras['modal_target'].length > 0) {
                                //设置绑定ID
                                bind_modal_target = extras['modal_target'];
                            } else {
                                //设置内容
                                var modal_html = '<div class="modal fade acb_table_bind_modal" id="'+bind_modal_target+'" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-'+extras['modal_size']+'" role="document"><div class="modal-content"><div class="modal-header pb-0 border-0 justify-content-end"><button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2 acb_table_form_modal_close_icon" data-bs-dismiss="modal" aria-label="Close" id="'+bind_modal_target+'_close_icon"><i aria-hidden="true" class="fa fa-times"></i></button></div><div class="modal-body mh-700px overflow-auto"></div></div></div></div>'
                                //添加内容
                                body.append(modal_html);
                            }
                            //加载loading
                            var loading = loadingStart(table_box, table[0], '正在加载...');
                            //创建请求
                            buildRequest(query_url, param_fields, method, true, function (res) {
                                //设置内容
                                $("#"+bind_modal_target).find('.modal-body').empty().html(res.data['html']);
                                //显示弹窗
                                new bootstrap.Modal($("#"+bind_modal_target)[0], {backdrop: 'static', keyboard: false}).show();
                                //触发关闭弹窗事件
                                $("#"+bind_modal_target).on('hidden.bs.modal', function () {
                                    //判断是否设置target
                                    if (typeof extras['modal_target'] === 'undefined' || extras['modal_target'].length <= 0) {
                                        //删除当前modal
                                        $("#"+bind_modal_target).remove();
                                    }
                                    //根据配置处理
                                    switch (ajax_after) {
                                        case 'refresh':
                                            //刷新当前列表
                                            __this.requestLists(table, sign);
                                            break;
                                        case 'reload':
                                            //刷新当前页面
                                            window.location.reload();
                                            break;
                                        default:
                                            //跳转页面
                                            window.location.href = ajax_after;
                                            break;
                                    }
                                });
                                //添加
                            }, function (res) {
                                //提示错误
                                alertToast(res.msg, 2000, 'error');
                            }, function () {
                                //关闭弹窗
                                loadingStop(loading, table_box);
                            })
                            break;
                        case 'link':
                            //判断是否存在参数
                            if (typeof (param_fields) !== 'undefined' && !$.isEmptyObject(param_fields)) {
                                //整理链接参数
                                var url_params = [];
                                //循环参数配置信息
                                $.each(param_fields, function (i, item) {
                                    //设置链接参数
                                    url_params.push(i + '=' + item);
                                })
                                //设置链接信息
                                query_url += (query_url.indexOf('?') >= 0 ? '' : '?') + url_params.join('&');
                            }
                            //判断是否新开页面跳转
                            if (typeof (target_redirect) !== 'undefined' && target_redirect.length > 0 && parseInt(target_redirect) === 1) {
                                //新开页面打开链接
                                window.open(query_url);
                            } else {
                                //当前页面打开
                                window.location.href = query_url;
                            }
                            break;
                        case 'ajax':
                            //判断参数默认是否存在
                            if (typeof (param_fields) == 'undefined') {
                                //设置默认参数
                                param_fields = {};
                            }
                            //加载loading
                            var loading = loadingStart(table_box, table[0], '正在处理...');
                            //创建请求
                            buildRequest(query_url, param_fields, method, true, function (res) {
                                //根据配置处理
                                switch (ajax_after) {
                                    case 'refresh':
                                        //刷新当前列表
                                        __this.requestLists(table, sign);
                                        break;
                                    case 'reload':
                                        //刷新当前页面
                                        window.location.reload();
                                        break;
                                    default:
                                        //跳转页面
                                        window.location.href = ajax_after;
                                        break;
                                }
                            }, function (res) {
                                //提示错误
                                alertToast(res.msg, 2000, 'error');
                            }, function () {
                                //关闭弹窗
                                loadingStop(loading, table_box);
                            })
                            break;
                    }
                };
                //判断是否提示信息
                if (typeof (confirm_tip) !== 'undefined' && confirm_tip.length > 0) {
                    //提示信息
                    confirmPopup(confirm_tip, function () {
                        //执行内容
                        query_func();
                    });
                } else {
                    //直接执行内容
                    query_func();
                }
            });
        }
        //重置下拉选择
        KTMenu.createInstances();
        //重置tooltip
        KTApp.initBootstrapTooltips();
    },
    resetPagination: function (table, sign) {
        //设置页码
        table.attr('data-page', 1);
    },
    requestLists: function (table, sign) {
        //获取处理对象
        var table_content = $("#acbt_" + sign + "_content"), table_box = $("#acbt_" + sign + "_table"),
            query_url = table.attr('data-action'), method = table.attr('data-method'),
            loading = loadingStart(table_box, table_content[0], '正在查询最新内容...'), __this = this;
        //执行请求
        buildRequest(query_url, __this.arrangeParams(table, sign), method, true, function (res) {
            //设置内容
            table_content.empty().html(res.data['html']);
            //设置触发
            __this.setContentTrigger(table, sign);
            //滑动到列表顶端
            scrollToObject(table);
        }, function (res) {
            //提示失败
            alertToast(res.msg, 2000, 'error');
        }, function () {
            //关闭加载
            loadingStop(loading, table_box);
        })
    },
    arrangeParams: function (table, sign) {
        //整理请求参数
        var  search_mode = table.attr('data-search-mode'), params = {
            sort_alias: $("#acbt_" + sign + "_sorts").val(),
            shows: [],
            filters: {},
            search_mode: search_mode,
            page: table.attr('data-page'),
            page_size: table.attr('data-page-size'),
        }, fields = $("#acbt_" + sign + "_fields"), __this = this;
        //循环字段
        fields.find('input:checkbox').each(function () {
            //判断是否选中
            if ($(this).is(':checked')) {
                //添加默认字段
                params['shows'].push($(this).val());
            }
        });
        //判断搜索模式
        if (search_mode === 'advance') {
            //获取基础对象
            var advance_filers = $("#acbt_" + sign + "_advance_filters");
            //判断筛选对象是否存在
            if (typeof (advance_filers) !== 'undefined' && parseInt(advance_filers.length) > 0) {
                //循环筛选对象
                advance_filers.find('.acbt_filter_item').each(function () {
                    //获取内容
                    var filter_type = $(this).attr('data-type'), filter_target = $(this).attr('data-target'),
                        filter_field = $(this).attr('data-field'), filter_value = $(filter_target).val();
                    //根据对应类型处理
                    switch (filter_type) {
                        case 'tags':
                            //判断值内容
                            if (typeof (filter_value) !== 'undefined' && filter_value.length > 0) {
                                //设置条件
                                params['filters'][filter_field] = [];
                                //循环内容
                                $.each(JSON.parse(filter_value), function (i, item) {
                                    //新增字段
                                    params['filters'][filter_field].push(item.value);
                                });
                            }
                            break;
                        case 'date_range':
                            //判断值内容
                            if (typeof (filter_value) !== 'undefined' && filter_value.length > 0) {
                                //设置条件
                                params['filters'][filter_field] = filter_value.split(' 至 ');
                            }
                            break;
                        case 'select':
                            //判断值内容
                            if (typeof (filter_value) !== 'undefined' && filter_value && filter_value.length > 0 && filter_value !== '__WITHOUT_ANY_VALUE__') {
                                //设置条件
                                params['filters'][filter_field] = filter_value;
                            }
                            break;
                        case 'group':
                            //重置值
                            filter_value = $(this).find(filter_target + ":checked").val();
                            //判断值内容
                            if (typeof (filter_value) !== 'undefined' && filter_value.length > 0 && filter_value !== '__IGNORE__') {
                                //设置条件
                                params['filters'][filter_field] = filter_value;
                            }
                            break;
                        case 'dialer':
                            //判断值内容
                            if (typeof (filter_value) !== 'undefined' && filter_value.length > 0 && filter_value !== '0.0') {
                                //设置条件
                                params['filters'][filter_field] = filter_value;
                            }
                            break;
                        case 'switch':
                            //判断是否选中
                            if ($(filter_target).is(':checked')) {
                                //设置筛选条件
                                params['filters'][filter_field] = $(filter_target).attr('data-on-value');
                            }
                            break;
                        default:
                            //判断值内容
                            if (typeof (filter_value) !== 'undefined' && filter_value.trim().length > 0) {
                                //设置条件
                                params['filters'][filter_field] = filter_value;
                            }
                            break;
                    }
                });
            }
        } else {
            //获取基础搜索相关对象
            var basic_filter_input = $("#acbt_" + sign + "_filter_of_basic"),
                basic_filter_value = basic_filter_input.val();
            //判断值内容
            if (typeof (basic_filter_value) !== 'undefined' && basic_filter_value.trim().length > 0) {
                //设置条件
                params['filters'][basic_filter_input.attr('name')] = basic_filter_value;
            }
        }
        //储存缓存
        localStorage.setItem(window.btoa(window.encodeURIComponent(table.attr('data-action') + '_params')), JSON.stringify(params));
        //设置签名信息
        params['signature'] = $("#acbt_" + sign + "_signature").text().trim();
        //返回参数
        return params;
    }
}

