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
                                @if($path == null)
                                <img class="user img-circle" src="{{ url('images/default/headportrait.jpg') }}" align="absmiddle">
                                @else
                                <img class="user img-circle" src="{{$path}}" align="absmiddle">
                                @endif
                            </a>
                            <input type="hidden" value="{{$token}}" id="tokens">
                            <input type="hidden" value="{{$path}}" id="path">
                            <input type="hidden" value="{{url('images/default/headportrait.jpg')}}" id="patht">
                            <div class="media-body">
                                <span class="label label-danger">{{ Auth::user()->roles()->first()->display_name }}</span>
                                <h4 class="media-heading mt-2r">{{ Auth::user()->account }}</h4>    
                                <p class="mt-2r">
                                    {{ $content }}
                                </p>                             
                            </div>
                        </div>
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
                            <ul class="list-group">
                                @foreach($messages as $message)
                                    <li class="row list-group-item list-group-item-warning">
                                        <span class="col-sm-11">{{$message->message}}</span>
                                        <span>
                                            <button class="btn btn-primary col-sm-1" type="button" id="confirm" value="{{$message->id}}">
                                                确认处理
                                            </button>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            @if ($messages)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">{!! $messages->render() !!}</div>
                </div>
            @endif
		</div>

    </div>
@endsection
@section('customize_js')
    @parent
    $("#confirm").click(function () {
        var id = $(this).attr('value');
        var _token = $("#_token").val();
        var dom = $(this).parent().parent();
        $.post('{{url('/home/ajaxConfirm')}}',{'_token':_token,'id':id},function (e) {
            if(e.status){
                dom.remove();
            }else{
                alert('e.message');
            }
        },'json');
    });

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