@extends('home.base')

@section('customize_css')
    @parent
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						编辑个人资料
					</div>
				</div>
				<ul class="nav navbar-nav navbar-right mr-0">
					<li class="dropdown">
						<form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/user/search') }}" method="POST">
							<div class="form-group">
								<input type="text" name="name" class="form-control" placeholder="请输入账号/手机号" value="{{old('name')}}">
								<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
							</div>
							<button id="user-search" type="submit" class="btn btn-default">搜索</button>
						</form>
					</li>
				</ul>
				<div id="warning" class="alert alert-danger" role="alert" style="display: none">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="showtext"></strong>
                </div>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row formwrapper">
                <div class="col-md-12">
                    <form id="updateuser" id="update-user-info" role="form" class="form-horizontal" method="post" action="{{ url('/user/update') }}">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" value="{{ $user->id }}">              
                        <h5>个人信息</h5>
                        <hr>
                        <div class="form-group">
                            <label for="account" class="col-sm-2 control-label">帐号：</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="帐号" value="{{ $user->account }}" disabled>
                            </div>
                            
                            <label for="phone" class="col-sm-1 control-label">手机号：</label>
                            <div class="col-sm-4">
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="手机号码">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="realname" class="col-sm-2 control-label">姓名：</label>
                            <div class="col-sm-4">
                                <input type="text" value="{{ $user->realname }}" name="realname" class="form-control" placeholder="姓名">
                            </div>
                            <label for="email" class="col-sm-1 control-label">邮箱：</label>
                            <div class="col-sm-4">
                                <input type="text" value="{{ $user->email }}" name="email" class="form-control" placeholder="邮箱">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="sex" class="col-sm-2 control-label">性别: </label>
                            <div class="col-sm-8">
                                <div class="radio-inline">
                                    <label class="mr-3r">
                                        <input name="sex" value="1" type="radio" @if($user->sex == 1)checked @endif> 男
                                    </label>
                                    <label class="ml-3r">
                                        <input name="sex" value="0" type="radio" @if($user->sex == 0)checked @endif> 女
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <input type="hidden" id="cover_id" name="cover_id">
                                <div id="picForm" enctype="multipart/form-data">
                                    <div class="img-add">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <p>添加头像</p>
                                    </div>
                                    <div id="fine-user-uploader" class="upload-button"></div>
                                </div>
                                <div id="upload-result">
                                    @if ($user->cover)
                                        <div class="asset">
                                            <img src="{{ $user->cover->path }}" style="width: 100px;" class="img-thumbnail">
                                            <a class="removeimg" value="{{ $user->cover->id }}">删除</a>
                                        </div>
                                    @endif
                                </div>
                                <script type="text/template" id="qq-template">
                                    <div id="add-img" class="qq-uploader-selector qq-uploader">
                                        <div class="qq-upload-button-selector qq-upload-button">
                                            <div>上传头像</div>
                                        </div>
                                        <ul class="qq-upload-list-selector qq-upload-list">
                                            <li hidden></li>
                                        </ul>
                                    </div>
                                </script>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button type="submit" class="btn btn-magenta">确认更新</button>
                                <button type="button" class="btn btn-default" onclick="history.back()">取消</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
			</div>
		</div>
    </div>
@endsection

@section('load_private')
    kingfisher.user_avatar_upload('{{ $user->id }}', '{{ $uptoken }}', '{{ $upload_url }}');
    
	$('#updateuser').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email不能为空！'
                    }
                }
            },
			realname: {
				validators: {
					notEmpty: {
						message: '姓名不能为空！'
					}
				}
			},
            phone: {
                validators: {
                    notEmpty: {
                        message: '手机号不能为空！'
                    },
					regexp: {
						regexp: /^1[34578][0-9]{9}$/,
						message: '手机号码不合法！'
					}
                }
            }
        }
    });
@endsection