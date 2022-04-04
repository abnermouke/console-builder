{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '系统配置')

{{--是否显示侧边栏--}}
@section('enable_aside', 1)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
        ($builder = (new \Abnermouke\ConsoleBuilder\Builders\Form\ConsoleFormBuilder(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::FORM_WITH_KM8)))
            ->setTitle('系统配置', '更改App应用相关配置，系统将在一定时间内自动更新并开始使用最新配置进行执行操作。')
            ->submit($builder->buildButton()->title('保存配置')->ajax(route('abnermouke.console.configs.store'), 'post', \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormButtonBuilder::AJAX_AFTER_RELOAD)->confirm_before_query('系统配置保存成功后将立即生效，确认继续？'))
            ->setItems(function () {
                return ($formItemBuilder = (new \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormItemsBuilder()))
                    ->addItem($formItemBuilder->buildInput('APP_TITLE', '应用/站点名称')->required())
                    ->addItem($formItemBuilder->buildTextarea('APP_DESCRIPTION', '应用/站点描述')->required())
                    ->addItem($formItemBuilder->buildTags('APP_KEYWORDS', '应用/站点关键词')->required())
                    ->addItem($formItemBuilder->buildImage('APP_LOGO', 'LOGO')->size('500x500')->dictionary('configs/images')->required())
                    ->addItem($formItemBuilder->buildImage('APP_SHORTCUT_ICON', '小图标')->size('50x50')->dictionary('configs/images')->required())
                    ->addItem($formItemBuilder->buildRadio('CONSOLE_DEFAULT_THEME', '控制台主题')->options_with_descriptions(['auto' => '自动', 'light' => '明亮模式', 'dark' => '夜间模式'], ['auto' => '系统将在晚上19：00至次日凌晨06：00自动使用夜间模式，其余时间使用明亮模式', 'light' => '全天保持明亮模式展示', 'dark' => '全天保持夜间模式展示'], 'auto'))
                    ->addItem($formItemBuilder->buildSwitch('CONSOLE_WECHAT_OAUTH', '开启控制台微信登录')->allow_text('开启')->on(\App\Model\Abnermouke\Console\Configs::SWITCH_ON, ['WECHAT_OFFICE_ACCOUNT_PARAMS__app_id', 'WECHAT_OFFICE_ACCOUNT_PARAMS__secret', 'WECHAT_OFFICE_ACCOUNT_PARAMS__token', 'WECHAT_OFFICE_ACCOUNT_PARAMS__aes_key'])->off(\App\Model\Abnermouke\Console\Configs::SWITCH_OFF))
                    ->addItem($formItemBuilder->buildInput('WECHAT_OFFICE_ACCOUNT_PARAMS__app_id', '微信公众号APPID')->clipboard())
                    ->addItem($formItemBuilder->buildInput('WECHAT_OFFICE_ACCOUNT_PARAMS__secret', '微信公众号APP密钥')->clipboard())
                    ->addItem($formItemBuilder->buildInput('WECHAT_OFFICE_ACCOUNT_PARAMS__token', '微信公众号通讯TOKEN')->clipboard())
                    ->addItem($formItemBuilder->buildInput('WECHAT_OFFICE_ACCOUNT_PARAMS__aes_key', '微信公众号AES KEY')->clipboard())
                    ->addItem($formItemBuilder->buildEditor('PRIVACY_POLICY', '隐私政策', \Abnermouke\ConsoleBuilder\Builders\Form\Items\EditorItemBuilder::CK_EDITOR)->required())
                    ->addItem($formItemBuilder->buildEditor('USER_AGREEMENT', '用户服务协议', \Abnermouke\ConsoleBuilder\Builders\Form\Items\EditorItemBuilder::CK_EDITOR)->required())
                    ->addItem($formItemBuilder->buildInput('SMS_SECOND_FREQUENCY_LIMIT', '同一手机号码获取短信最小时间间隔', 'number')->min(60)->default_value(60)->required()->append('秒'))
                    ->addItem($formItemBuilder->buildInput('SMS_DAY_FREQUENCY_LIMIT', '同一手机号码每天可获取短信条数', 'number')->min(0)->default_value(20)->required()->append('条'))
                    ->addItem($formItemBuilder->buildInput('SMS_UNIVERSAL_CODE', '短信万能验证码')->default_value((string)auto_datetime('md'))->required()->clipboard())
                    ->addItem($formItemBuilder->buildSelect('SMS_DEFAULT_GATEWAYS', '短信默认网关')->options()->required()->options(['ali_sms' => '阿里云SMS服务']))
                    ->addItem($formItemBuilder->buildInput('SMS_ALI_PARAMS__access_key_id', 'AccessKey ID')->clipboard()->tip('用于标识用户'))
                    ->addItem($formItemBuilder->buildInput('SMS_ALI_PARAMS__access_key_secret', 'AccessKey Secret')->clipboard()->tip('用于验证用户的密钥，AccessKey Secret必须保密。'))
                    ->addItem($formItemBuilder->buildInput('SMS_ALI_PARAMS__sign_name', '短信签名')->clipboard()->tip('短信签名需特别申请，详看流程操作！'))
                    ->addItem($formItemBuilder->buildInput('GEETEST_PARAMS__geetest_id', '极验ID')->clipboard())
                    ->addItem($formItemBuilder->buildInput('GEETEST_PARAMS__geetest_key', '极验KEY')->clipboard())
                    ->addItem($formItemBuilder->buildInput('GEETEST_PARAMS__token', '极验通讯TOKEN')->clipboard())
                    ->addItem($formItemBuilder->buildInput('GEETEST_PARAMS__aes_key', '极验AES KEY')->clipboard())
                    ->addItem($formItemBuilder->buildInput('TEMPORARY_FILES_AUTO_DELETE_SECOND_LIMIT', '临时文件自动删除时间', 'number')->min(3600)->default_value(86400)->required()->append('秒'))
                    ->addItem($formItemBuilder->buildInput('AMAP_WEB_SERVER_API_KEY', '高德地图WEB服务API KEY')->clipboard())
                   ;
            })
            ->addStructure($builder->buildStructure()->addFiled('APP_TITLE', 6)->addFiled('APP_KEYWORDS', 6)->addFiled('APP_DESCRIPTION', 12)->addFiled('APP_SHORTCUT_ICON', 12)->addFiled('APP_LOGO', 12))
            ->addStructure($builder->buildStructure()->title('控制台配置')->addFiled('CONSOLE_DEFAULT_THEME', 12)->addFiled('CONSOLE_WECHAT_OAUTH', 12)->addFiled('WECHAT_OFFICE_ACCOUNT_PARAMS__app_id', 3)->addFiled('WECHAT_OFFICE_ACCOUNT_PARAMS__secret', 3)->addFiled('WECHAT_OFFICE_ACCOUNT_PARAMS__token', 3)->addFiled('WECHAT_OFFICE_ACCOUNT_PARAMS__aes_key', 3))
            ->addStructure($builder->buildStructure()->title('短信服务配置')->addFiled('SMS_SECOND_FREQUENCY_LIMIT', 4)->addFiled('SMS_DAY_FREQUENCY_LIMIT', 4)->addFiled('SMS_UNIVERSAL_CODE', 4)->addFiled('SMS_DEFAULT_GATEWAYS', 12)->addFiled('SMS_ALI_PARAMS__access_key_id', 4)->addFiled('SMS_ALI_PARAMS__access_key_secret', 4)->addFiled('SMS_ALI_PARAMS__sign_name', 4))
            ->addStructure($builder->buildStructure()->title('极验服务配置')->addFiled('GEETEST_PARAMS__geetest_id', 3)->addFiled('GEETEST_PARAMS__geetest_key', 3)->addFiled('GEETEST_PARAMS__token', 3)->addFiled('GEETEST_PARAMS__aes_key', 3))
            ->addStructure($builder->buildStructure()->title('自动化配置')->addFiled('TEMPORARY_FILES_AUTO_DELETE_SECOND_LIMIT', 12))
            ->addStructure($builder->buildStructure()->title('高德地图服务配置')->addFiled('AMAP_WEB_SERVER_API_KEY', 12))
            ->addStructure($builder->buildStructure()->addFiled('PRIVACY_POLICY', 12)->addFiled('USER_AGREEMENT', 12))
            ->setData($configs)
            ->render();
    !!}
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
