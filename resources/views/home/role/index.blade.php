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
									<button data-toggle="modal" data-target="#updateRole" class="btn btn-default btn-sm" onclick="editRole({{ $val->id }})" value="{{ $val->id }}">修改</button>
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
@include('modal.add_update_role')
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