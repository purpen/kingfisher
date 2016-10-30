@extends('home.base')

@section('title', '控制台')

@section('customize_css')
    @parent
        .console {
            background-color: #fff;
            margin-top: 20px;
            padding: 20px;
        }
        .console .user {
            width: 100px;
        }
        .messages p {
            padding: 15px;
            margin-bottom: 10px;
        }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="console">
                        <div class="media">
                            <a class="media-left" href="#">
                                <img class="user img-circle" src="{{ url('images/default/headportrait.jpg') }}" align="absmiddle">
                            </a>
                            <div class="media-body">
                                <span class="label label-danger">{{ Auth::user()->roles()->first()->display_name }}</span>
                                <h4 class="media-heading">{{ Auth::user()->account }}</h4>                                 
                            </div>
                        </div>
                        <p class="" style="height:80px;background:greenyellow;">
                            {{$content}}
                        </p>
                        <hr>
                        <div class="tip-buttons">
                            <a class="btn btn-default" href="#">
                                 待发货订单 <span class="badge">0</span>
                            </a>
                            <a class="btn btn-default" href="#">
                                 售后订单 <span class="badge">0</span>
                            </a>
                        </div>
                        <hr>
                        <div class="messages">
                            <div class="page-header">
                                <h5>操作记录 <small>注意警告或错误提醒</small></h5>
                            </div>
                            
                            <p class="bg-success">
                                这是成功信息
                            </p>
                            <p class="bg-info">
                                这是提醒信息
                            </p>
                            <p class="bg-warning">
                                这是警告信息
                            </p>
                            <p class="bg-danger">
                                这是错误信息
                            </p>
                            
                            
                        </div>
                    </div>
                </div>
            </dov>
		</div>
    </div>
@endsection
@section('customize_js')
    @parent
	$('#addusername').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: '帐号不能为空！'
                    }
                }
            },
            tel: {
                validators: {
                    notEmpty: {
                        message: '手机号不能为空！'
                    }
                }
            }
        }
    });

@endsection