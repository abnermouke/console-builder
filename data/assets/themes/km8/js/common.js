// 配置基本设置
var HOST_URL = $("meta[name='website-url']").attr('content'), ENABLE_ASIDE = $("meta[name='enable_aside']").attr('content'), ROUTE_NAME = $("meta[name='current_route_name']").attr('content'), MOBILE_DEVICE = $("meta[name='mobile_device']").attr('content'), AES_IV = $("meta[name='aes-iv']").attr('content'), AES_ENCRYPT_KEY = $("meta[name='aes-encrypt-key']").attr('content'), DEFAULT_THEME = $("meta[name='default-theme']").attr('content');
//初始化ajax请求
$.ajaxSetup({
    //设置默认头部
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
});
//默认操作
$(function () {

    //初始化菜单信息
    initMenus();

    //获取信息
    var aside_obj = $("#kt_aside"), change_password = $("#kt-edit_admin_password"), change_password_modal = $("#kt-edit_admin_password_modal"), refresh_nodes = $("#kt-refresh_console_nodes");

    //判断存在侧边栏
    if (typeof (aside_obj) !== 'undefined' && aside_obj.length > 0) {
        //监听快捷显示侧边菜单状态
        $("#show_aside").on('change', function () {
            //判断状态
            if (this.checked) {
                //设置显示aside
                $("#acb_body").removeClass('aside-sticky aside-enabled').addClass('aside-sticky aside-enabled');
                $("#kt_aside").removeClass('d-none');
            } else {
                //设置隐藏aside
                $("#acb_body").removeClass('aside-sticky aside-enabled');
                $("#kt_aside").removeClass('d-none').addClass('d-none');
            }
        });

        //判断是否开放侧边栏
        if (parseInt(ENABLE_ASIDE) === 1 && parseInt(MOBILE_DEVICE) === 0) {
            //设置显示侧边栏
            $("#show_aside").prop('checked', true).change();
        }
    }
    //判断是否存在刷新节点按钮
    if (typeof refresh_nodes !== 'undefined' && refresh_nodes.length > 0) {
        //点击监听
        refresh_nodes.on('click', function () {
            //提示确认
            confirmPopup('刷新节点预计需要1-2分钟，确认后请耐心等待，是否继续？', function (res) {
                //加载loading
                var loading = loadingStart(refresh_nodes, $('body')[0], '正在刷新节点...');
                //发起请求
                buildRequest(refresh_nodes.attr('data-query-url'), {}, 'post', true, function (res) {
                    //提示信息
                    alertToast('刷新成功', 2000, 'success');
                    //刷新页面
                    window.location.reload();
                }, function (res) {
                    //提示信息
                    alertToast(res.msg, 2000, 'error');
                }, function () {
                    //关闭loading
                    loadingStop(loading, refresh_nodes);
                })
            });
        });
    }

    //判断是否存在修改密码按钮
    if (typeof change_password !== 'undefined' && change_password.length > 0) {
        //实例modal
        var change_password_modal_object;
        //设置监听
        change_password.on('click', function () {
            //显示弹窗
            change_password_modal_object = new bootstrap.Modal(change_password_modal[0], {backdrop: 'static', keyboard: false});
            //显示弹窗
            change_password_modal_object.show();
        });
        //提交确认
        $("#kt-edit_admin_password_modal_confirm_button").on('click', function () {
            //获取参数
            var _this = $(this), password = $("#kt-edit_admin_password_modal_new_password"), password_confirmed = $("#kt-edit_admin_password_modal_new_password_confirmed"), password_value = password.val(), confirmed_password_value = password_confirmed.val();
            //判断信息
            if (typeof password_value === 'undefined' || password_value.length < 6) {
                //新增提示
                password.parents('.form_item').append('<div class="fs-7 fw-bold text-danger my-2 validator_tip">密码需设置至少6位，请更新此项内容后再试</span></div>');
                //设置延时关闭
                setTimeout(function () {
                    password.parents('.form_item').find('.validator_tip').remove();
                }, 5000);
                //跳出循环
                return false;
            }
            //判断信息
            if (typeof confirmed_password_value === 'undefined' || confirmed_password_value.length < 6) {
                //新增提示
                password_confirmed.parents('.form_item').append('<div class="fs-7 fw-bold text-danger my-2 validator_tip">密码需设置至少6位，请更新此项内容后再试</span></div>');
                //设置延时关闭
                setTimeout(function () {
                    password_confirmed.parents('.form_item').find('.validator_tip').remove();
                }, 5000);
                //跳出循环
                return false;
            }
            //判断值是否一致
            if (password_value !== confirmed_password_value) {
                //新增提示
                password_confirmed.parents('.form_item').append('<div class="fs-7 fw-bold text-danger my-2 validator_tip">前后密码不一致</span></div>');
                //设置延时关闭
                setTimeout(function () {
                    password_confirmed.parents('.form_item').find('.validator_tip').remove();
                }, 5000);
                //跳出循环
                return false;
            }
            //加载loading
            var loading = loadingStart(_this, change_password_modal[0], '正在修改...');
            //发起请求
            buildRequest(change_password_modal.attr('data-query-url'), {password:password_value, password_confirmed:confirmed_password_value}, 'post', true, function (res) {
                //提示信息
                alertToast('修改成功', 2000, 'success');
                //关闭弹窗
                change_password_modal_object.hide();
            }, function (res) {
                //提示信息
                alertToast(res.msg, 2000, 'error');
            }, function () {
                //关闭loading
                loadingStop(loading, _this);
            })
        });
    }

});

/**
 * 初始化菜单
 */
function initMenus()
{
    //查询第一个当前路由的item
    var item, aside = $("#kt_aside_menu_wrapper"), header = $("#kt_header_navs_wrapper"), title = $('title'), routers = $("#acb_routers"), acb_permissions = $("#acb_permissions"), kt_toolbar_breadcrumb_title = $("#kt_toolbar_breadcrumb_title");
    //判断元素是否存在
    if (typeof acb_permissions !== 'undefined' && acb_permissions.length > 0) {
        //初始化信息
        acb_permissions = JSON.parse(acb_permissions.text().trim());
        //循环元素
        header.find('.menu-link[data-menu-type="link"]').each(function () {
            //获取配置route_names
            var route_names = $(this).attr('data-route-names'), has_permission = false;
            //判断信息
            if (typeof route_names !== 'undefined' && route_names.length > 0) {
                //拆分信息
                route_names = route_names.split(',');
                //循环路由名称
                $.each(route_names, function (i, item) {
                    //判断路由名是否存在
                    if ($.inArray(item, acb_permissions) >= 0) {
                        //设置有权限
                        has_permission = true;
                        //跳出循环
                        return false;
                    }
                });
                //判断是否有权限
                if (!has_permission) {
                    //判断侧边栏是否存在
                    if (typeof aside !== 'undefined' && aside.length > 0) {
                        //删除指定元素
                        aside.find('.aside-obj[data-did="'+$(this).attr('data-did')+'"]').remove();
                    }
                    //删除当前元素
                    $(this).parents('.menu-obj').eq(0).remove();
                }
            }
        });
        //清空剩余菜单
        clearWithoutPermissionMenus();
    }
    //循环元素
    header.find('.menu-link').each(function () {
        //获取配置route_names
        var route_names = $(this).attr('data-route-names');
        //判断信息
        if (typeof route_names !== 'undefined' && route_names.length > 0) {
            //拆分信息
            route_names = route_names.split(',');
            //判断路由名是否存在
            if ($.inArray(('get&'+ROUTE_NAME), route_names) >= 0) {
                //设置ITEM
                item = $(this);
                //跳出循环
                return false;
            }
        }
    });
    //判断是否存在
    if (typeof (item) !== 'undefined' && item.length > 0) {
        //显示菜单
        var breadcrumbs = showMenu(item.attr('data-did'), []), kt_toolbar_breadcrumbs = $("#kt_toolbar_breadcrumbs");
        //判断是否存在
        if (typeof (breadcrumbs) !== 'undefined' && breadcrumbs.length > 0) {
            //循环面包屑
            $.each(breadcrumbs, function (i, item) {
                //判断索引值
                if (parseInt(i) === 0) {
                    //设置面包屑
                    kt_toolbar_breadcrumbs.prepend('<li class="breadcrumb-item text-gray-500">'+item['name']+'</li>');
                } else {
                    //设置面包屑
                    kt_toolbar_breadcrumbs.prepend('<li class="breadcrumb-item text-gray-600"><a href="'+item['link']+'" class="text-gray-600 text-hover-primary">'+item['name']+'</a></li>');
                }
            });
        }
    }
    //设置面包屑标题
    kt_toolbar_breadcrumb_title.text(JSON.parse(routers.text().trim())['get&'+ROUTE_NAME]);
    //判断是否存在标题
    if (title.text().length <= 0) {
        //设置标题
        title.text(kt_toolbar_breadcrumb_title.text());
    }
    //移除路由信息
    routers.remove();
}

/**
 * 清除没有权限的菜单
 * @returns {boolean}
 */
function clearWithoutPermissionMenus()
{
    //获取基本信息
    var aside = $("#kt_aside_menu_wrapper");
        //循环元素
    $("#kt_header_navs_wrapper").find('.menu-obj[data-menu-type="tab"]').each(function () {
        //判断是否存在下级
        if ($(this).hasClass('menu-lg-down-accordion')) {
            //获取ID
            var did = $(this).attr('data-did');
            //查询子菜单数量
            if ($(this).find('.menu-obj[data-parent-did="'+did+'"]').length <= 0) {
                //判断侧边栏是否存在
                if (typeof aside !== 'undefined' && aside.length > 0) {
                    //删除指定元素
                    aside.find('.aside-obj[data-did="'+did+'"]').remove();
                }
                //移除当前元素
                $(this).remove();
            }
        }
    });
    //循环元素
    $("#menu_tops").find('.menu-obj[data-menu-type="nav"]').each(function () {
        //获取ID
        var did = $(this).attr('data-did');
        //查询数量
        if ($("#kt_header_navs_tab_"+did).find('.menu-obj[data-menu-type="tab"]').length <= 0) {
            //判断侧边栏是否存在
            if (typeof aside !== 'undefined' && aside.length > 0) {
                //删除指定元素
                aside.find('.aside-obj[data-did="'+did+'"]').remove();
            }
            //删除当前元素
            $(this).remove();
        }
    });
    //返回成功
    return true;
}

/**
 * 展开菜单
 * @param menu_did 菜单ID
 * @param breadcrumbs 面包屑
 * @returns {*}
 */
function showMenu(menu_did, breadcrumbs)
{
    //判断是否存在
    if (typeof (menu_did) !== 'undefined' && parseInt(menu_did) > 0) {
        //查询菜单ITEM
        var item, aside = $("#kt_aside_menu_wrapper");
        //判断手机设备还是电脑设备
        if (parseInt(MOBILE_DEVICE) === 1) {
            //查找元素
            item = $("#kt_header_navs").find('.menu-obj[data-did="'+parseInt(menu_did)+'"]')
        } else {
            //查找元素
            item = $("#kt_header").find('.menu-obj[data-did="'+parseInt(menu_did)+'"]')
        }
        //判断侧边栏是否存在
        if (typeof aside !== 'undefined' && aside.length > 0) {
            //删除指定元素
            var aside_item = aside.find('.aside-obj[data-did="'+menu_did+'"]');
            //根据类型处理
            switch (aside_item.attr('data-menu-type')) {
                case 'accordion':
                    //选中菜单
                    aside_item.removeClass('here show').addClass('here show');
                    break;
                case 'item':
                    aside_item.find('.menu-link').removeClass('active').addClass('active');
                    break;
            }
        }
        //判断是否存在
        if (typeof (item) !== 'undefined' && item.length > 0) {
            //根据目录类型处理
            switch (item.attr('data-menu-type')) {
                case 'tab':
                    //选中菜单
                    item.removeClass('here show').addClass('here show');
                    //选中菜单
                    $("#kt_header_navs_wrapper").find('.menu-link[data-did="'+menu_did+'"]').removeClass('active').addClass('active');
                    break;
                case 'nav':
                    //选中菜单
                    item.find('.nav-link').removeClass('active').addClass('active');
                    $(item.find('.nav-link').attr('href')).removeClass('active show').addClass('active show');
                    break;
                default:
                    //判断是否存在下级
                    if (item.hasClass('menu-lg-down-accordion')) {
                        //选中菜单
                        item.removeClass('here show').addClass('here show');
                    } else {
                        //选中菜单
                        $("#kt_header_navs_wrapper").find('.menu-link[data-did="'+menu_did+'"]').removeClass('active').addClass('active');
                    }
                    break;
            }
            //添加信息
            breadcrumbs.push({name: item.attr('data-guard-name'), link: item.attr('data-redirect-uri')});
            //追溯上级菜单
            showMenu(item.attr('data-parent-did'), breadcrumbs);
        }
    }
    //返回面包屑信息
    return breadcrumbs;
}


/**
 * 将指定元素移至工具栏
 * @param html
 * @param remove_target
 * @returns {boolean}
 */
function moveToToolbar(html, remove_target)
{
    var toolbars = $("#kt_dashboard_toolbar_items");
    //判断数据
    if (typeof html !== 'undefined' && html.length > 0) {
        //判断是否存在需要移除元素
        if (typeof remove_target !== 'undefined' && remove_target.length > 0) {
            //移除已存在项
            toolbars.find(remove_target).remove();
        }
        //添加内容
        toolbars.prepend(html);
        //重置tooltip
        KTApp.initBootstrapTooltips();
    }
    //返回成功
    return true;
}

/**
 * 获取随机字符串
 * @param length
 * @returns {string}
 */
function randomString(length) {
    //设置字符集
    var str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', result = '';
    //循环长度
    for (var i = length; i > 0; --i)
        //设置内容
        result += str[Math.floor(Math.random() * str.length)];
    //返回结果
    return result;
}

/**
 * container滑动至
 * @param o
 * @param container
 */
function scrollToObject(o, container)
{
    //判断container
    if (typeof container === 'undefined' || container.lenhth <= 0) {
        //设置container
        container = $('html , body');
    }
    //获取高度
    var of = o.offset().top;
    //滚动页面
    container.animate({scrollTop: parseInt(of > 200 ? (of - 160) : of)}, 1000)
}

/**
 * 开始加载loading
 * @param trigger 触发对象
 * @param target 目标对象
 * @param message 提示信息
 * @param theme 主题色
 * @returns {KTBlockUI}
 */
function loadingStart(trigger, target, message, theme)
{
    //判断对象信息
    if (typeof (trigger) === 'undefined' || trigger.length <= 0) {
        //设置主体对象
        trigger = $('body');
    }
    if (typeof (target) === 'undefined' || target.length <= 0) {
        //设置主体对象
        target = $('body');
    }
    //判断主题信息
    if (typeof (theme) === 'undefined' || theme.length <= 0) {
        //设置默认主题
        theme = 'secondary';
    }
    //判断提示信息
    if (typeof (message) === 'undefined' || message.length <= 0) {
        //设置默认提示信息
        message = '请稍后...';
    }
    //实例化处理对象
    var blockUI = new KTBlockUI(target, {
        overlayClass: "bg-"+theme+" bg-opacity-25",
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span>Loading '+message+'</div>'
    }), tagName = trigger[0].tagName;
    //判断状态
    if (!blockUI.isBlocked()) {
        //根据标签名操作
        switch (tagName) {
            case 'BUTTON':
                //判断是否存在progress
                if (trigger.find('.indicator-progress').length <= 0) {
                    //更改button内容
                    trigger.html('<span class="indicator-label">'+trigger.text()+'</span><span class="indicator-progress">'+message+'<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>');
                }
                //设置动态
                trigger.attr("data-kt-indicator", "on");
                break;
        }
        //显示加载
        blockUI.block();
    }
    //返回实例对象
    return blockUI;
}

/**
 * 停止加载
 * @param blockUI 实例对象
 * @param trigger 触发对象
 * @returns {boolean}
 */
function loadingStop(blockUI, trigger) {
    //判断对象信息
    if (typeof (trigger) === 'undefined' || trigger.length <= 0) {
        //设置主体对象
        trigger = $('body');
    }
    //获取信息
    var tagName = trigger[0].tagName;
    //判断标签
    switch (tagName) {
        case 'BUTTON':
            //设置动态
            trigger.removeAttr("data-kt-indicator");
            break;
    }
    //判断状态
    if (blockUI.isBlocked()) {
        //释放block
        blockUI.release();
    }
    //销毁block
    blockUI.destroy();
    //返回成功
    return true;
}

/**
 * 加密表单数据
 * @param encrypt_params 加密参数
 * @returns {{}|{__encrypt__}}
 */
function encryptFormData(encrypt_params)
{
    //判断是否为对象
    if (typeof (encrypt_params) === 'object') {
        //判断是否为空
        if ($.isEmptyObject(encrypt_params)) {
            //添加默认参数
            encrypt_params['__RANDOM_STRING__'] = randomString(3);
        }
        //转义信息
        var encrypt_string = JSON.stringify(encrypt_params);
        //返回信息
        return {'__encrypt__': encrypt(encrypt_string, AES_ENCRYPT_KEY, AES_IV)};
    }
    //返回空
    return {};
}

/**
 * 加密
 * @param str 加密串
 * @param key esc_keys
 * @param iv esc_iv
 * @returns {*}
 */
function encrypt(str, key, iv) {
    // //密钥16位
    key = CryptoJS.enc.Utf8.parse(key);
    // //加密向量16位
    iv = CryptoJS.enc.Utf8.parse(iv);
    //加密信息
    return CryptoJS.AES.encrypt(str, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.ZeroPadding
    }).toString();
}

/**
 * 提示信息
 * @param msg string 提示文案
 * @param timeout int >0 显示时长，<=0 不自动关闭
 * @param theme string 显示主题颜色：success|info|error|warning
 * @param title string 提示标题
 * @param position string 显示为止
 * @returns {*}
 */
function alertToast(msg, timeout, theme, title, position) {
    //整理基础配置
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toastr-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    //初始化信息
    if (typeof (timeout) === 'undefined') {
        //设置默认值
        timeout = 0;
    }
    if (typeof (theme) === 'undefined') {
        //设置默认值
        theme = 'warning';
    }
    if (typeof (position) === 'undefined') {
        //设置默认值
        toastr.options.positionClass = 'toastr-top-center';
    }
    //判断是否持续提示
    if (parseInt(timeout) <= 0) {
        //设置关闭按钮
        toastr.options.progressBar = false;
        toastr.options.extendedTimeOut = 0;
    } else {
        //取消移上停止操作
        toastr.options.tapToDismiss = true;
        //设置超时时间
        toastr.options.extendedTimeOut = parseInt(timeout) + 500;
    }
    //设置超时时间
    toastr.options.timeOut = parseInt(timeout);
    //根据主题提示
    switch (theme) {
        case 'info':
            toastr.info(msg, title);
            break;
        case 'success':
            toastr.success(msg, title);
            break;
        case 'error':
            toastr.error(msg, title);
            break;
        case 'warning':
            toastr.warning(msg, title);
            break;
        default:
            toastr.warning(msg, title);
            break;
    }
    //返回成功
    return true;
}

/**
 *
 * 序列化表单数据
 * @param data
 * @returns {{}}
 */
function serializeFormData(data)
{
    //初始化参数
    var form_data = {};
    //循环表单数据
    $.each(data, function() {
       //设置参数
       form_data[this.name] = this.value;
    });
    //返回数据
    return form_data;
}


/**
 * 创建外部引入CSS文件
 * @param href
 * @param callback
 */
function createExtraCss(href, callback)
{
    //判断是否已存在css文件
    if ($("head").find("link[href='"+href+"']").length <= 0) {
        //引入外部文件
        $("<link>").attr({rel: "stylesheet", type: "text/css", href: href}).appendTo("head");
        //执行回调
        callCustomerFunc(callback);
    } else {
        //执行回调
        callCustomerFunc(callback);
    }
}

/**
 * 创建外部引入JS文件
 * @param file
 * @param object
 * @param callback
 */
function createExtraJs(file, object, callback)
{
    //判断js是否已实例化
    if (typeof (object) == 'undefined' || object === 'undefined') {
        //引入外部文件
        $.getScript(file, function () {
            //执行回调
            callCustomerFunc(callback);
        });
    } else {
        //执行回调
        callCustomerFunc(callback);
    }
}

/**
 * 调用自定义方法
 * @param func
 */
function callCustomerFunc(func)
{
    //判断为方法
    if (typeof (func) == 'function') {
        //自定义方法调用
        return func();
    }
    //返回失败
    return false;
}

/**
 * 创建请求方法
 * @param query_url 请求链接
 * @param params 请求参数
 * @param method 请求方式
 * @param is_ajax 是否使用ajax请求
 * @param callback 成功时回调
 * @param fail_callback 失败时回调
 * @param after_ajax_callback 处理之后回调
 * @returns {boolean}
 */
function buildRequest(query_url, params, method, is_ajax, callback, fail_callback, after_ajax_callback) {
    //判断链接信息
    if (typeof (query_url) !== 'undefined' && query_url.length > 0) {
        //判断是否为ajax请求
        if (is_ajax) {
            //整理基础方法
            var func = function (res) {
                //设置ajax同步请求
                $.ajaxSettings.async = false;
                //判断回调信息
                if (typeof (after_ajax_callback) == 'function') {
                    //自定义方法调用
                    after_ajax_callback();
                }
                //判断处理状态
                if (res.state) {
                    //恢复ajax异步请求
                    $.ajaxSettings.async = true;
                    //判断回调信息
                    if (typeof (callback) == 'function') {
                        //自定义方法调用
                        return callback(res);
                    }
                } else {
                    //恢复ajax异步请求
                    $.ajaxSettings.async = true;
                    //判断回调信息
                    if (typeof (fail_callback) == 'function') {
                        //自定义方法调用
                        return fail_callback(res);
                    }
                }
            }
            //判断请求方式
            if (method.toUpperCase() === 'POST') {
                //触发post请求
                $.post(query_url, encryptFormData(params), function (res) {
                    //执行方法
                    return func(res);
                }, 'json');
            } else {
                //触发get请求
                $.get(query_url, encryptFormData(params), function (res) {
                    //执行方法
                    return func(res);
                }, 'json');
            }
        } else {
            //判断是否存在参数
            if (typeof (params) !== 'undefined' && !$.isEmptyObject(params)) {
                //整理链接参数
                var url_params = [];
                //循环参数配置信息
                $.each(params, function (i, item) {
                    //设置链接参数
                    url_params.push(i + '=' + item);
                })
                //设置链接信息
                query_url += (query_url.indexOf('?') >= 0 ? '' : '?') + url_params.join('&');
            }
            //判断回调信息
            if (typeof (callback) == 'function') {
                //自定义方法调用
                return callback(query_url);
            } else {
                //发起跳转
                window.location.href = query_url;
            }
        }
    }
    //返回失败
    return false;
}

/**
 * 确认弹窗
 * @param tip
 * @param success
 * @param fail
 * @param timeout
 * @returns {boolean}
 */
function confirmPopup(tip, success, fail, timeout) {
    //判断延时信息
    if (typeof (timeout) === 'undefined') {
        //设置默认10
        timeout = 10000;
    }
    //提示信息
    Swal.fire({
        text: tip,
        icon: "info",
        buttonsStyling: false,
        position: 'center',
        timer: timeout,
        timerProgressBar: true,
        showCancelButton: true,
        confirmButtonText: "确定",
        cancelButtonText: '取消',
        allowOutsideClick: false,
        customClass: {
            confirmButton: "btn btn-primary btn-sm",
            cancelButton: 'btn btn-danger btn-sm'
        },
    }).then(function(isConfirmed) {
        //判断是否确认
        if (isConfirmed.isConfirmed) {
            return typeof (success) !== 'undefined' && success ? success() : true;
        } else {
            return typeof (fail) !== 'undefined' && fail ? fail() : true;
        }
    });
    //返回成功
    return true;
}
