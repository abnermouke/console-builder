{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '短信发送记录')

{{--是否显示侧边栏--}}
@section('enable_aside', 0)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    @if(data_get((new \App\Handler\Cache\Data\Abnermouke\Console\ConfigCacheHandler())->get('SMS_ALI_PARAMS', ''), 'access_key_id', false))
        {!!
           ($builder = new \Abnermouke\ConsoleBuilder\Builders\Table\ConsoleTableBuilder(route('abnermouke.console.sms.lists'), \App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::TABLE_WITH_KM8))
           ->setFields(function () use ($builder) {
               return ($fieldBuilder = new \Abnermouke\ConsoleBuilder\Builders\Table\Tools\TableFieldsBuilder())
                   ->addField($fieldBuilder->buildTexts('texts', '短信信息')->template('{mobile}')->description('{content}')->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_STATUS_THEME, 'status'))
                   ->addField($fieldBuilder->buildString('gateway', '网关')->show(false))
                   ->addField($fieldBuilder->buildString('sign_name', '签名')->bold()->theme('primary'))
                   ->addField($fieldBuilder->buildString('template_id', '模版ID'))
                   ->addField($fieldBuilder->buildOption('status', '处理状态')->options(\App\Model\Abnermouke\Console\SmsLogs::TYPE_GROUPS['__status__'])->theme_options(\App\Builders\Abnermouke\Console\ConsoleBuilderBasicTheme::DEFAULT_STATUS_THEME)->bold())
                   ->addField($fieldBuilder->buildString('result_code', '结果编码')->show(false))
                   ->addField($fieldBuilder->buildString('ip', '操作IP'))
                   ->addField($fieldBuilder->buildDate('created_at', '创建时间')->format('Y-m-d H:i:s'))
                   ->addField($fieldBuilder->buildDate('updated_at', '编辑时间')->format('Y-m-d H:i:s')->show(false));
           })
          ->addFilter($builder->filterAsInput()->field('__keyword__')->guard_name('关键词搜索')->placeholder('请输入手机号码/短信内容/短信签名/模版ID/网关等关键词检索')->col(6))
           ->addFilter($builder->filterAsInput()->date_range('Y-m-d H:i:00')->field('created_at')->guard_name('创建时间'))
           ->render();
       !!}
    @else
        {!!
        ($builder = (new \Abnermouke\ConsoleBuilder\Builders\Form\ConsoleFormBuilder()))
            ->setTitle('阿里云SMS短信配置', '推荐您默认使用阿里云SMS短信服务，短信的内容多用于企业向用户传递验证码、系统通知、会员服务等。可点击链接 <a href="https://help.aliyun.com/document_detail/337013.html" target="_blank">https://help.aliyun.com/document_detail/337013.html</a> 根据提示进行操作。')
            ->submit($builder->buildButton()->title('确认配置')->ajax(route('abnermouke.console.sms.store'), 'post', \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormButtonBuilder::AJAX_AFTER_RELOAD)->confirm_before_query('短信服务配置成功后将立即生效，确认继续？'))
            ->setItems(function () {
                return ($formItemBuilder = (new \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormItemsBuilder()))
                    ->addItem($formItemBuilder->buildInput('access_key_id', 'AccessKey ID')->required()->clipboard()->tip('用于标识用户'))
                    ->addItem($formItemBuilder->buildInput('access_key_secret', 'AccessKey Secret')->required()->clipboard()->tip('用于验证用户的密钥，AccessKey Secret必须保密。'))
                    ->addItem($formItemBuilder->buildInput('sign_name', '短信签名')->required()->clipboard()->tip('短信签名需特别申请，详看流程操作！'));
            })
            ->addStructure($builder->buildStructure()->addFiled('access_key_id', 4)->addFiled('access_key_secret', 4)->addFiled('sign_name', 4))
            ->render();
    !!}
    @endif
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
