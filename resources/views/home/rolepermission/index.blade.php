@extends('home.base')

@section('title', '角色权限')
	
@section('customize_css')
    @parent
    .check-btn{
        width: 46px;
	    height: 30px;
	    position: relative;
    }
    .check-btn input{
        z-index: 2;
	    width: 100%;
	    height: 100%;
	    top: 6px !important;
	    opacity: 0;
	    color: transparent;
	    background: transparent;
	    cursor: pointer;
    }
    .check-btn button{
		position: absolute;
    	top: -4px;
    	left: 0;
    }
    .permission-list .item {
        border-bottom: 1px solid #eee;
        display: inline-block;
        padding: 10px 0;
        width: 49%;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						角色权限
					</div>
				</div>
			</div>
		</div>
    </div>
    
	<div class="container mainwrap">
		<div class="row">
			<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addRolePermission">
                <i class="glyphicon glyphicon-edit"></i> 新增角色权限
            </button>
		</div>
        
		<div class="row">
			<table class="table table-bordered table-striped">
				<thead>
					<tr class="gblack">
						<th>角色名称</th>
						<th>权限默认名</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody id="process" border="1">
					@foreach($roles as $role)
					<tr>
						<td>{{ $role->display_name }}</td>
						<td>
							@foreach ($role->perms as $permission)
                                <p class="form-text per" value="{{$permission->id}}">{{ $permission->display_name }}</p>
                            @endforeach
						</td>
						<td>
							<a href="javascript:void(0);" onclick="editRolePermission({{$role->id}})" data-toggle="modal" data-target="#updateRolePermission" class="btn btn-default btn-sm" value="{{$role->id}}">编辑</a>
							<a href="{{url('/rolePermission/destroy')}}?id={{$role->id}}" class="btn btn-default btn-sm">删除</a>

						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
        
		{{--新增角色--}}
		<div class="modal fade" id="addRolePermission" tabindex="-1" role="dialog" aria-labelledby="addRolePermissionLabel">
			<div class="modal-dialog " style="width:800px;" role="document">
				<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel">新增角色权限</h4>
					</div>
					<div class="modal-body">
						<form id="addRolePermission" class="form-horizontal" role="form" method="POST" action="{{ url('/rolePermission/store') }}">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

							<div class="form-group">
								<label for="display_name" class="col-sm-1 control-label">角色</label>
								<div class="col-sm-11">
									<select class="selectpicker" id="role_id" name="role_id">
										@foreach($roles as $role)
											<option value="{{ $role->id }}">{{ $role->display_name }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="display_name" class="col-sm-1 control-label p-0 lh-34 m-56">分配权限</label>
								<div class="col-sm-11" >
									<ul class="list-group permission-list">
                                        @foreach ($permissions as $permission)
										<li class="item">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="{{$permission->id}}"> {{ $permission->display_name }}
                                                </label>
                                            </div>
                                        </li>
										@endforeach
                                    </ul>
								</div>
							</div>

							<div class="form-group mb-0">
								<div class="modal-footer pb-r">
									<button type="submit" class="btn btn-magenta">确认保存</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
								</div>
							</div>
						</form>
		            </div>
		        </div>
		    </div>
		</div>

		{{--编辑角色--}}
		<div class="modal fade" id="updateRolePermission" tabindex="-1" role="dialog" aria-labelledby="updateRolePermissionLabel">
			<div class="modal-dialog " role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel">编辑角色权限</h4>
					</div>
					<div class="modal-body">
						<form id="updateRolePermission" class="form-horizontal" role="form" method="POST" action="{{ url('/rolePermission/store') }}">
							<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="update-container">
    							
                            </div>
							<div class="form-group mb-0">
								<div class="modal-footer pb-r">
									<button type="submit" class="btn btn-magenta">确认保存</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    @include('mustache.role_permissions')
    
@endsection
@section('customize_js')
    @parent
    var _token = $("#_token").val();
    
	$('#addrole').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: '名称不能为空！'
                    }
                }
            },
			display_name: {
                validators: {
                    notEmpty: {
                        message: '默认名不能为空！'
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
    });

	function editRolePermission(id) {
		$.get('/rolePermission/edit', {id:id}, function(e) {
            var template = $('#role-permission-form').html();
            var views = Mustache.render(template, e.data);
            $('.update-container').html(views);
            
            $('#updateRolePermission').modal('show');
            
		},'json');
	}

@endsection