@extends('home.base')

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
					用户管理
				</div>
			</div>
            <div class="navbar-collapse collapse">
    			<ul class="nav navbar-nav navbar-right">
    				<li>
    					<form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/user/search') }}" method="POST">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            
    						<div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="name" value="{{$name}}" class="form-control" placeholder="账号/手机号" value="{{old('name')}}">
                                    <div class="input-group-btn">
                                        <button id="user-search" type="submit" class="btn btn-default">搜索</button>
                                    </div><!-- /btn-group -->
                                </div><!-- /input-group -->    							
    						</div>
    					</form>
    				</li>
    			</ul>
            </div>
			<div id="warning" class="alert alert-danger" role="alert" style="display: none">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong id="showtext"></strong>
            </div>
		</div>
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-12">
    				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#adduser">
                        <i class="glyphicon glyphicon-edit"></i> 新增用户
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
    							<th>用户角色</th>
    							<th>部门</th>
    							<th>状态</th>
    							<th>性别</th>
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
    								<td>{{ $val->department_val }}</td>
    								<td>{{ $val->status_val }}</td>
    								<td>
    									@if($val->sex == 1)
    										<span>男</span>
    									@else
    										<span>女</span>
    									@endif
    								</td>
    								<td>
    									<button data-toggle="modal" class="btn btn-default btn-sm" onclick="editUser({{ $val->id }})" value="{{ $val->id }}">修改</button>
    									<button class="btn btn-default btn-sm mr-r" onclick=" destroyUser({{ $val->id }})" value="{{ $val->id }}">删除</button>
    									<button class="btn btn-default btn-sm" data-toggle="modal" onclick="addRole({{$val->id}})"  value="{{ $val->id }}">设置角色</button>
    								</td>
    							</tr>
    						@endforeach
    					</tbody>
    				</table>
                </div>
            </div>
            <div class="row">
				@if($data->render() !== "")
					<div class="col-md-12 text-center">
						{!! $data->appends(['name' => $name])->render() !!}
					</div>
				@endif
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
                                    <label for="inputGeneral_taxpayer" class="col-sm-2 control-label　p-0 lh-34 m-56">部门</label>
                                    <div class="col-sm-10">
                                        <div class="radio-inline">
                                            <label class="mr-3r">
                                                <input name="department" value="0" type="radio">默认
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="1" type="radio">fiu&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="2" type="radio">D3IN&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="3" type="radio">海外
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
                                <div class="form-group">
                                    <label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">审核：</label>
                                    <div class="col-sm-8">
                                        <div class="radio-inline">
                                            <label class="mr-3r">
                                                <input name="status" value="1" type="radio"> 已审核&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="status" value="0" type="radio"> 未审核
                                            </label>
                                        </div>
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
			<div class="modal fade" id="updateuser2" tabindex="-1" role="dialog" aria-labelledby="updateuser2Label">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">更改用户</h4>
						</div>
						<div class="modal-body">
							<form id="updateuser2" role="form" class="form-horizontal" method="post" action="{{ url('/user/update') }}">
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
                                    <label for="inputGeneral_taxpayer" class="col-sm-2 control-label　p-0 lh-34 m-56">部门</label>
                                    <div class="col-sm-10">
                                        <div class="radio-inline">
                                            <label class="mr-3r">
                                                <input name="department" value="0" type="radio" id="department0">默认
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="1" type="radio" id="department1">fiu&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="2" type="radio" id="department2">D3IN&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="3" type="radio" id="department3">海外
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
                                <div class="form-group">
                                    <label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">审核：</label>
                                    <div class="col-sm-8">
                                        <div class="radio-inline">
                                            <label class="mr-3r">
                                                <input name="status" value="1" type="radio" id="status1"> 已审核&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="status" value="0" type="radio" id="status0"> 未审核
                                            </label>
                                        </div>
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
            },
            department: {
                validators: {
                    notEmpty: {
                        message: '部门不能为空！'
                    }
                }
            },
            status: {
                validators: {
                    notEmpty: {
                        message: '请选择激活状态！'
                    }
                }
            },
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
			$("#account2").val(e.data.account);
			$("#phone2").val(e.data.phone);
			$("#realname2").val(e.data.realname);
			if(e.data.status==1){
				$("#status1").prop('checked','true');
			}else{
				$("#status0").prop('checked','true');
			}

			if(e.data.sex==1){
				$("#sex11").prop('checked','true');
			}else{
				$("#sex00").prop('checked','true');
			}

			if(e.data.department==0){
                $("#department0").prop('checked','true');
            }else if(e.data.department==1){
                $("#department1").prop('checked','true');
            }else if(e.data.department==2){
                $("#department2").prop('checked','true');
            }else{
                $("#department3").prop('checked','true');
            }
			$('#updateuser2').modal('show');
			}
		},'json');
	}


	function addRole(id) {
		var user_id = id;
        
        $.get('/roleUser/edit', {'_token': _token, 'user_id': user_id}, function(e){
            if (e.status) {
                var template = $('#set-role-form').html();
                
                var views = Mustache.render(template, e.data);
                $("#set_user_role").html(views);
                
                $('#addRole').modal('show');
                
            }
        }, 'json');
        
		$('#addRoleUser').click(function(e){
			var role_id = new Array();
            $("input[name='role_id']:checked").each(function(){
                role_id.push($(this).val());
            });
            $.post('/roleUser/store', {"_token": _token, "user_id": user_id, "role_id": role_id},function(e){
    			if(e.status){
    				$('#addRole').modal('hide');
    				location.reload();
    			}
    		},'json');
        });
		
	}

	
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