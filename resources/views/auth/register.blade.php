@extends('auth.base')

@section('title', '注册')

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
@endsection

@section('header')
    @parent
    
@endsection

@section('content')
    @parent
    <div class="container-fluid" id="container">
        <div class="row">
            <div id="erp-content" class="col-md-12"></div>
            <div id="login-block">
                <form id="productForm" class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    <h3>注册太火鸟ERP系统</h3>
                    {!! csrf_field() !!}
                    @if (session('error_message'))
                        <div class="col-sm-10 col-sm-offset-2 text-warning">
                            {{ session('error_message') }}
                        </div>
                    @endif
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-sm-2 control-label">手机</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="输入手机号码">
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
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="password" placeholder="输入密码" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone-verify" class="col-sm-2 control-label erp-verify" style="padding-top:0px">手机<br />验证码</label>
                        <div class="col-sm-7">
                            <input type="text" name="phone_verify" class="form-control" id="phone-verify" placeholder="输入手机验证码" readonly>
                        </div>
                        <div class="col-sm-3 erp-verify">
                            <a class="btn btn-default" id="send-verify" href="javascript:void(0);" role="button">发送验证码</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-default erp-button erp-login">注册</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            已有帐号？<a class="erp-link" href="#" role="button">请登录</a>
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
        
        // 定义全局变量-判断是否允许提交表单
        var is_form = 0;
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
        
        // 发送手机验证码
        $('#send-verify').click(function(){
            remove_message();
            if(!is_form){
                $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter('#phone-verify').html("输入验证码错误，请重新输入！");
                return false;
            }
            if(!$('input[name=phone]').val()){
                $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter('#phone-verify').html("输入手机号码，请重新输入！");
                return false;
            }
            $('input[name=phone_verify]').removeAttr('readonly');
            var phone = $('input[name=phone]').val();
            var _token = $('input:hidden').val();
            $.post('/captcha/send',{ phone:phone,  _token: _token},function(data){
                //var date_obj = eval("("+data+")");
                console.log(data);
            });
        });
        
        $('#productForm').formValidation({
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
                            var _token = $('input:hidden').val();
                            $.post('/captcha',{captcha:value,  _token: _token},function(data){
                                var obj = eval("("+data+")");
                                if(obj.status){
                                    remove_message();
                                    $('input[name=password]').removeAttr('readonly');
                                    $('<small/>').addClass('help-block erp-message-success').css('color','#3c763d;').insertAfter(insert_message).html("输入验证码正确，请继续操作！");
                                    is_form = 1;
                                }else{
                                    $('<small/>').addClass('help-block erp-message-error').css('color','#a94442').insertAfter(insert_message).html("输入验证码错误，请重新输入！");
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
                    }
                }
            }
        }).on('err.form.fv', function(e) {
            remove_message();
        });
@endsection
