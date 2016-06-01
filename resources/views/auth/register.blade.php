@extends('auth.base')

@section('title', 'register')

@section('customize_css')
    @parent
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
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
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
                        <div class="col-sm-10 col-sm-offset-2 text-warning hidden" id="img-verify-error-message">
                            <strong>验证码长度错误，请重新输入！</strong>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="password" placeholder="输入密码" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone-verify" class="col-sm-2 control-label erp-verify">验证码</label>
                        <div class="col-sm-7">
                            <input type="text" name="phone-verify" class="form-control" id="phone-verify" placeholder="输入手机验证码" readonly>
                        </div>
                        <div class="col-sm-3 erp-verify">
                            <a class="btn btn-default" id="send-verify" href="javascript:void(0);" role="button">发送验证码</a>
                        </div>
                        <div class="col-sm-10 col-sm-offset-2 text-warning hidden" id="verify-error-message">
                            <strong>请先输入正确的验证码，才能进行其他操作！</strong>
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
        // 请求确认验证码是否填写正确
        $('#verify').change(function(){
            var value = $(this).val();
            var _token = $('input:hidden').val();
            if(value.length !== 5){
                $('#img-verify-error-message').addClass("show");
                $("#img-verify-error-message").removeClass("hidden");
                return false;
            }
            if(!$('input[name=phone]').val()){
                $('#img-verify-error-message').addClass("show");
                $("#img-verify-error-message").removeClass("hidden");
                $('#img-verify-error-message').find('strong').text('请先输入手机号码，才能进行其他操作！');
                return false;
            }
            $.post('/captcha',{captcha:value,  _token: _token},function(data){
                var obj = eval("("+data+")");
                if(obj.status){
                    $('input[name=password]').removeAttr('readonly');
                    $('input[name=phone-verify]').removeAttr('readonly');
                }
                console.log(obj);
            });
        });
        // 发送手机验证码
        $('#send-verify').click(function(){
            if(!is_form){
                $('#verify-error-message').addClass("show");
                $("#verify-error-message").removeClass("hidden");
                return false;
            }
            if(!$('input[name=phone]').val()){
                $('#verify-error-message').addClass("show");
                $("#verify-error-message").removeClass("hidden");
                $('#verify-error-message').find('strong').text('请先输入手机号码，才能进行其他操作！');
                return false;
            }
            $('input[name=password]').removeAttr('readonly');
            $('input[name=phone-verify]').removeAttr('readonly');
            alert('ok');
        });
@endsection
