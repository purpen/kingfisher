@extends('home.base')

@section('title', '用户管理')
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
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						用户管理
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
			<div class="row">
				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#adduser">
                    <i class="glyphicon glyphicon-edit"></i> 新增用户
                </button>
			</div>
			{{--添加--}}
			<div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">新增用户</h4>
						</div>
						<div class="modal-body">
							<form id="addusername" role="form" class="form-horizontal" method="post" action="{{ url('/user/store') }}">
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
									<label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
									<div class="col-sm-8">
										<input type="text" name="realname" class="form-control float" id="realname" placeholder="姓名">
									</div>
								</div>
                                <div class="form-group">
                                    <label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">审核：</label>
                                    <div class="col-sm-8">
                                        <input type="radio" name="status" value="1"> 已审核&nbsp&nbsp
                                        <input type="radio" name="status" value="0"> 未审核
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
			<div class="modal fade" id="updateuser" tabindex="-1" role="dialog" aria-labelledby="updateuserLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">更改用户</h4>
						</div>
						<div class="modal-body">
							<form id="updateuser" role="form" class="form-horizontal" method="post" action="{{ url('/user/update') }}">
								<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
								<input type="hidden" name="id" id="user_id" >
								<div class="form-group">
									<label for="account" class="col-sm-2 control-label p-0 lh-34 m-56">帐号：</label>
									<div class="col-sm-8">
										<input type="text" name="account" class="form-control float" id="account1" placeholder="帐号" disabled="disabled">
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="col-sm-2 control-label p-0 lh-34 m-56">手机号：</label>
									<div class="col-sm-8">
										<input type="text" name="phone" class="form-control float" id="phone1" placeholder="手机号码" disabled="disabled">
									</div>
								</div>
								<div class="form-group">
									<label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
									<div class="col-sm-8">
										<input type="text" name="realname" class="form-control float" id="realname1" placeholder="姓名">
									</div>
								</div>
                                <div class="form-group">
                                    <label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">审核：</label>
                                    <div class="col-sm-8">
                                        <input type="radio" name="status" value="1" id="status1"> 已审核&nbsp&nbsp
                                        <input type="radio" name="status" value="0" id="status0"> 未审核
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
							<h4 class="modal-title" id="gridSystemModalLabel">新增角色用户</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" role="form" method="POST" action="">
								<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
								<div class="form-group">
									<label for="display_name" class="col-sm-2 control-label p-0 lh-34 m-56">角色</label>
									<div class="col-sm-8">
										<select class="selectpicker" id="role_id" name="role_id" style="display: none;">
											<option value="">选择角色</option>
											@foreach($role as $r)
												<option value="{{$r->id}}">{{$r->display_name}}</option>
											@endforeach
										</select>
									</div>
								</div>


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

			<div class="row">
				<table class="table table-bordered table-striped">
					<thead>
						<tr class="gblack">
							<th>用户ID</th>
							<th>账号 / 姓名</th>
							<th>手机号</th>
							<th>用户角色</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $val)
							<tr>
								<td>{{ $val->id }}</td>
								<td class="magenta-color">{{ $val->account }} @if ($val->realname) / {{ $val->realname }} @endif</td>
								<td>{{ $val->phone }}</td>
								<td>
									@foreach($val->roles as $role)
										{{$role->display_name}} /  
									@endforeach
								</td>
								<td>{{ $val->status_val }}</td>
								<td>
									<button data-toggle="modal" data-target="#updateuser" class="btn btn-default btn-sm" onclick="editUser({{ $val->id }})" value="{{ $val->id }}">修改</button>
									<button class="btn btn-default btn-sm mr-r" onclick=" destroyUser({{ $val->id }})" value="{{ $val->id }}">删除</a>
									<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#addRole" onclick="addRole({{$val->id}})"  value="{{ $val->id }}">设置角色</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				@if($data->render() !== "")
					<div class="col-md-6 col-md-offset-5">
						{!! $data->render() !!}
					</div>
				@endif
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
            }
        }
    });

	$(".check-btn input").click(function(){
		var keys = $(this).attr('key');
    	if( $("input[key= "+keys+"]").is(':checked') ){
    		$(this).siblings().addClass('active');
    	}else{
    		$(this).siblings().removeClass('active');
    	}
    })



	function editUser(id) {
		$.get('/user/ajaxEdit',{'id':id},function (e) {
			if (e.status == 1){
			$("#user_id").val(e.data.id);
			$("#account1").val(e.data.account);
			$("#phone1").val(e.data.phone);
			$("#realname1").val(e.data.realname);
			if(e.data.status==1){
				$("#status1").prop('checked','true');
			}else{
				$("#status0").prop('checked','true');
			}
			$('#updateuser').modal('show');
			}
		},'json');
	}


	function addRole(id) {
		var user_id = id;
		$('#addRoleUser').click(function(e){
			var role_id = $('#role_id').val();
		$.post('/roleUser/store',{"_token": _token, "user_id": user_id, "role_id": role_id},function(e){
			if(e.status == 1){
				$('#addRole').modal('hide');
				location.reload();
			}

		},'json')

		})
	}

	var _token = $("#_token").val();
	function destroyUser (id) {
		if(confirm('确认删除该用户吗？')){
			$.post('/user/destroy',{"_token":_token,"id":id},function (e) {
				if(e.status == 1){
					location.reload();
				}
			},'json');
		}

	}


@endsection