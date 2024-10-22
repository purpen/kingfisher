@extends('auth.base')

@section('title', '找回密码')

@section('customize_css')
    @parent
        .control-label{
            text-align: left !important;
            padding-left: 20px !important;
        }
        #login-block{
            min-height: 305px;
        }
        .erp-verify{
            padding: 0;
        }
        .text-warning{
            margin-top: 10px;
        }
        #erp-verify{
            cursor: pointer;
            width: 120px;
            height: 36px;
        }
        #send-verify{
            position: relative;
            left: -7px;
        }
        .phone-error-message{
            color: #a94442;
        }
@endsection

@section('header')
    @parent
    
@endsection

@section('content')
    @parent
    <?php //var_dump(session()->all()) ?>
    <div class="container-fluid" id="container">
        <div class="row">
            <div id="login-block">
                <form id="forgetForm" class="form-horizontal" role="form" method="POST" action="{{ url('/forget') }}">
                    <h3>找回密码</h3>
                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="phone_verify_key"  value="{{ $data['phone_verify_key'] }}">
                    <input type="hidden" name="type"  value="3">
                    @if (session('error_message'))
                        <div class="col-sm-10 col-sm-offset-2">
                            {{ session('error_message') }}
                        </div>
                    @endif
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-sm-2 control-label" value="{{ $data['phone_verify_key'] }}">手机</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="输入手机号码"  value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="verify" class="col-sm-2 control-label erp-verify">验证码</label>
                        <div class="col-sm-6">
                            <input type="text" name="verify" class="form-control" id="verify" placeholder="输入验证码">
                        </div>
                        <div class="col-sm-4 erp-verify">
                            <img id="erp-verify" src="{!! captcha_src() !!}" alt="captcha">
                        </div>
                    </div>                
                    <div class="form-group{{ $errors->has('phone_verify') ? ' has-error' : '' }}">
                        <label for="phone-verify" class="col-sm-2 control-label erp-verify" style="padding-top:0px">手机<br />验证码</label>
                        <div class="col-sm-7">
                            <input type="text" name="phone_verify" class="form-control" id="phone-verify" placeholder="输入手机验证码" readonly>
                            @if ($errors->has('phone_verify'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_verify') }}</strong>
                                </span>
                            @endif
                            @if (session('phone-error-message'))
                                <span class="help-block phone-error-message">
                                    {{ session('phone-error-message') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-sm-3 erp-verify">
                            <a class="btn btn-default" id="send-verify" href="javascript:void(0);" role="button">发送验证码</a>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="password" placeholder="输入密码"  value="{{ old('password') }}" >
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('repassword') ? ' has-error' : '' }}">
                        <label for="password" class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="repassword" class="form-control" id="repassword" placeholder="两次密码必须一致"  value="{{ old('repassword') }}" >
                            @if ($errors->has('repassword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('repassword') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-magenta erp-button erp-login">重置密码</button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    
@endsection

@section('customize_js')
    @parent
    
        // 定义全局变量
        var is_form = 0; // 判断是否允许提交表单
        var is_send = 1; // 判断是否发送验证码
        var type = 3;//状态值为3
        // 获取验证码
        $('#erp-verify').click(function(){
            var html = $(this);
            $.get('/captcha',function(data){
                html.attr('src',data);
            });
        });
        
        // 删除错误信息方法
        var remove_message = function(){
            var element = $('.erp-message-error');
            if(element.html()){
                element.remove();
            }
        }
        
        // 发送验证码计时器
        function start_sms_button(obj){
            var count = 0 ;
            var sum = 30;
            var i = setInterval(function(){
                if(count <= sum){
                    obj.text('剩余'+parseInt(sum - count)+'秒');
                }else{
                    obj.text('发送验证码');
                    is_send = 1;
                    clearInterval(i);
                }
                count++;
            },1000);
        }
        
        // 发送手机验证码
        $('#send-verify').click(function(){
            remove_message();
            if(!is_send){
                return false;
            }
            if(!is_form){
                $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter('#phone-verify').html("输入验证码错误，请重新输入！");
                return false;
            }
            if(!$('input[name=phone]').val()){
                $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter('#phone-verify').html("输入手机号码，请重新输入！");
                return false;
            }
            start_sms_button($('#send-verify'));
            $('input[name=phone_verify]').removeAttr('readonly');
            var phone = $('input[name=phone]').val();
            var _token = $('input[name=_token]').val();

            var phone_verify_key = $('input[name=phone_verify_key]').val();
            $.post('/captcha/phone',{phone:phone, _token: _token}, function(data){
                var date_obj = data;
                {{--console.log(date_obj);--}}
                if(!date_obj.status){
                    $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter('#phone-verify').html(date_obj.message);
                    return false;
                }else{
                    $.post('/captcha/send',{ phone:phone,  _token: _token, phone_verify_key: phone_verify_key, type:type},function(data){
                        var date_obj = eval("("+data+")");
                        {{--console.log(date_obj);--}}
                        if(!date_obj.status){
                            $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter('#phone-verify').html(date_obj.message);
                            return false;
                        }
                        is_send = 0;
                    });
                }

            }, 'json');


        });
        
        // 表单验证
        $('#forgetForm').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                phone: {
                    validators: {
                        notEmpty: {
                            message: '手机号码不能为空！'
                        },

                        regexp: {
                            regexp: /^1[34578][0-9]{9}$/,
                            message: '手机号码不合法！'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '用户密码不能为空！'
                        },
                        stringLength: {
                            min: 6,
                            max: 16,
                            message: '密码必须由6-16位的字母数字组成！'
                        }
                    }
                },
                repassword: {
                    validators: {
                        notEmpty: {
                            message: '确认密码不能为空！'
                        },
                        stringLength: {
                            min: 6,
                            max: 16,
                            message: '密码必须由6-16位的字母数字组成！'
                        },
                        identical: {
                            field: 'password',
                            message: '两次密码不一样,请重新输入！'
                        }
                    }
                },
                verify: {
                    validators: {
                        notEmpty: {
                            message: '验证码不能为空！'
                        },
                        stringLength: {
                            min: 5,
                            max: 5,
                            message: '验证码必须是5个字符！'
                        }
                    },
                    onError: function(e, data) {
                        remove_message();
                    },
                    onSuccess: function(e, data) {
                        if (!data.fv.isValidField('phone')) {
                            $("input[name=verify]").val('');
                            data.fv.revalidateField('phone');
                            data.fv.revalidateField('verify');
                            return false;
                        }
                        
                        if(!is_form){
                            var insert_message = data.element;
                            // 请求确认验证码是否填写正确
                            var value = $('#verify').val();
                            var _token = $('input[name=_token]').val();
                            $.post('/captcha',{captcha:value,  _token: _token},function(data){
                                var obj = eval("("+data+")");
                                if(obj.status){
                                    remove_message();
                                    $('input[name=password]').removeAttr('readonly');
                                    $('<small/>').addClass('help-block erp-message-success').css('color','#3c763d;').insertAfter(insert_message).html("输入验证码正确，请继续操作！");
                                    is_form = 1;
                                }else{
                                    $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter(insert_message).html("输入验证码错误，请重新输入！");
                                    // 更新验证码
                                    $.get('/captcha',function(data){
                                        $('#erp-verify').attr('src',data);
                                    });
                                }
                            });
                        }
                    }
                },
                phone_verify: {
                    validators: {
                        notEmpty: {
                            message: '手机验证码不能为空！'
                        },
                        stringLength: {
                            min: 6,
                            max: 6,
                            message: '手机验证码必须是6个字符！'
                        }
                    },
                    onError: function(e, data) {
                        remove_message();
                    },
                    onSuccess: function(e, data) {
                        if (!data.fv.isValidField('phone')) {
                            data.fv.revalidateField('phone');
                            return false;
                        }
                        
                        var insert_message = data.element;
                        // 请求确认验证码是否填写正确
                        var phone_verify = $('#phone-verify').val();
                        var phone = $('#phone').val();
                        var _token = $('input[name=_token]').val();
                        $.post('/captcha/is_exist',{phone:phone, code:phone_verify,  _token: _token},function(data){
                            var obj = eval("("+data+")");
                            if(obj.status){
                                remove_message();
                                $('<small/>').addClass('help-block erp-message-success').css('color','#3c763d;').insertAfter(insert_message).html("输入手机验证码正确，请继续！");
                            }else{
                                $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter(insert_message).html("输入手机验证码错误，请重新输入！");
                                $('#phone-verify').val('');
                            }
                        });
                    }
                }
            }
        }).on('err.form.fv', function(e) {
            remove_message();
        });
    
@endsection

