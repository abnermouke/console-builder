/**
 * abnermouke/console-builder 控制台构建器 - 表单构建器
 */
$.form_builder = {
    init: function (sign) {
        //获取表单信息
        var form = $("#acbf_" + sign);
        //设置表单项以及触发
        this.setTriggers(form, sign);
        //设置字段触发
        this.setFieldTriggers(form, sign);
        //设置构建完成
        form.attr('data-build', 1);
        //重置tooltip
        KTApp.initBootstrapTooltips();
        //debug
        console.log('Console Builder - Form [' + sign + '] build success!');
    },
    setTriggers: function (form, sign) {
        //获取基础对象
        var buttons = $("#acbf_" + sign + "_buttons"), titles = $("#acbf_"+sign+"_titles"), toolbars = $("#kt_dashboard_toolbar_items"), bind_modal_id = form.attr('data-bind-modal-id'), __this = this;
        //判断对象是否存在
        if (typeof (buttons) !== 'undefined' && parseInt(buttons.length) > 0) {
            //判断是否为modal
            if (typeof (bind_modal_id) === 'undefined' || bind_modal_id.length <= 0) {
                //转移内容
                moveToToolbar(buttons.html(), '.acbf_button');
            } else {
                $("#"+bind_modal_id).find('.modal-footer').empty().html(buttons.html());
                //移除元素
                buttons.remove();
            }
        }
        //判断对象是否存在
        if (typeof (titles) !== 'undefined' && parseInt(titles.length) > 0) {
            //判断是否为modal
            if (typeof (bind_modal_id) !== 'undefined' && bind_modal_id.length > 0) {
                //设置内容
                $("#"+bind_modal_id).find('.modal-header>h5').text(titles.find('h3').text());
                //删除头部
                titles.remove();
            }
        }
        //构建表单项
        this.buildItems(form, sign);
        //设置表单项触发
        this.setItemTriggers(form, sign);
        //触发其他操作
        this.setActionTrigger(form, sign);
        //触发按钮操作
        this.setButtonTrigger(form, sign);
        //判断是否为modal
        if (typeof (bind_modal_id) !== 'undefined' && bind_modal_id.length > 0) {
            //删除最后一栏结构下划线
            $("#acbf_" + sign + "_structure_" + form.find(".acbf_" + sign + "_structure_group:last").attr('data-group-alias') + "_separator").remove();
        }
    },
    setFieldTriggers: function (form, sign) {
        //设置结构触发
        var structure_group_trigger = function () {
            //循环所有结构
            form.find('.acbf_'+sign+'_structure_group').each(function () {
                //获取基础信息
                var group = $(this), separator = $("#acbf_"+sign+"_structure_"+group.attr('data-group-alias')+"_separator");
                //判断是否全部隐藏
                if (group.find('.acbf_'+sign+'_item_box.d-none').length >= group.find('.acbf_'+sign+'_item_box').length) {
                    //隐藏内容
                    group.removeClass('d-none').addClass('d-none');
                    separator.removeClass('d-none').addClass('d-none');
                } else {
                    //显示内容
                    group.removeClass('d-none');
                    separator.removeClass('d-none');
                }
            });
        };
        //循环表单对象信息
        form.find('.acbf_'+sign+'_item_box').each(function () {
            //获取基础数据
            var _this = $(this), type = _this.attr('data-type'), target = $(this).attr('data-target');
            //判断触发类型
            if ($.inArray(type, ['radio', 'normal_radio', 'image_radio', 'switch']) > -1) {
                //获取触发规则
                var triggers = JSON.parse(_this.attr('data-triggers'));
                //判断不为空
                if (!$.isEmptyObject(triggers)) { //设置监听
                    //判断对象是否更改
                    $(target).on('change', function () {
                        //设置默认值
                        var checked_value;
                        //判断类型
                        if (type === 'switch') {
                            //判断是否选中
                            checked_value = $(target).is(":checked") ? $(target).attr('data-on-value') : $(target).attr('data-off-value');
                        } else {
                            //设置选中值
                            checked_value = $(target+":checked").val();
                        }
                        //判断值是否有效
                        if (typeof checked_value !== 'undefined' && checked_value.length > 0) {
                            //循环规则
                            $.each(triggers, function (v, rules) {
                                //判断是否为选中值
                                if (v === checked_value) {
                                    //循环字段
                                    $.each(rules, function (i, item) {
                                        //显示内容
                                        form.find(".acbf_" + sign + "_item_box[data-field='" + item + "']").removeClass('d-none');
                                    });
                                } else {
                                    //循环字段
                                    $.each(rules, function (i, item) {
                                        //隐藏内容
                                        form.find(".acbf_" + sign + "_item_box[data-field='" + item + "']").removeClass('d-none').addClass('d-none');
                                    });
                                }
                            });
                            //触发结构隐藏
                            structure_group_trigger();
                        }
                    });
                }
            }
        });
        //触发结构隐藏
        structure_group_trigger();
    },
    setItemTriggers: function (form, sign) {
        //循环表单对象信息
        form.find('.acbf_'+sign+'_item_box').each(function () {
            //获取基础数据
            var _this = $(this), type = _this.attr('data-type'), field = _this.attr('data-field'), target = _this.attr('data-target'), default_value = _this.attr('data-default-value');
            //判断对象是否更改
            $(target).on('change', function () {
                //设置基础信息
                var date = new Date(), now_time = (date.getFullYear()+'-'+(date.getMonth() >= 10 ? date.getMonth() : '0'+date.getMonth())+'-'+(date.getDay() >= 10 ? date.getDay() : '0'+date.getDay())+' '+(date.getHours() >= 10 ? date.getHours() : '0'+date.getHours())+':'+(date.getMinutes() >= 10 ? date.getMinutes() : '0'+date.getMinutes())+':'+(date.getSeconds() >= 10 ? date.getSeconds() : '0'+date.getSeconds())), target_value;
                //根据类型处理
                switch (type) {
                    case 'radio':
                    case 'normal_radio':
                    case 'image_radio':
                        //获取值
                        target_value = $(target+":checked").val();
                        break;
                    case 'checkbox':
                    case 'normal_checkbox':
                    case 'image_checkbox':
                    case 'group_checkbox':
                        //设置默认值
                        target_value = [];
                        //怒换对象
                        $(target).each(function () {
                           //判断是否选中
                           if ($(this).is(':checked')) {
                               //添加值
                               target_value.push($(this).val());
                           }
                        });
                        //获取值
                        target_value = JSON.stringify(target_value);
                        break;
                    case 'switch':
                        //判断是否选中
                        if ($(target).is(':checked')) {
                            //设置值
                            target_value = $(target).attr('data-on-value');
                        } else {
                            //设置值
                            target_value = $(target).attr('data-off-value');
                        }
                        break;
                    case 'ck_editor':
                        //设置默认值
                        default_value = $("#acbf_"+sign+"_item_"+field+"_default_value_content").html();
                        //获取值
                        target_value = $(target).val();
                        break;
                    case 'ueditor':
                        //设置默认值
                        default_value = $("#acbf_"+sign+"_item_"+field+"_default_value_content").html();
                        //获取值
                        target_value = $(target).val();
                        break;
                    case 'tags':
                        //设置默认值
                        target_value = [];
                        //获取值
                        var tags_value = $(target).val();
                        //判断信息
                        if (typeof tags_value !== 'undefined' && tags_value.length > 0) {
                            //循环内容
                            $.each(JSON.parse(tags_value), function (i, item) {
                                //新增字段
                                target_value.push(item.value);
                            });
                        }
                        //获取值
                        target_value = JSON.stringify(target_value, null);
                        break;
                    default:
                        //获取值
                        target_value = $(target).val();
                        break;
                }
                //判断值是否一致
                if (default_value !== target_value) {
                    //设置显示已更改
                    $("#acbf_"+sign+"_item_"+field+"_edited_warning").removeClass('d-none').find('span.edited_time').text(now_time);
                } else {
                    //设置不显示已更改
                    $("#acbf_"+sign+"_item_"+field+"_edited_warning").removeClass('d-none').addClass('d-none');
                }
            });
        });
    },
    buildItems: function (form, sign)
    {
        //获取绑定对象
        var dropdown_modal_id = form.attr('data-dropdown-modal-id');
        //循环表单对象信息
        form.find('.acbf_'+sign+'_item_box').each(function () {
             //获取基础数据
            var _this = $(this), type = _this.attr('data-type'), target = _this.attr('data-target'), field = _this.attr('data-field');
            //根据类型处理
            switch (type) {
                case 'input':
                    //获取input类型
                    var input_mode = $(target).attr('data-input-mode');
                    //判断input_mode
                    if (input_mode === 'datetime') {
                        //获取显示格式
                        var filter_date_format = $(target).attr('data-format'), filter_date_params = {
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
                        if (typeof $(target).attr('data-date-range') !== 'undefined' && parseInt($(target).attr('data-date-range')) === 1) {
                            //添加范围支持
                            filter_date_params['mode'] = 'range';
                        }
                        //实例化日期
                        $(target).flatpickr(filter_date_params);
                        break;
                    }
                break;
                case 'files':
                    //整理信息
                    var box = $("#acbf_"+sign+"_item_"+field+"_upload_box"), empty_box = $("#acbf_"+sign+"_item_"+field+"_upload_without_item"), items = $("#acbf_"+sign+"_item_"+field+"_upload_items"), trigger_btn = $("#acbf_"+sign+"_item_"+field+"_trigger"), input_uploader = $("#acbf_"+sign+"_item_"+field+"_uploader"), upload_item_template = '<div class="dropzone-item acbf_'+sign+'_item_'+field+'_upload_item" data-link="__LINK__"><div class="dropzone-file"><div class="dropzone-filename"><span>__FILE_NAME__</span></div></div><div class="dropzone-toolbar acbf_'+sign+'_item_'+field+'_upload_item_toolbar"><span class="dropzone-start acbf_'+sign+'_item_'+field+'_upload_item_trigger" data-trigger="preview" data-bs-toggle="tooltip" data-bs-dismiss="click" title="预览/查看文件内容"><i class="bi bi-eye fs-3"></i></span><span class="dropzone-start acbf_'+sign+'_item_'+field+'_upload_item_trigger" data-trigger="prev" data-bs-toggle="tooltip" data-bs-dismiss="click" title="上移文件排序"><i class="bi bi-arrow-up fs-3"></i></span><span class="dropzone-start acbf_'+sign+'_item_'+field+'_upload_item_trigger" data-trigger="next" data-bs-toggle="tooltip" data-bs-dismiss="click" title="下移文件排序"><i class="bi bi-arrow-down fs-3"></i></span><span class="dropzone-delete acbf_'+sign+'_item_'+field+'_upload_item_trigger" data-trigger="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-delay-hide="500" title="删除当前文件"><i class="bi bi-x fs-1"></i></span></div></div>', file_input_trigger = function () {
                        //设置信息
                        var files = [];
                        //循环项目
                        items.find('.acbf_'+sign+'_item_'+field+'_upload_item').each(function () {
                            //添加信息
                            files.push($(this).attr('data-link'));
                        });
                        //判断长度
                        if (files.length > 0) {
                            //隐藏empty
                            empty_box.removeClass('d-none').addClass('d-none');
                        } else {
                            //显示empty
                            empty_box.removeClass('d-none');
                        }
                        //获取值
                        $(target).val(JSON.stringify(files)).change();
                        //重置tooltip
                        KTApp.initBootstrapTooltips();
                    }, trigger_func = function () {
                        //设置操作触发
                        items.on('click', '.acbf_'+sign+'_item_'+field+'_upload_item_trigger', function () {
                            switch ($(this).attr('data-trigger')) {
                                case 'preview':
                                    //新开页面打开链接
                                    window.open($(this).parents('.acbf_'+sign+'_item_'+field+'_upload_item').attr('data-link'));
                                    break;
                                case 'prev':
                                    //获取当前item
                                    var prev_item = $(this).parents('.acbf_'+sign+'_item_'+field+'_upload_item');
                                    //判断靠前是否还有元素
                                    if (prev_item.prev('.acbf_'+sign+'_item_'+field+'_upload_item').length <= 0) {
                                        //停止执行
                                        return false;
                                    }
                                    //前移元素
                                    prev_item.prev('.acbf_'+sign+'_item_'+field+'_upload_item').eq(0).before(prev_item.prop("outerHTML"));
                                    //移除当前item
                                    prev_item.remove();
                                    //重新梳理信息
                                    file_input_trigger();
                                    break;
                                case 'next':
                                    //获取当前item
                                    var next_item = $(this).parents('.acbf_'+sign+'_item_'+field+'_upload_item');
                                    //判断靠后是否还有元素
                                    if (next_item.next('.acbf_'+sign+'_item_'+field+'_upload_item').length <= 0) {
                                        //停止执行
                                        return false;
                                    }
                                    //后移元素
                                    next_item.next('.acbf_'+sign+'_item_'+field+'_upload_item').eq(0).after(next_item.prop("outerHTML"));
                                    //移除当前item
                                    next_item.remove();
                                    //重新梳理信息
                                    file_input_trigger();
                                    break;
                                case 'remove':
                                    //删除当前item
                                    $(this).parents('.acbf_'+sign+'_item_'+field+'_upload_item').remove();
                                    //重新触发
                                    file_input_trigger();
                                    break;
                            }
                        });
                    };
                    //判断对象是否存在
                    if (typeof $(target) !== 'undefined') {
                        //设置点击触发上传
                        trigger_btn.on('click', function () {
                            //删除默认值
                            input_uploader.val('');
                            //设置文件上传触发
                            input_uploader.trigger('click');
                        });
                        //设置上传触发
                        input_uploader.on('change', function (file) {
                            //整理信息
                            var upload_files = file.target.files;
                            //判断文件信息
                            if (typeof (upload_files) !== 'undefined' && !$.isEmptyObject(upload_files)) {
                                //加载loading
                                var loading = loadingStart(trigger_btn, _this[0], '正在上传文件...');
                                //循环文件信息
                                $.each(upload_files, function (i, item) {
                                    //整理上传信息
                                    var uploadData = new FormData();
                                    //整理信息
                                    uploadData.append('file', item);
                                    uploadData.append('file_type', 'binary');
                                    uploadData.append('dictionary', _this.attr('data-upload-dictionary'));
                                    uploadData.append('origin_name', file.target.files[i]['name']);
                                    //开始请求上传
                                    $.ajax({
                                        type: 'post',
                                        url: _this.attr('data-uploader-url'),
                                        data: uploadData,
                                        processData: false,
                                        contentType: false,
                                        success: function (res) {
                                            //判断上传状态
                                            if (res.state) {
                                                //判断是否多选
                                                if (parseInt(_this.attr('data-multiple')) !== 1) {
                                                    //删除已存在文件
                                                    items.find('.acbf_'+sign+'_item_'+field+'_upload_item').remove();
                                                }
                                                //添加内容
                                                items.append(upload_item_template.replaceAll('__LINK__', res.data['link']).replaceAll('__FILE_NAME__', res.data['file_info']['basename']));
                                                //重置结果
                                                file_input_trigger();
                                            } else {
                                                //提示信息
                                                alertToast(res.msg, 2000, 'error', '文件上传');
                                            }
                                        },
                                        error: function (res) {
                                            //提示信息
                                            alertToast('网络错误，请稍后再试', 2000, 'error', '文件上传');
                                        }
                                    });
                                });
                                //关闭弹窗
                                loadingStop(loading, trigger_btn);
                            }
                        });
                        //重置结果
                        file_input_trigger();
                        trigger_func();
                    }
                    break;
                case 'image':
                    //整理信息
                    var modal_object, box = $("#acbf_"+sign+"_item_"+field+"_upload_box"), wrapper = $("#acbf_"+sign+"_item_"+field+"_wrapper"), trigger_btn = $("#acbf_"+sign+"_item_"+field+"_trigger"), remover_btn = $("#acbf_"+sign+"_item_"+field+"_remover"), input_uploader = $("#acbf_"+sign+"_item_"+field+"_uploader"), modal_html = '<div class="modal fade image_cropper_modal" id="acbf_'+sign+'_image_cropper_modal_for_'+field+'" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">图片尺寸裁剪</h5><button class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"><i aria-hidden="true" class="fa fa-times"></i></button></div><div class="modal-body"><div class="mb-5 w-100"><img id="acbf_'+sign+'_image_cropper_img_for_'+field+'" class="d-block w-100" src="" style="max-height: 500px;width: 100%" alt=""/></div><div id="acbf_'+sign+'_image_cropper_buttons_for_'+field+'" class="text-center"><div class="btn-group"><button type="button" class="btn btn-default" data-method="cropper.zoom(0.1)" data-option="0.1" data-toggle="kt-tooltip" title="Zoom In"><span class="fa fa-search-plus"></span></button><button type="button" class="btn btn-default" data-method="cropper.zoom(-0.1)" data-toggle="kt-tooltip" title="Zoom Out"><span data-toggle="kt-tooltip" title=""><span class="fa fa-search-minus"></span></span></button></div><div class="btn-group"><button type="button" class="btn btn-default" data-method="cropper.move(-10, 0)" data-toggle="kt-tooltip" title="Move Left"><span class="fa fa-arrow-left"></span></button><button type="button" class="btn btn-default" data-method="cropper.move(10, 0)" data-toggle="kt-tooltip" title="Move Right"><span class="fa fa-arrow-right"></span></button><button type="button" class="btn btn-default" data-method="cropper.move(0, -10)" data-toggle="kt-tooltip" title="Move Up"><span class="fa fa-arrow-up"></span></button><button type="button" class="btn btn-default" data-method="cropper.move(0, 10)" data-toggle="kt-tooltip" title="Move Down"><span class="fa fa-arrow-down"></span></button></div><div class="btn-group"><button type="button" class="btn btn-default" data-method="cropper.rotate(-45)" data-toggle="kt-tooltip" title="Rotate Left"><span class="fa fa-undo-alt"></span></button><button type="button" class="btn btn-default" data-method="cropper.rotate(45)" data-toggle="kt-tooltip" title="Rotate Right"><span class="fa fa-redo-alt"></span></button></div><div class="btn-group"><button type="button" class="btn btn-default" data-method="cropper.scaleX(-1)" data-toggle="kt-tooltip" title="Flip Horizontal"><span class="fa fa-arrows-alt-h"></span></button><button type="button" class="btn btn-default" data-method="cropper.scaleY(-1)" data-toggle="kt-tooltip" title="Flip Vertical"><span class="fa fa-arrows-alt-v"></span></button></div><div class="btn-group"><button type="button" class="btn btn-default" data-method="cropper.reset()" data-toggle="kt-tooltip" title="Reset"><span class="fa fa-sync-alt"></span></button></div></div></div><div class="modal-footer"><button type="button" class="btn btn-light-primary font-weight-bold" data-bs-dismiss="modal" data-bs-target="#acbf_'+sign+'_image_cropper_modal_for_'+field+'" >取消</button><button type="button" class="btn btn-primary font-weight-bold confirm-to-crop">确认裁剪</button></div></div></div></div>';;
                    //判断对象是否存在
                    if (typeof $(target) !== 'undefined') {
                        //设置点击触发上传
                        trigger_btn.on('click', function () {
                            //删除默认值
                            input_uploader.val('');
                            //创建上传modal
                            $('body').find('.image_cropper_modal').remove().end().append(modal_html);
                            //设置文件上传触发
                            input_uploader.trigger('click');
                        });
                        //移除图片触发
                        remover_btn.on('click', function () {
                           //清空内容
                           $(target).val('').change();
                           //设置图片地址
                            wrapper.css('background', 'unset');
                        });
                        //设置上传触发
                        input_uploader.on('change', function (file) {
                            //引入文件读取实例
                            var reader = new FileReader(), modal = $("#acbf_"+sign+"_image_cropper_modal_for_"+field), file_name = file.target.files[0]['name'], uploader_func = function (file_content, type = 'base64') {
                                //整理基础信息
                                var confirm_crop = modal.find('div.modal-footer button.confirm-to-crop'), uploadData = new FormData(), loading = loadingStart(confirm_crop, modal[0], '正在上传图片...');
                                //整理信息
                                uploadData.append('file', file_content);
                                uploadData.append('file_type', type);
                                uploadData.append('dictionary', _this.attr('data-upload-dictionary'));
                                uploadData.append('origin_name', file.target.files[0]['name']);
                                //开始请求上传
                                $.ajax({
                                    type: 'post',
                                    url: _this.attr('data-uploader-url'),
                                    data: uploadData,
                                    processData: false,
                                    contentType: false,
                                    success: function (res) {
                                        //判断上传状态
                                        if (res.state) {
                                            //设置内容
                                            $(target).val(res.data['link']).change();
                                            //设置图片地址
                                            wrapper.css({
                                                'background': 'url('+res.data['link']+')',
                                                'background-size': 'cover',
                                                'background-repeat': 'no-repeat',
                                            });
                                            //隐藏弹窗
                                            modal_object.hide();
                                        } else {
                                            //提示信息
                                            alertToast(res.msg, 2000, 'error', '图片上传');
                                        }
                                    },
                                    error: function (res) {
                                        //提示信息
                                        alertToast('网络错误，请稍后再试', 2000, 'error', '图片上传');
                                    }
                                });
                                //关闭弹窗
                                loadingStop(loading, confirm_crop);
                            };
                            //判断是否为GIF图片
                            if (file_name.toLowerCase().indexOf('.gif') > -1) {
                                //上传图片
                                uploader_func(file.target.files[0], 'binary');
                            } else {
                                //判断是否加载成功
                                reader.onload = (function (e) {
                                    //引入样式文件
                                    createExtraCss(_this.attr('data-cropper-css-path'), function () {
                                        //引入文件信息(JS)
                                        createExtraJs(_this.attr('data-cropper-js-path'), typeof (Cropper), function () {
                                            //获取图片实例
                                            var img = modal.find("#acbf_"+sign+"_image_cropper_img_for_"+field);
                                            //触发时间
                                            modal.on('shown.bs.modal', function () {
                                                //判断图片是否加载完成
                                                img[0].onload = function () {
                                                    //实例化cropper
                                                    var cropper = new Cropper(img[0], {
                                                        viewMode: 2,
                                                        dragMode: 'move',
                                                        aspectRatio: parseInt(input_uploader.attr('data-width'))/parseInt(input_uploader.attr('data-height')),
                                                        mouseWheelZoom: false,
                                                        autoCropArea: 0.5,
                                                        dragCrop: false,
                                                        zoomOnWheel: false
                                                    });
                                                    //触发关闭弹窗事件
                                                    modal.on('hidden.bs.modal', function () {
                                                        //销毁信息
                                                        cropper.destroy();
                                                        //删除弹窗
                                                        modal.remove();
                                                    });
                                                    //触发确认裁剪事件
                                                    modal.find('div.modal-footer button.confirm-to-crop').on('click', function () {
                                                        //获取截取数据
                                                        var cropper_base64 = cropper.getCroppedCanvas({
                                                            imageSmoothingQuality: 'high'
                                                        }).toDataURL('image/png');
                                                        //上传图片
                                                        uploader_func(cropper_base64, 'image_base64');
                                                    });
                                                    //设置按钮触发
                                                    modal.find("#acbf_"+sign+"_image_cropper_buttons_for_"+field+" button").on('click', function () {
                                                        //判断处理方法
                                                        switch ($(this).attr('data-method')) {
                                                            case 'cropper.zoom(0.1)':
                                                                cropper.zoom(0.1);
                                                                break;
                                                            case 'cropper.zoom(-0.1)':
                                                                cropper.zoom(-0.1);
                                                                break;
                                                            case 'cropper.move(-10, 0)':
                                                                cropper.move(-10, 0);
                                                                break;
                                                            case 'cropper.move(10, 0)':
                                                                cropper.move(10, 0);
                                                                break;
                                                            case 'cropper.move(0, -10)':
                                                                cropper.move(0, -10);
                                                                break;
                                                            case 'cropper.move(0, 10)':
                                                                cropper.move(0, 10);
                                                                break;
                                                            case 'cropper.rotate(45)':
                                                                cropper.rotate(45);
                                                                break;
                                                            case 'cropper.rotate(-45)':
                                                                cropper.rotate(-45);
                                                                break;
                                                            case 'cropper.scaleX(-1)':
                                                                cropper.scaleX(-1);
                                                                break;
                                                            case 'cropper.scaleY(-1)':
                                                                cropper.scaleY(-1);
                                                                break;
                                                            default:
                                                                cropper.reset()
                                                                break;
                                                        }
                                                    });
                                                };
                                                //设置cropper
                                                img.attr('src', e.target.result).attr('alt', file.target.files[0]['name']);
                                            });
                                            //显示弹窗
                                            modal_object = new bootstrap.Modal(modal[0], {backdrop: 'static', keyboard: false});
                                            modal_object.show();
                                        });
                                    });
                                });
                                //获取数据流
                                reader.readAsDataURL(file.target.files[0]);
                            }
                        });
                    }
                    break;
                case 'tags':
                    //初始化参数
                    var tagify_options = {}, whitelist = JSON.parse(_this.attr('data-whitelist'));
                    //判断白名单
                    if (!$.isEmptyObject(whitelist)) {
                        //设置白名单
                        tagify_options['whitelist'] = whitelist;
                        tagify_options['dropdown'] = {
                            maxItems: 20,
                            classname: "tagify__inline__suggestions",
                            enabled: 0,
                            closeOnSelect: false
                        };
                    }
                    //实例化标签
                    new Tagify($(target)[0], tagify_options);
                    break;
                case 'select':
                    //设置参数
                    var select2_options = {};
                    //判断是否为modal
                    if (typeof (dropdown_modal_id) !== 'undefined' && dropdown_modal_id.length > 0) {
                        //添加参数
                        select2_options.dropdownParent = $("#"+dropdown_modal_id);
                    }
                    //设置select2
                    $(target).select2(select2_options);
                    break;
                case 'icon':
                    //设置参数
                    var optionFormat = (item) => {
                        //未知项
                        if (!item.id || item.id === '__WITHOUT_SELECTED_OPTION__') {
                            //直接返回
                            return item.text;
                        }
                        //创建对象
                        var span = document.createElement('span');
                        //设置内容
                        span.innerHTML = '<i class="fa '+item.text+' me-2"></i> fa '+item.text;
                        //返回对象
                        return $(span);
                    }, icon_options = {
                        templateSelection: optionFormat,
                        templateResult: optionFormat,
                    };
                    //判断是否为modal
                    if (typeof (dropdown_modal_id) !== 'undefined' && dropdown_modal_id.length > 0) {
                        //添加参数
                        icon_options.dropdownParent = $("#"+dropdown_modal_id);
                    }
                    //设置select2
                    $(target).select2(icon_options);
                    break;
                case 'values':
                    //整理基础数据
                    var insert_btn = $("#acbf_"+sign+"_item_"+field+"_values_insert"), delete_all_btn = $("#acbf_"+sign+"_item_"+field+"_values_delete_all"), template = $("#acbf_"+sign+"_item_"+field+"_values_template").html(), box = $("#acbf_"+sign+"_item_"+field+"_values_box"), empty_row = $("#acbf_"+sign+"_item_"+field+"_values_empty_row"), values_change_trigger = function () {
                        //设置信息
                        var values = [];
                        //循环项目
                        box.find('.acbf_'+sign+'_item_'+field+'_values_row').each(function () {
                            //整理参数
                            var content = {};
                            //循环内容
                            $(this).find('.acbf_'+sign+'_item_'+field+'_values_item').each(function () {
                                //判断key
                                if (typeof $(this).attr('data-key') !== 'undefined') {
                                    //根据类型处理
                                    switch ($(this).attr('data-type')) {
                                        case 'switch':
                                            content[$(this).attr('data-key')] = $(this).is(':checked') ? $(this).attr('data-on-value') : $(this).attr('data-off-value');
                                            break;
                                        default:
                                            //设置内容
                                            content[$(this).attr('data-key')] = $(this).val();
                                            break;
                                    }
                                }
                            });
                            //添加内容
                            values.push(content);
                        });
                        //判断长度
                        if (values.length > 0) {
                            //隐藏empty
                            empty_row.removeClass('d-none').addClass('d-none');
                        } else {
                            //显示empty
                            empty_row.removeClass('d-none');
                        }
                        //获取值
                        $(target).val(JSON.stringify(values)).change();
                    };
                    //监听添加
                    insert_btn.on('click', function () {
                       //添加基础结构
                       box.append(template);
                       //重置触发
                        values_change_trigger();
                    });
                    //监听删除全部
                    delete_all_btn.on('click', function () {
                       //删除基础结构
                       box.find('.acbf_'+sign+'_item_'+field+'_values_row').remove();
                       //重置触发
                        values_change_trigger();
                    });
                    //单个删除触发
                    box.on('click', '.acbf_'+sign+'_item_'+field+'_values_trigger_delete', function () {
                        //删除当前栏
                        $(this).parents('.acbf_'+sign+'_item_'+field+'_values_row').remove();
                        //重置触发
                        values_change_trigger();
                    }).on('change', '.acbf_'+sign+'_item_'+field+'_values_item', function () {
                        //重置触发
                        values_change_trigger();
                    });
                    //默认触发
                    values_change_trigger();
                    break;
                case 'ck_editor':
                    //引入js
                    createExtraJs(_this.attr('data-javascript-file'), $.ClassicEditor, function () {
                        //创建CKEditor
                        ClassicEditor.create(document.querySelector(target), {
                            language: 'zh-cn',
                            content: 'zh-cn',
                            ckfinder: {
                                uploadUrl: _this.attr('data-upload-url')
                            },
                            toolbar: {
                                items: [
                                    'Undo','Redo','SelectAll','RemoveFormat', '|', 'Bold','Italic', '｜', 'NumberedList','BulletedList','|','Outdent','Indent','Blockquote', '|', 'Link','Unlink'
                                ],
                            }
                        }).then(editor => {
                            //设置信息
                            editor.model.document.on('change:data', function () {
                                //设置信息
                                $(target).val(editor.getData()).change();
                            });
                        });
                    });
                    break;
                case 'ueditor':
                    //引入js
                    createExtraJs(_this.attr('data-ueditor-plugin-path')+'ueditor.config.js', typeof (window.UEDITOR_CONFIG), function () {
                        //设置上传路径
                        window.UEDITOR_CONFIG['serverUrl'] = _this.attr('data-upload-url')
                        window.UEDITOR_CONFIG['UEDITOR_HOME_URL'] = _this.attr('data-ueditor-plugin-path')
                        //继续引入对象
                        createExtraJs(_this.attr('data-ueditor-plugin-path')+'ueditor.all.js', typeof (window.UE.dom), function () {
                            //获取对象
                            var ue = UE.getEditor(_this.attr('data-container-target'), function () {
                                autoHeight: true
                            });
                            //设置监听
                            ue.addListener('contentChange', function (editor) {
                               //设置内容
                               $(target).val(ue.getContent().trim()).change();
                            });
                        });
                    });
                    break;
                case 'linkage':
                    //获取基础信息
                    var json_path = _this.attr('data-json-path'), default_value = JSON.parse(_this.attr('data-default-value')), default_key = _this.attr('data-default-key'), total_level = _this.attr('data-level'), names = JSON.parse(_this.attr('data-names')), box = $("#acbf_"+sign+"_item_"+field+"_box"), linkage_change_trigger = function (keys, current_level = 1) {
                        //获取内容
                        $.getJSON(json_path, function (data) {
                            //判断key
                            if (!$.isEmptyObject(keys)) {
                                //循环key
                                $.each(keys, function (i, item) {
                                    //判断是否存在
                                    if (item in data) {
                                        //设置data
                                        data = data[item][names['sub_name']];
                                    }
                                });
                                //生成内容
                                var options = '';
                                //循环内容
                                $.each(data, function (ii, it) {
                                    //添加内容
                                    options += '<option value="'+it[names['key_name']]+'" class="action_option">'+it[names['text_name']]+'</option>';
                                });
                                //判断当前为第一级
                                if (current_level <= 0 && keys[0].length <= 0) {
                                    //设置信息
                                    keys = [];
                                }
                                //自增等级
                                current_level = (parseInt(current_level) + 1);
                                //设置内容
                                box.find('.acbf_'+sign+'_item_'+field+'_linkage_item[data-level="'+current_level+'"]').attr('data-keys', JSON.stringify(keys)).append(options);
                            }
                        });
                    }, clear_options_trigger = function (level) {
                        //循环内容
                        box.find('.acbf_'+sign+'_item_'+field+'_linkage_item').each(function () {
                           //判断当前层级
                           if (parseInt($(this).attr('data-level')) > parseInt(level)) {
                               //删除动态option
                               $(this).find('option.action_option').remove();
                               //设置默认选中
                               $(this).find('option.default_option').prop('selected', true);
                               //设置keys
                               $(this).attr('data-keys', '[]');
                           }
                        });
                    }, default_options_trigger = function () {
                        //判断长度
                        if (parseInt(default_value.length) < parseInt(total_level)) {
                            //加载第一项
                            linkage_change_trigger([default_key], 0);
                        } else {
                            //加载第一项
                            linkage_change_trigger([default_key], 0);
                            //循环默认值
                            $.each(default_value, function (i, item) {
                                //延迟处理
                                setTimeout(function () {
                                    //设置元素
                                    box.find('.acbf_'+sign+'_item_'+field+'_linkage_item[data-level="'+(parseInt(i)+1)+'"]').val(item).change();
                                }, 1000 * i);
                            });
                        }
                    };
                    //设置默认触发
                    default_options_trigger();
                    //监听更改
                    box.find('.acbf_'+sign+'_item_'+field+'_linkage_item').on('change', function () {
                        //获取默认值
                        var item_keys = JSON.parse($(this).attr('data-keys')), current_level = $(this).attr('data-level'), item_value = $(this).val();
                        //判断值是否有效
                        if (item_value.length > 0 && item_value !== default_key) {
                            //追加当前默认值
                            item_keys.push(item_value);
                        }
                        //判断是否为最后一栏
                        if (parseInt(current_level) < parseInt(total_level)) {
                            //清空下级option
                            clear_options_trigger(current_level);
                            //触发加载
                            linkage_change_trigger(item_keys, current_level);
                        }
                        //设置默认值
                        $(target).val(JSON.stringify(item_keys)).change();
                    });
                    break;
                case 'group_checkbox':
                    //设置按钮点击
                    $("#acbf_"+sign+"_item_aliases_checkbox_item_button_trigger_select_all").on('click', function () {
                       //设置全部选中
                       $(target).prop('checked', true);
                       $(target).eq(0).change();
                    });
                    $("#acbf_"+sign+"_item_aliases_checkbox_item_button_trigger_select_none").on('click', function () {
                       //设置全部选中
                       $(target).prop('checked', false);
                       $(target).eq(0).change();
                    });
                    break;
            }
            //判断是否存在maxlength
            if (typeof $(target).attr('maxlength') !== 'undefined' && parseInt($(target).attr('maxlength')) > 0) {
                //设置maxlength
                $(target).maxlength({
                    warningClass: "badge badge-warning",
                    limitReachedClass: "badge badge-success"
                });
            }
        });
    },
    setActionTrigger: function (form, sign) {
        //循环表单中复制操作
        form.find('[data-action-type="clipboard"]').each(function (e) {
            //设置复制
            var  _this = $(this);
            //设置复制触发
            new ClipboardJS(_this[0]).on('success', function (e) {
                //获取原文字
                var triggerCaption = _this.html(), target_dom = $(_this.attr('data-clipboard-target'));
                //判断是否已触发
                if (!target_dom.hasClass('bg-success text-inverse-success')) {
                    //设置样式
                    target_dom.addClass('bg-success text-inverse-success');
                    //设置文字
                    _this.text('复制成功！');
                    //设置延迟关闭
                    setTimeout(function () {
                        //还原
                        _this.html(triggerCaption);
                        target_dom.removeClass('bg-success text-inverse-success');
                    }, 2000);
                }
                //停止冒泡
                e.clearSelection();
            })
        });
        //循环表单中链接操作
        form.find('[data-action-type="link"]').on('click', function () {
            //设置复制
            var  _this = $(this), target_dom = $(_this.attr('data-link-target')), link_val = target_dom.val();
            //判断信息
            if (typeof link_val !== 'undefined' && link_val.length > 0) {
                //跳转页面
                window.open(link_val);
            } else {
                //提示错误
                alertToast('链接内容不可用，请查看后再试！', 2000, 'info', '中断提示');
            }
        });
    },
    setButtonTrigger: function (form, sign) {
        //整理信息
        var __THIS__ = this, buttons = $("#acbf_" + sign + "_buttons"), toolbars = $("#kt_dashboard_toolbar_items"), bind_table_parent_sign = form.attr('data-bind-table-parent-sign'), bind_modal_id = form.attr('data-bind-modal-id'), bind_table_id = form.attr('data-bind-table-id'), button_trigger = function (_this, param_fields) {
            //获取对象配置
            var confirm_tip = _this.attr('data-confirm-tip'), query_url = _this.attr('data-query-url'),
                method = _this.attr('data-method'), type = _this.attr('data-type'),
                target_redirect = _this.attr('data-target-redirect'),
                extras = JSON.parse(_this.attr('data-extras')), ajax_after = _this.attr('data-after-ajax');
            //判断是否存在配置参数
            if (typeof extras['params'] !== 'undefined' && !$.isEmptyObject(extras['params'])) {
                //设置默认参数
                param_fields['__params__'] = extras['params'];
            }
            //封装统一执行内容
            var query_func = function () {
                //根据类型处理
                switch (type) {
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
                        var loading = loadingStart(_this, form[0], '正在处理...'), back_or_reload_trigger = function () {
                            //判断是否为modal
                            if (typeof (bind_modal_id) === 'undefined' || bind_modal_id.length <= 0) {
                                //获取返回按钮
                                var form_back_button = buttons.find('button[data-did="acbf_'+sign+'_back_button"]');
                                //判断是否存在返回按钮
                                if (typeof form_back_button !== 'undefined' && form_back_button.length > 0) {
                                    //触发点击
                                    form_back_button.trigger('click');
                                } else {
                                    //刷新当前页面
                                    window.location.reload();
                                }
                            } else {
                                //获取返回按钮
                                var modal_back_button = $("#"+bind_modal_id).find('button[data-did="acbf_'+sign+'_back_button"]');
                                //判断是否存在返回按钮
                                if (typeof modal_back_button !== 'undefined' && modal_back_button.length > 0) {
                                    //触发点击
                                    modal_back_button.trigger('click');
                                } else {
                                    //刷新当前页面
                                    window.location.reload();
                                }
                            }
                        };
                        //创建请求
                        buildRequest(query_url, param_fields, method, true, function (res) {
                            //根据配置处理
                            switch (ajax_after) {
                                case 'back_or_reload':
                                    //触发操作
                                    back_or_reload_trigger();
                                    break;
                                case 'reload':
                                    //刷新当前页面
                                    window.location.reload();
                                    break;
                                case 'refresh_table_after_modal_close':
                                    //获取对象
                                    var modal = $("#"+bind_modal_id), table = $("#"+bind_table_id), table_sign = table.attr('data-sign'), table_angle = table.find('.acbt_'+table_sign+'_table_tbody_td_sub_angle[data-sub-sign="'+bind_table_parent_sign+'"]');
                                    //判断弹窗是否存在
                                    if (typeof (modal) !== 'undefined' && modal.length > 0) {
                                        //关闭弹窗
                                        modal.find('#'+bind_modal_id+'_close_icon').trigger('click');
                                    }
                                    //判断表格是否存在
                                    if (typeof (table) !== 'undefined' && table.length > 0) {
                                        //判断是否存在触发对象
                                        if (typeof table_angle !== 'undefined' && table_angle.length > 0) {
                                            //刷新表格子列表
                                            $.table_builder.querySubContentLists(table, table_sign, table_angle);
                                        } else {
                                            //刷新表格
                                            $.table_builder.requestLists(table, table_sign);
                                        }
                                    }
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
                            loadingStop(loading, _this);
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
        }, submit_trigger = function (submit) {
            //获取参数
            var params = __THIS__.arrangeParams(form, sign);
            //判断参数
            if (typeof (params) === "object") {
                //判断是否存在更改
                if ($.isEmptyObject(params)) {
                    //提示错误
                    alertToast('暂无更改项，请更改内容后再试！', 2000, 'warning');
                } else {
                    //按钮触发
                    button_trigger(submit, params);
                }
            }
        };
        //判断是否为modal
        if (typeof (bind_modal_id) === 'undefined' || bind_modal_id.length <= 0) {
            //设置监听
            toolbars.on('click', 'button[data-did="acbf_'+sign+'_submit_button"]', function () {
                //提交触发
                submit_trigger($(this));
            }).on('click', 'button[data-did="acbf_'+sign+'_back_button"]', function () {
                //按钮触发
                button_trigger($(this));
            });
            //设置监听
            buttons.on('click', 'button[data-did="acbf_'+sign+'_submit_button"]', function () {
                //提交触发
                submit_trigger($(this));
            }).on('click', 'button[data-did="acbf_'+sign+'_back_button"]', function () {
                //按钮触发
                button_trigger($(this));
            });
        } else {
            //设置监听
            $("#"+bind_modal_id).on('click', 'button[data-did="acbf_'+sign+'_submit_button"]', function () {
                //提交触发
                submit_trigger($(this));
            }).on('click', 'button[data-did="acbf_'+sign+'_back_button"]', function () {
                //按钮触发
                button_trigger($(this));
            });
        }
    },
    arrangeParams: function (form, sign) {
        //整理参数
        var params = {}, edited = [], bind_modal_id = form.attr('data-bind-modal-id'), bind_table_id = form.attr('data-bind-table-id'), validator_trigger = function (this_item, tip) {
            //判断是否为modal
            if (typeof (bind_modal_id) === 'undefined' || bind_modal_id.length <= 0) {
                //滑动页面
                scrollToObject(this_item);
            } else {
                //滑动modal
                scrollToObject(this_item, $('#'+bind_modal_id).find('.modal-body'))
            }
            //判断提示内容
            if (typeof tip === 'undefined' || tip.length <= 0) {
                //设置提示
                tip = '此项为必填项( * )，请更新此项内容后再试';
            }
            //判断是否为表单整体提示
            if (this_item === form) {
                //提示信息
                alertToast(tip, 3000, 'warning');
            } else {
                //新增提示
                this_item.append('<div class="fs-7 fw-bold text-danger my-2 validator_tip">'+tip+'</div>');
                //设置延时关闭
                setTimeout(function () {
                    this_item.find('.validator_tip').remove();
                }, 5000);
            }
            //跳出循环
            return false;
        };
        //循环所有元素
        form.find('.acbf_'+sign+'_item_box').each(function () {
            //获取基础数据
            var _this = $(this), type = _this.attr('data-type'), target = _this.attr('data-target'), field = _this.attr('data-field'), required = parseInt(_this.attr('data-required'));
            //判断未隐藏并已修改信息
            if (!_this.hasClass('d-none')) {
                //判断是否更改
                if (!$("#acbf_"+sign+"_item_"+field+"_edited_warning").hasClass('d-none')) {
                    //设置已更改
                    edited.push(field);
                }
                //根据类型处理
                switch (type) {
                    case 'tags':
                        //设置默认值
                        var tag_item_value = [];
                        //获取值
                        var tags_value = $(target).val();
                        //判断信息
                        if (typeof tags_value !== 'undefined' && tags_value.length > 0) {
                            //循环内容
                            $.each(JSON.parse(tags_value), function (i, item) {
                                //新增字段
                                tag_item_value.push(item.value);
                            });
                        }
                        //判断不为空
                        if (parseInt(required) === 1 && $.isEmptyObject(tag_item_value)) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = tag_item_value;
                        break;
                    case 'select':
                    case 'icon':
                        //获取值
                        var select_item_value = $(target).val();
                        //判断信息
                        if (parseInt(required) === 1 && (typeof (select_item_value) === 'undefined' || select_item_value.length <= 0 || select_item_value === '__WITHOUT_SELECTED_OPTION__')) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = (select_item_value === '__WITHOUT_SELECTED_OPTION__' ? '' : select_item_value);
                        break;
                    case 'switch':
                        //设置内容
                        params[field] = $(target).is(':checked') ? $(target).attr('data-on-value') : $(target).attr('data-off-value');
                        break;
                    case 'files':
                        //设置默认值
                        var file_item_value = $(target).val();
                        //整理信息
                        file_item_value = (typeof (file_item_value) === 'undefined' || file_item_value.length <= 0) ? [] : JSON.parse(file_item_value);
                        //判断信息
                        if (parseInt(required) === 1 && $.isEmptyObject(file_item_value)) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = file_item_value;
                        break;
                    case 'values':
                        //设置默认值
                        var values_item_value = $(target).val();
                        //整理信息
                        values_item_value = (typeof (values_item_value) === 'undefined' || values_item_value.length <= 0) ? [] : JSON.parse(values_item_value);
                        //判断信息
                        if (parseInt(required) === 1 && $.isEmptyObject(values_item_value)) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = values_item_value;
                        break;
                    case 'linkage':
                        //设置默认值
                        var linkage_item_value = $(target).val();
                        //整理信息
                        linkage_item_value = (typeof (linkage_item_value) === 'undefined' || linkage_item_value.length <= 0) ? [] : JSON.parse(linkage_item_value);
                        //判断信息
                        if (parseInt(required) === 1 && $.isEmptyObject(linkage_item_value)) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //判断信息
                        if (parseInt(required) === 1 && linkage_item_value.length !== parseInt(_this.attr('data-level'))) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = linkage_item_value;
                        break;
                    case 'radio':
                    case 'normal_radio':
                    case 'image_radio':
                        //获取选中值
                        var radio_item_value = $(target+':checked').val();
                        //判断信息
                        if (parseInt(required) === 1 && (typeof (radio_item_value) === 'undefined' || radio_item_value.length <= 0)) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = radio_item_value;
                        break;
                    case 'checkbox':
                    case 'normal_checkbox':
                    case 'image_checkbox':
                    case 'group_checkbox':
                        //设置默认值
                        var checkbox_item_value = [];
                        //怒换对象
                        $(target).each(function () {
                            //判断是否选中
                            if ($(this).is(':checked')) {
                                //添加值
                                checkbox_item_value.push($(this).val());
                            }
                        });
                        //判断信息
                        if (parseInt(required) === 1 && (typeof (checkbox_item_value) === 'undefined' || $.isEmptyObject(checkbox_item_value) || checkbox_item_value.length <= 0)) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = checkbox_item_value;
                        break;
                    default:
                        //获取值
                        var item_value = $(target).val();
                        //判断信息
                        if (parseInt(required) === 1 && (typeof (item_value) === 'undefined' || item_value.length <= 0)) {
                            //验证提示
                            return (params = validator_trigger(_this));
                        }
                        //设置内容
                        params[field] = item_value;
                        break;
                }
            }
        });
        //判断是否存在更改
        if (params && $.isEmptyObject(edited)) {
            //验证提示
            return (params = validator_trigger(form, '信息无更新'));
        }
        //返回参数
        return params ? {'__data__': params, '__edited__': edited} : false;
    }
}

