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
				{{--<ul class="nav navbar-nav nav-list">--}}
					{{--<li @if($tab_menu == 'all') class="active"@endif><a href="{{url('/user')}}">全部</a></li>--}}
					{{--<li @if($tab_menu == 'default') class="active"@endif><a href="{{url('/user/default')}}">默认</a></li>--}}
					{{--<li @if($tab_menu == 'fiu') class="active"@endif><a href="{{url('/user/fiu')}}">Fiu店</a></li>--}}
					{{--<li @if($tab_menu == 'd3in') class="active"@endif><a href="{{url('/user/d3in')}}">D3IN</a></li>--}}
					{{--<li @if($tab_menu == 'abroad') class="active"@endif><a href="{{url('/user/abroad')}}">海外</a></li>--}}
					{{--<li @if($tab_menu == 'onlineRetailers') class="active"@endif><a href="{{url('/user/onlineRetailers')}}">电商</a></li>--}}
					{{--<li @if($tab_menu == 'support') class="active"@endif><a href="{{url('/user/support')}}">支持</a></li>--}}
				{{--</ul>--}}
				<ul class="nav navbar-nav nav-list">
					<li @if($type == 10) class="active"@endif><a href="{{url('/user?type=10')}}">全部</a></li>
					<li @if($type == 1) class="active"@endif><a href="{{url('/user?type=1')}}">ERP</a></li>
					<li @if($type == 2) class="active"@endif><a href="{{url('/user?type=2')}}">C端</a></li>

					<li @if($supplier_distributor_type == 1) class="active"@endif><a href="{{url('/user?supplier_distributor_type=1')}}">分销商</a></li>
					<li @if($supplier_distributor_type == 2) class="active"@endif><a href="{{url('/user?supplier_distributor_type=2')}}">供应商</a></li>
				</ul>
    			<ul class="nav navbar-nav navbar-right">
    				<li>
    					<form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/user/search') }}" method="POST">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" id="supplier_distributor_type" name="supplier_distributor_type" value="{{$supplier_distributor_type}}">
                            <input type="hidden" id="type" name="type" value="{{$type}}">
                            <input type="hidden" id="status" name="status" value="{{$status}}">
                            <input type="hidden" id="department" name="department" value="{{$department}}">
							<div class="form-group">
								<span>审核状态</span>
								<div class="input-group">
									<select class="form-control selectpicker" name="status" style="display: none;">
										<option @if($status == 10) selected @endif value="10">选择</option>
										<option @if($status == 0) selected @endif value="0">未审核</option>
										<option @if($status == 1) selected @endif value="1">已审核</option>
									</select>
								</div>

							</div>
							<div class="form-group">
								<span>部门</span>
								<div class="input-group">
									<select class="form-control selectpicker" name="department" style="display: none;">
										<option @if($department == 10) selected @endif value="10">选择</option>
										<option @if($department == 0) selected @endif value="0">默认</option>
										<option @if($department == 1) selected @endif value="1">Fiu</option>
										<option @if($department == 2) selected @endif value="2">D3IN</option>
										<option @if($department == 3) selected @endif value="3">海外</option>
										<option @if($department == 4) selected @endif value="4">电商</option>
										<option @if($department == 5) selected @endif value="5">支持</option>
									</select>
								</div>

							</div>
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
								<th>性别</th>
    							<th>用户来源</th>
    							<th>注册时间</th>
    							<th>审核状态</th>
    							<th>操作</th>
    						</tr>
    					</thead>
    					<tbody>
    						@foreach ($data as $val)
    							<tr>
    								<td>{{ $val->id }}</td>
    								<td class="magenta-color">{{ $val->account }} @if ($val->realname) <hr> {{ $val->realname }} @endif</td>
    								<td>{{ $val->phone }}</td>
    								<td>
    									@foreach($val->roles as $role)
    										{{$role->display_name}} /  
    									@endforeach
    								</td>
    								<td>{{ $val->department_val }}</td>
    								<td>
    									@if($val->sex == 1)
    										<span>男</span>
    									@else
    										<span>女</span>
    									@endif
    								</td>
									<td>
										@if($val->type == 0)
											<span>erp后台用户</span>

										@elseif($val->type == 1)
											<span>分销商用户</span>

										@elseif($val->type == 2)
											<span>c端用户</span>
										@elseif($val->type == 3)
											<span>供应商</span>
										@endif
									</td>
									<td>
										{{ $val->created_at }}
									</td>
									<td>{{ $val->status_val }}</td>
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
						{!! $data->appends(['name' => $name , 'type' => $type , 'department' => $department , 'status' => $status])->render() !!}
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
									<label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
									<div class="col-sm-8">
										<input type="text" name="realname" class="form-control float" id="realname" placeholder="姓名">
									</div>
								</div>
								<div class="form-group">
									<label for="type" class="col-sm-2 control-label p-0 lh-34 m-56">是否Erp</label>
									<div class="col-sm-10">
										<div class="radio-inline">
											<label class="mr-3r">
												<input name="type" value="0" type="radio">否
											</label>
											<label class="ml-3r">
												<input name="type" value="1" type="radio">是&nbsp&nbsp&nbsp&nbsp
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="supplier_distributor_type" class="col-sm-2 control-label p-0 lh-34 m-56">供应分销</label>
									<div class="col-sm-10">
										<div class="radio-inline">
											<label class="ml-3r">
												<input name="supplier_distributor_type" value="1" type="radio">分销商&nbsp&nbsp&nbsp&nbsp
											</label>
											<label class="ml-3r">
												<input name="supplier_distributor_type" value="2" type="radio">供应商
											</label>

										</div>
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
                                                <input name="department" value="1" type="radio">Fiu店&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="2" type="radio">D3IN&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="3" type="radio">海外
                                            </label>

                                        </div>
                                    </div>
									<div class="col-sm-10">
										<div class="radio-inline">
											<label class="mr-3r">
												<input name="department" value="4" type="radio">电商
											</label>
											<label class="ml-3r">
												<input name="department" value="5" type="radio">支持
											</label>
										</div>
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
								<div class="form-group">
									<label for="" class="col-sm-2 control-label p-0 lh-34 m-56">密码：</label>
									<div class="col-sm-8">

										<p style="color:#f36">Thn140301</p>
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
									<label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
									<div class="col-sm-8">
										<input type="text" name="realname" class="form-control float" id="realname2" placeholder="姓名">
									</div>
								</div>
								<div class="form-group">
									<label for="type" class="col-sm-2 control-label p-0 lh-34 m-56">是否Erp</label>
									<div class="col-sm-10">
										<div class="radio-inline">
											<label class="mr-3r">
												<input name="type" value="0" type="radio" id="type0">否
											</label>
											<label class="ml-3r">
												<input name="type" value="1" type="radio" id="type1">是&nbsp&nbsp&nbsp&nbsp
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="supplier_distributor_type" class="col-sm-2 control-label p-0 lh-34 m-56">供应分销</label>
									<div class="col-sm-10">
										<div class="radio-inline">
											<label class="ml-3r">
												<input name="supplier_distributor_type" value="1" type="radio" id="supplier_distributor_type1">分销商&nbsp&nbsp&nbsp&nbsp
											</label>
											<label class="ml-3r">
												<input name="supplier_distributor_type" value="2" type="radio" id="supplier_distributor_type2">供应商
											</label>

										</div>
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
                                                <input name="department" value="1" type="radio" id="department1">Fiu店&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="2" type="radio" id="department2">D3IN&nbsp&nbsp&nbsp&nbsp
                                            </label>
                                            <label class="ml-3r">
                                                <input name="department" value="3" type="radio" id="department3">海外
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="radio-inline">
                                            <label class="mr-3r">
                                                <input name="department" value="4" type="radio" id="department4">电商
                                            </label>
											<label class="ml-3r">
												<input name="department" value="5" type="radio" id="department5">支持
											</label>
                                        </div>
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
            }else if(e.data.department==3){
                $("#department3").prop('checked','true');
            }else if(e.data.department==4){
                $("#department4").prop('checked','true');
            }else {
				$("#department5").prop('checked','true');
			}

			if(e.data.type==0){
				$("#type0").prop('checked','true');
			}else if(e.data.type==1){
				$("#type1").prop('checked','true');
			}

			if(e.data.supplier_distributor_type==1){
				$("#supplier_distributor_type1").prop('checked','true');
			}else if(e.data.supplier_distributor_type==2){
				$("#supplier_distributor_type2").prop('checked','true');
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

	/*搜索下拉框*/
	$(".chosen-select").chosen({
		no_results_text: "未找到：",
		search_contains: true,
		width: "100%",
	});

	//select单击提交表单
	function submitForm(){
		var form = document.getElementById("type_search");//获取form表单对象
		form.submit();//form表单提交
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