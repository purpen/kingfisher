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
		<div class="container mainwrap">
			<div class="row">
				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addRolePermission">新增角色权限</button>
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
									<label for="display_name" class="col-sm-1 control-label p-0 lh-34 m-56">角色</label>
									<div class="col-sm-11">
										<select class="selectpicker" id="role_id" name="role_id" style="display: none;">
											<option value="">选择角色</option>
											@foreach($role as $r)
												<option value="{{$r->id}}">{{$r->display_name}}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="display_name" class="col-sm-1 control-label p-0 lh-34 m-56">权限</label>
									<div class="col-sm-11" >
										<table>
											@foreach($permission as $p)
											<tr>
												<td rowspan=2>
													<input type="checkbox" name="permission[]" value="{{$p->id}}">
													<label>{{$p->display_name}}</label>
												</td>

											</tr>
											@endforeach
										</table>
									</div>
								</div>

								<div class="form-group mb-0">
									<div class="modal-footer pb-r">
										<button type="submit" class="btn btn-magenta">确定</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
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
							<th>角色名称</th>
							<th>权限默认名</th>
							<th>权限描述</th>
						</tr>
					</thead>
					<tbody id="process" border="1">
							@foreach($per_role as $pr)
							<tr>
								<td>{{$pr->role->display_name}}</td>
								<td>{{$pr->permission->display_name}}</td>
								<td>{{$pr->permission->description}}</td>
							</tr>
							@endforeach
					</tbody>
				</table>
				@if($per_role->render() !== "")
					<div class="col-md-6 col-md-offset-5">
						{!! $per_role->render() !!}
					</div>
				@endif
			</div>
		</div>
    </div>
@endsection
@section('customize_js')
    @parent
	{{--$("#e2").select2({--}}
		{{--minimumInputLength: 5--}}
	{{--});--}}

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

	var _token = $("#_token").val();
    $(".destroyRoleUser").click(function(){
        var roleId = $(this).attr('roleId');
        var userId = $(this).attr('value');
        if(confirm('确认删除该供货商吗？')){
            $.post('/roleUser/destroy',{"_token":_token,"userId":userId,"roleId":roleId},function (data) {
                var date_obj = data;
                if (date_obj.status == 1){
                    return false;
                }
            },'json');
        }
    })


@endsection