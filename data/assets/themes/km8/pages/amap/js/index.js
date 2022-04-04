$(function () {
    //获取基础参数
    var buttons = $("#amap_buttons"), box = $("#amap_box");
    //判断元素是否存在
    if (typeof buttons !== 'undefined' && buttons.length > 0) {
        //移动按钮
        moveToToolbar(buttons.html(), '.amap_button');
        //删除按钮
        buttons.remove();
        //设置触发
        $('#sync_amap_data_button').on('click', function () {
            //触发同步
            syncAmap($(this));
        });
    } else {
        //设置触发
        $("#sync_amap_data_button_with_api_key").on('click', function () {
            //触发同步
            syncAmap($(this));
        });
    }
    //循环item
    box.find('.amap_box_items').each(function () {
        //判断元素数量
        if ($(this).find('.amap_box_items_line').length <= 5) {
            //触发第一个点击
            $(this).find('.amap_box_items_line').eq(0).find('[data-bs-toggle="collapse"]').trigger('click');
        }
    });
});

/**
 * 同步高德地图
 * @param _this
 */
function syncAmap(_this)
{
    // 获取基础信息
    var amap_box = $("#amap_box"), query_url = amap_box.attr('data-query-url'), amap_web_server_api_key = $("#amap_web_server_api_key"), params = {};
    //判断信息是否存在
    if (typeof amap_web_server_api_key !== 'undefined' && amap_web_server_api_key.length > 0) {
        //获取内容
        var amap_web_server_api_key_value = amap_web_server_api_key.val();
        //判断可用性
        if (typeof amap_web_server_api_key_value === 'undefined' || amap_web_server_api_key_value.length <= 0) {
            //提示错误
            alertToast('请输入申请的API Key', 2000, 'info');
            //返回失败
            return true;
        }
        //设置参数
        params['amap_web_server_api_key'] = amap_web_server_api_key_value;
    }
    //提示信息
    confirmPopup('同步行政区域预计需要3-5分钟，期间请耐心等待，是否继续？', function () {
        //加载
        var loading = loadingStart(_this, amap_box[0], '正在同步最新数据...');
        //发起请求
        buildRequest(query_url, params, 'post', true, function () {
            //提示成功
            alertToast('同步成功', 2000, 'success');
            //刷新页面
            window.location.reload();
        }, function (res) {
            //提示错误
            alertToast(res.msg, 2000, 'error');
        }, function () {
            //关闭弹窗
            loadingStop(loading, _this);
        })
    });
}
