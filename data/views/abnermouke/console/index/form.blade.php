{{--继承模版--}}
@extends('abnermouke.console.layouts.master')

{{--页面标题--}}
@section('title', '表单构建器')

{{--是否显示侧边栏--}}
@section('enable_aside', 1)

{{--自定义样式--}}
@section('styles')

@endsection

{{--主体内容--}}
@section('container')
    {!!
           ($builder = (new \Abnermouke\ConsoleBuilder\Builders\Form\ConsoleFormBuilder()))
            ->setTitle('ConsoleBuilder-Form', 'ConsoleBuilder是一款完整的管理后台/控制面板构建工具包，一键安装即可搭建一套完整后台模版，内含一套完整表格、表单构建器，开发高效，体验优良！')
            ->submit($builder->buildButton()->ajax(route('abnermouke.console.delete'), 'post')->title('立即提交')->confirm_before_query('是否确认提交已更改的表单数据？'))
            ->back($builder->buildButton()->url(route('abnermouke.console.oauth.index'), 'get', true)->title('返回列表')->theme('danger'))
            ->setItems(function () {
                return ($formItemBuilder = (new \Abnermouke\ConsoleBuilder\Builders\Form\Tools\FormItemsBuilder()))
                   ->addItem($formItemBuilder->buildInput('input_clipboard', '输入框')->tip('基础输入框')->required()->max_length(50)->clipboard())
                   ->addItem($formItemBuilder->buildInput('input_link', '输入框', 'url')->tip('基础输入框')->required()->max_length(50))
                   ->addItem($formItemBuilder->buildInput('input', '输入框', 'number')->tip('基础输入框')->required())
                   ->addItem($formItemBuilder->buildInput('date', '日期', 'date')->date_format('Y-m-d H:i:00', true))
                   ->addItem($formItemBuilder->buildInput('color', '颜色', 'color'))
                   ->addItem($formItemBuilder->buildSelect('select', '选择框')->options(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__status__']))
                   ->addItem($formItemBuilder->buildTextarea('textarea', '文本框')->clipboard()->max_length(200)->row(5))
                   ->addItem($formItemBuilder->buildTags('tags', '标签'))
                   ->addItem($formItemBuilder->buildSwitch('switch', '开关')->on(\Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_ON, ['image', 'file'])->off(\Abnermouke\EasyBuilder\Module\BaseModel::SWITCH_OFF, ['linkage']))
                   ->addItem($formItemBuilder->buildLinkage('linkage', '联动', proxy_assets('linkage.json', '', false))->level(3))
                   ->addItem($formItemBuilder->buildRadio('radio', '单选')->options(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'], \App\Model\Abnermouke\Console\Admins::SWITCH_ON))
                   ->addItem($formItemBuilder->buildRadio('normal_radio', '单选（带描述）')->options_with_descriptions(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'], [1 => 'Add data-clipboard-action="cut"to the action button element to define a cut action. Then add the clipboard JS to initialize it.', 2 => 'Add the data-clipboard-textto an action button and it will copy the value set on click. Then add the clipboard JS to initialize it.'], \App\Model\Abnermouke\Console\Admins::SWITCH_ON))
                   ->addItem($formItemBuilder->buildRadio('image_radio', '单选（完整 - 描述、图片）')->required()->options_with_images(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'], [1 => 'Add data-clipboard-action="cut"to the action button element to define a cut action. Then add the clipboard JS to initialize it.', 2 => 'Add the data-clipboard-textto an action button and it will copy the value set on click. Then add the clipboard JS to initialize it.'], [1 => 'ON', 2 => 'OFF'], \App\Model\Abnermouke\Console\Admins::SWITCH_ON))
                   ->addItem($formItemBuilder->buildCheckbox('checkbox', '多选')->options(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'], \App\Model\Abnermouke\Console\Admins::SWITCH_ON))
                   ->addItem($formItemBuilder->buildCheckbox('normal_checkbox', '多选（带描述）')->options_with_descriptions(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'], [1 => 'Add data-clipboard-action="cut"to the action button element to define a cut action. Then add the clipboard JS to initialize it.', 2 => 'Add the data-clipboard-textto an action button and it will copy the value set on click. Then add the clipboard JS to initialize it.'], \App\Model\Abnermouke\Console\Admins::SWITCH_ON))
                   ->addItem($formItemBuilder->buildCheckbox('image_checkbox', '多选（完整 - 描述、图片）')->required()->options_with_images(\App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__switch__'], [1 => 'Add data-clipboard-action="cut"to the action button element to define a cut action. Then add the clipboard JS to initialize it.', 2 => 'Add the data-clipboard-textto an action button and it will copy the value set on click. Then add the clipboard JS to initialize it.'], [1 => 'ON', 2 => 'OFF'], \App\Model\Abnermouke\Console\Admins::SWITCH_ON))
                   ->addItem($formItemBuilder->buildImage('image', '图片上传'))
                   ->addItem($formItemBuilder->buildFiles('file', '文件上传')->multiple())
                   ->addItem($formItemBuilder->buildValues('values', '自定义内容')->addInput('text', '文本')->addSwitch('switch', '开关')->addSelect('select', '选择框', \App\Model\Abnermouke\Console\Admins::TYPE_GROUPS['__status__']))
                   ->addItem($formItemBuilder->buildEditor('editor', '富文本'))
                   ;
            })
            ->addStructure($builder->buildStructure()->addFiled('input', 4)->addFiled('input_link', 8)->addFiled('input_clipboard', 6)->addFiled('date', 6)->addFiled('color')->addFiled('tags', 12))
            ->addStructure($builder->buildStructure()->addFiled('select'))
            ->addStructure($builder->buildStructure()->addFiled('radio')->addFiled('normal_radio')->addFiled('image_radio'))
            ->addStructure($builder->buildStructure()->addFiled('checkbox')->addFiled('normal_checkbox')->addFiled('image_checkbox'))
            ->addStructure($builder->buildStructure()->addFiled('textarea'))
            ->addStructure($builder->buildStructure()->addFiled('switch'))
            ->addStructure($builder->buildStructure()->addFiled('linkage'))
            ->addStructure($builder->buildStructure()->addFiled('image')->addFiled('file'))
            ->addStructure($builder->buildStructure()->addFiled('values'))
            ->addStructure($builder->buildStructure()->addFiled('editor'))
            ->render();
        !!}
@endsection

{{--自定义弹窗--}}
@section('popups')

@endsection

{{--自定义javascript--}}
@section('script')

@endsection
