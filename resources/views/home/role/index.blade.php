@extends('home.base')

@section('title', '用户角色')
	
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
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						用户角色管理
					</div>
				</div>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row">
				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addroles">
                    <i class="glyphicon glyphicon-edit"></i> 新增角色
                </button>
			</div>
			{{--新增角色--}}
			<div class="modal fade" id="addroles" tabindex="-1" role="dialog" aria-labelledby="addrolesLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">新增角色</h4>
						</div>
						<div class="modal-body">
							<form id="addrole" class="form-horizontal" role="form" method="POST" action="{{ url('/role/store') }}">
								{!! csrf_field() !!}
								<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
									<label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">名称</label>
									<div class="col-sm-8">
										<input type="text" name="name" class="form-control float" id="name" placeholder="输入名称"  value="{{ old('name') }}">
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
									<label for="display_name" class="col-sm-2 control-label p-0 lh-34 m-56">默认名</label>
									<div class="col-sm-8">
										<input type="text" name="display_name" class="form-control float" id="display_name" placeholder="输入默认名称"  value="{{ old('display_name') }}">
										@if ($errors->has('display_name'))
											<span class="help-block">
												<strong>{{ $errors->first('display_name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group{{ $errors->has('des') ? ' has-error' : '' }}">
									<label for="des" class="col-sm-2 control-label p-0 lh-34 m-56">描述</label>
									<div class="col-sm-8">
										<input type="text" name="des" class="form-control float" id="des" placeholder="输入描述"  value="{{ old('des') }}">
										@if ($errors->has('des'))
											<span class="help-block">
												<strong>{{ $errors->first('des') }}</strong>
											</span>
										@endif
									</div>
								</div>
								{{--<div class="form-group">--}}
                                	{{--<label class="col-sm-2 control-label p-0 lh-34 m-56">权限：</label>--}}
									{{--<div class="col-sm-8">--}}
										{{--<div class="form-control ptb-3r" style="height:100%;">--}}
											{{--@foreach ($data->permission as $key => $value)--}}
											{{--<label class="checkbox-inline check-btn">--}}
												{{--<input type="checkbox" name="permissions[]" value="{{ $value->id }}" key="{{ $key }}">--}}
												{{--<button type="button" class="btn btn-magenta mtb-r btn-sm">--}}
													{{--{{ $value->display_name }}--}}
												{{--</button>--}}
											{{--</label>--}}
											{{--@endforeach--}}
										{{--</div>--}}
									{{--</div>--}}
								{{--</div>--}}
								<div class="form-group mb-0">
									<div class="modal-footer pb-r">
										<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
										<button type="submit" class="btn btn-magenta">确定</button>
									</div>
								</div>
							</form>
			            </div>
			        </div>
			    </div>
			</div>

			{{--修改角色--}}
			<div class="modal fade" id="updateRole" tabindex="-1" role="dialog" aria-labelledby="updateRoleLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">更改角色</h4>
						</div>
						<div class="modal-body">
							<form id="updateRole" class="form-horizontal" role="form" method="POST" action="{{ url('/role/update') }}">
								<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
								<input type="hidden" name="id" id="role_id" >
								<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
									<label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">名称</label>
									<div class="col-sm-8">
										<input type="text" name="name" class="form-control float" id="name1" placeholder="输入名称"  value="{{ old('name') }}">
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
									<label for="display_name" class="col-sm-2 control-label p-0 lh-34 m-56">默认名</label>
									<div class="col-sm-8">
										<input type="text" name="display_name" class="form-control float" id="display_name1" placeholder="输入默认名称"  value="{{ old('display_name') }}">
										@if ($errors->has('display_name'))
											<span class="help-block">
												<strong>{{ $errors->first('display_name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group{{ $errors->has('des') ? ' has-error' : '' }}">
									<label for="description" class="col-sm-2 control-label p-0 lh-34 m-56">描述</label>
									<div class="col-sm-8">
										<input type="text" name="description" class="form-control float" id="description1" placeholder="输入描述"  value="{{ old('description') }}">
										@if ($errors->has('description'))
											<span class="help-block">
												<strong>{{ $errors->first('description') }}</strong>
											</span>
										@endif
									</div>
								</div>
								{{--<div class="form-group">--}}
								{{--<label class="col-sm-2 control-label p-0 lh-34 m-56">权限：</label>--}}
								{{--<div class="col-sm-8">--}}
								{{--<div class="form-control ptb-3r" style="height:100%;">--}}
								{{--@foreach ($data->permission as $key => $value)--}}
								{{--<label class="checkbox-inline check-btn">--}}
								{{--<input type="checkbox" name="permissions[]" value="{{ $value->id }}" key="{{ $key }}">--}}
								{{--<button type="button" class="btn btn-magenta mtb-r btn-sm">--}}
								{{--{{ $value->display_name }}--}}
								{{--</button>--}}
								{{--</label>--}}
								{{--@endforeach--}}
								{{--</div>--}}
								{{--</div>--}}
								{{--</div>--}}
								<div class="form-group mb-0">
									<div class="modal-footer pb-r">
										<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
										<button type="submit" class="btn btn-magenta">确定</button>
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
							<th>角色ID</th>
							<th>标识</th>
							<th>显示名称</th>
							<th>描述</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $val)
							<tr>
								<td>{{ $val->id }}</td>
								<td class="magenta-color">{{ $val->name }}</td>
								<td>{{ $val->display_name }}</td>
								<td>{{ $val->description }}</td>
								<td>
									<button data-toggle="modal" data-target="#updateRole" class="btn btn-default btn-sm" onclick="editRole({{ $val->id }})" value="{{ $val->id }}">修改</a>
									<button class="btn btn-default btn-sm" onclick=" destroyRole({{ $val->id }})" value="{{ $val->id }}">删除</button>
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
    })

	function editRole (id) {
		$.get('/role/ajaxEdit',{'id':id},function (e) {
			if (e.status == 1){
				$("#role_id").val(e.data.id);
				$("#name1").val(e.data.name);
				$("#display_name1").val(e.data.display_name);
				$("#description1").val(e.data.description);
				$('#updateRole').modal('show');
			}
		},'json');
	}

	var _token = $("#_token").val();
	function destroyRole (id) {
		if(confirm('确认删除该角色吗？')){
			$.post('/role/destroy',{"_token":_token,"id":id},function (e) {
				if(e.status == 1){
					location.reload();
				}else{
					alert(e.message);
				}
			},'json');
		}

	}
@endsection