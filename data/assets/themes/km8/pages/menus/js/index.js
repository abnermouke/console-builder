$(function () {
    //获取基础参数
    var buttons = $("#menu_trigger_buttons"), body = $('body');
    //判断元素是否存在
    if (typeof buttons !== 'undefined' && buttons.length > 0) {
        //移动按钮
        moveToToolbar(buttons.html(), '.menu_trigger_buttons');
        //删除按钮
        buttons.remove();
    }
    //设置触发
    body.on('click', '.menu_trigger_delete', function () {
        //获取对象
        var _trigger = $(this);
        //确认弹窗
        confirmPopup('删除菜单后，其子菜单将一并删除，是否继续？', function () {
            //触发操作
            triggerQuery(_trigger.attr('data-query-url'), {}, 'delete', _trigger);
        });
    }).on('click', '.menu_trigger_edit', function () {
        //触发操作
        triggerQuery($(this).attr('data-query-url'), {}, 'edit', $(this));
    }).on('click', '.menu_trigger_insert', function () {
        //触发操作
        triggerQuery($(this).attr('data-query-url'), {}, 'insert', $(this));
    });
});

/**
 * 触发请求
 * @param query_url
 * @param params
 * @param action
 * @param _trigger
 */
function triggerQuery(query_url, params, action, _trigger)
{
    //加载
    var loading = loadingStart(_trigger, $("#kt_content")[0], '正在处理...'), modal = $("#menu_trigger_modal");
    //发起请求
    buildRequest(query_url, params, 'post', true, function (res) {
        //根据操作类型处理
        switch (action) {
            case 'edit':
            case 'insert':
                //添加内容
                modal.find('.modal-body').empty().html(res.data['html']);
                //设置选中
                $.fn.modal.Constructor.prototype.enforceFocus = function() {
                    modal.find('input').focus();
                };
                //显示弹窗
                new bootstrap.Modal(modal[0]).show();
                //引入实例对象
                createExtraJs(modal.attr('data-source-path')+'/form-builder.js', $.form_builder, function () {
                    //设置modal触发
                    modal.find('.acb-form-builder.form').attr('data-dropdown-modal-id', modal.find('.acb-form-builder.form').attr('id'));
                    //创建处理实例对象
                    $.form_builder.init(modal.find('.acb-form-builder.form').attr('data-sign'));
                    //延迟移除按钮
                    setTimeout(function () {
                        //移除按钮
                        $("#kt_dashboard_toolbar_items").find('.acbf_button').remove();
                    }, 3000);
                });
                break;
            case 'delete':
                //提示信息
                alertToast('删除成功', 2000, 'success');
                //刷新页面
                window.location.reload();
                break;
            default:
                //刷新页面
                window.location.reload();
                break;
        }

    }, function (res) {
        //提示错误
        alertToast(res.msg, 2000, 'error');
    }, function () {
        //关闭弹窗
        loadingStop(loading, _trigger);
    });

}

