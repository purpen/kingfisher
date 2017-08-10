@extends('fiu.base')

@section('customize_css')
    @parent
        .check-btn{
            padding: 10px 0;
    		height: 30px;
    		position: relative;
    		margin-bottom: 10px !important;
    		margin-left: 10px !important;
        }
        .check-btn input{
	        z-index: 2;
		    width: 100%;
		    height: 100%;
		    top: 6px !important;
		    opacity: 0;
		    left: 0;
    		margin-left: 0 !important;
		    color: transparent;
		    background: transparent;
		    cursor: pointer;
        }
        .check-btn button{
			position: relative;
		    top: -11px;
		    left: 0;
        }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					分销商管理
				</div>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav nav-list">
					<li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/user/noStatus')}}">草稿箱</a></li>
					<li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/user')}}">已审核</a></li>
				</ul>
			</div>
		</div>
		@if (session('error_message'))
			<div class="alert alert-success error_message">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p class="text-danger">{{ session('error_message') }}</p>
			</div>
		@endif
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-12">
    				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addDistributor">
                        <i class="glyphicon glyphicon-edit"></i> 新增分销商
                    </button>
                </div>
			</div>
			

			<div class="row">
                <div class="col-md-12">
    				<table class="table table-bordered table-striped">
    					<thead>
    						<tr class="gblack">
    							<th>用户ID</th>
    							<th>账号 / 姓名</th>
    							<th>手机号</th>
    							<th>性别</th>
    							<th>审核状态</th>
    							<th>操作</th>
    						</tr>
    					</thead>
    					<tbody>
    						@foreach ($users as $user)
    							<tr>
    								<td>{{ $user->id }}</td>
    								<td class="magenta-color">{{ $user->account }} @if ($user->realname) / {{ $user->realname }} @endif</td>
    								<td>{{ $user->phone }}</td>
    								<td>
    									@if($user->sex == 1)
    										<span>男</span>
    									@else
    										<span>女</span>
    									@endif
    								</td>
									<td>
										@if ($user->status == 1)
											<span class="label label-success">是</span>
										@else
											<span class="label label-danger">否</span>
										@endif
									</td>
    								<td>
										@if ($user->status == 1)
											<a href="/fiu/saas/user/{{ $user->id}}/unStatus" class="btn btn-sm btn-danger  mr-2r">关闭</a>
										@else
											<a href="/fiu/saas/user/{{ $user->id}}/status" class="btn btn-sm btn-success  mr-2r">开启</a>
										@endif
    									<button data-toggle="modal" class="btn btn-default btn-sm mr-2r" onclick="editDistributor({{ $user->id }})" value="{{ $user->id }}">修改</button>
    									<button class="btn btn-default btn-sm mr-2r" onclick=" destroyDistributor({{ $user->id }})" value="{{ $user->id }}">删除</button>
    								</td>
    							</tr>
    						@endforeach
    					</tbody>
    				</table>
                </div>
            </div>
            <div class="row">
				@if($users->render())
					<div class="col-md-12 text-center">
						{!! $users->render() !!}
					</div>
				@endif
			</div>
            
            
			{{--添加--}}
			<div class="modal fade" id="addDistributor" tabindex="-1" role="dialog" aria-labelledby="addDistributorLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">新增用户</h4>
						</div>
						<div class="modal-body">
							<form id="addDistributorUser" role="form" class="form-horizontal" method="post" action="{{ url('/fiu/saas/user/store') }}">
								<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
								<div class="form-group">
									 <label for="account" class="col-sm-2 control-label p-0 lh-34 m-56">帐号：</label>
									<div class="col-sm-8">
										<input type="text" name="account" class="form-control float" id="account" placeholder="帐号">
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="col-sm-2 control-label p-0 lh-34 m-56">手机号：</label>
									<div class="col-sm-8">
										<input type="text" name="phone" class="form-control float" id="phone" placeholder="手机号码">
									</div>
								</div>
								<div class="form-group">
									<label for="inputGeneral_taxpayer" class="col-sm-2 control-label　p-0 lh-34 m-56">性别</label>
									<div class="col-sm-10">
                                        <div class="radio-inline">
                                            <label class="mr-3r">
                                                <input name="sex" value="1" type="radio" id="sex1"> 男
                                            </label>
                                            <label class="ml-3r">
                                                <input name="sex" value="0" type="radio" id="sex0"> 女
                                            </label>
                                        </div>
									</div>
								</div>
								<div class="form-group">
									<label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
									<div class="col-sm-8">
										<input type="text" name="realname" class="form-control float" id="realname" placeholder="姓名">
									</div>
								</div>
								<div class="form-group mb-0">
									<div class="modal-footer pb-0">
										<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
										<button type="submit" class="btn btn-magenta">确定</button>
									</div>
								</div>
							</form>
			            </div>
			        </div>
			    </div>
			</div>
			{{--更新--}}
			<div class="modal fade" id="updateDistributor" tabindex="-1" role="dialog" aria-labelledby="updateDistributorLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">更改用户</h4>
						</div>
						<div class="modal-body">
							<form id="updateDistributor" role="form" class="form-horizontal" method="post" action="{{ url('/fiu/saas/user/update') }}">
                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
								<input type="hidden" name="id" id="user_id" >
								<div class="form-group">
									<label for="account" class="col-sm-2 control-label p-0 lh-34 m-56">帐号：</label>
									<div class="col-sm-8">
										<input type="text" name="account" class="form-control float" id="account2" placeholder="帐号" disabled="disabled">
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="col-sm-2 control-label p-0 lh-34 m-56">手机号：</label>
									<div class="col-sm-8">
										<input type="text" name="phone" class="form-control float" id="phone2" placeholder="手机号码" disabled="disabled">
									</div>
								</div>
								<div class="form-group">
									<label for="inputGeneral_taxpayer" class="col-sm-2 control-label　p-0 lh-34 m-56">性别</label>
									<div class="col-sm-10">
                                        <div class="radio-inline">
                                            <label class="mr-3r">
                                                <input name="sex" value="1" type="radio" id="sex11"> 男
                                            </label>
                                            <label class="ml-3r">
                                                <input name="sex" value="0" type="radio" id="sex00"> 女
                                            </label>
                                        </div>
									</div>
								</div>
								<div class="form-group">
									<label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
									<div class="col-sm-8">
										<input type="text" name="realname" class="form-control float" id="realname2" placeholder="姓名">
									</div>
								</div>
								<div class="form-group mb-0">
									<div class="modal-footer pb-0">
										<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
										<button type="submit" class="btn btn-magenta">确定</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			{{--新增角色--}}
			<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">设置用户角色</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" role="form" method="POST" action="">   
                                <div id="set_user_role"></div>
                            	<div class="form-group mb-0">
                            		<div class="modal-footer pb-r">
                            			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            			<button type="button" class="btn btn-magenta " id="addRoleUser">确定</button>
                            		</div>
                            	</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    @include('mustache.set_role_form')
@endsection
@section('customize_js')
    @parent

    var _token = $("#_token").val();
    
	$('#addDistributorUser').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            account: {
                validators: {
                    notEmpty: {
                        message: '帐号不能为空！'
                    }
                }
            },
			realname: {
				validators: {
					notEmpty: {
						message: '昵称不能为空！'
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
            },
        }
    });

	function editDistributor(id) {
		$.get('/fiu/saas/user/ajaxEdit',{'id':id},function (e) {
			if (e.status == 1){
			$("#user_id").val(e.data.id);
			$("#account2").val(e.data.account);
			$("#phone2").val(e.data.phone);
			$("#realname2").val(e.data.realname);
			if(e.data.sex==1){
				$("#sex11").prop('checked','true');
			}else{
				$("#sex00").prop('checked','true');
			}
			$('#updateDistributor').modal('show');
			}
		},'json');
	}

	function destroyDistributor (id) {
		if(confirm('确认删除该用户吗？')){
			$.post('/fiu/saas/user/destroy',{"_token":_token,"id":id},function (e) {
				if(e.status == 1){
					location.reload();
				}
			},'json');
		}

	}

@endsection

@section('load_private')
	@parent
	$(".check-btn input").click(function(){
		var keys = $(this).attr('key');
		if( $("input[key= "+keys+"]").is(':checked') ){
			$(this).siblings().addClass('active');
		}else{
			$(this).siblings().removeClass('active');
		}
	})
@endsection