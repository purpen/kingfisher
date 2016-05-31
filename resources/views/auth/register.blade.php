@extends('auth.base')

@section('title', 'register')

@section('customize_css')
    @parent
        #login-block{
            width: 500px;
        }
        .erp-verify{
            padding-left: 6px;
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
            <div id="login-block" class="right">
                <h3>注册太火鸟ERP系统</h3>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">手机</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="输入手机号码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="输入密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">验证码</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="输入验证码">
                        </div>
                        <div class="col-sm-3 erp-verify">
                            <a class="btn btn-default erp-button" href="" role="button">发送验证码</a>
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
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    
@endsection

@section('customize_js')
    @parent
        
@endsection
