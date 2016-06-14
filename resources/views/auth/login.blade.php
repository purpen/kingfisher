@extends('auth.base')

@section('title', 'login')

@section('customize_css')
    @parent
        #login-block{
            min-height: 305px;
        }
        .error_message{
            padding: 0px 0px 5px;
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
            <div id="erp-content" class="col-md-12"></div>
            <div id="login-block" class="right">
                <h3>登录太火鸟ERP系统</h3>
                <form id="loginForm" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    @if (session('error_message'))
                        <div class="col-sm-10 col-sm-offset-2 error_message">
                            <p class="text-danger">{{ session('error_message') }}</p>
                        </div>
                    @endif
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-sm-2 control-label">手机</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="输入手机号码"  value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
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
                    <div class="form-group">
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> 记住我
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4 forgetpass text-right">
                            <a class="erp-link" href="#" role="button">忘记密码？</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-default erp-button erp-login">登录</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            还没有帐号？<a class="erp-link" href="/register" role="button">立即注册</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    
@endsection

@section('customize_js')
    @parent
        // 表单验证
        $('#loginForm').formValidation({
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
                }
            }
        });
@endsection
