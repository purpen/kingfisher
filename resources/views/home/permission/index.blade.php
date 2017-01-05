@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					权限管理
				</div>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-12">
				    <button type="button" class="btn btn-white" data-toggle="modal" data-target="#addPermission"><i class="glyphicon glyphicon-edit"></i> 新增权限</button>
                </div>
			</div>

			<div class="row">
                <div class="col-md-12">
    				<table class="table table-bordered table-striped">
    					<thead>
    						<tr class="gblack">
    							<th>权限ID</th>
    							<th>名称</th>
    							<th>默认名</th>
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
    									<button data-toggle="modal" data-target="#updatePermission" class="btn btn-default btn-sm" onclick="editPermission({{ $val->id }})"  value="{{ $val->id }}">修改</button>
    									<button class="btn btn-default btn-sm" onclick=" destroyPermission({{ $val->id }})" value="{{ $val->id }}">删除</button>
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
						{!! $data->render() !!}
					</div>
				@endif
			</div>
		</div>
    </div>
@include('modal.add_update_permission')

@endsection

@section('customize_js')
    @parent
	function editPermission(id) {
		$.get('/permission/ajaxEdit',{'id':id},function (e) {
			if (e.status == 1){
				$("#permission_id").val(e.data.id);
				$("#name1").val(e.data.name);
				$("#display_name1").val(e.data.display_name);
				$("#description1").val(e.data.description);
				$('#updateRole').modal('show');
			}
		},'json');
	}

	var _token = $("#_token").val();
	function destroyPermission (id) {
		if(confirm('确认删除该权限吗？')){
			$.post('/permission/destroy',{"_token":_token,"id":id},function (e) {
				if(e.status == 1){
					location.reload();
				}else{
					alert(e.message);
				}
			},'json');
		}

	}
@endsection