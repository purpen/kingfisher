@extends('home.base')

@section('title', 'console')

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						权限
					</div>
				</div>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row">
				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addrole">新增权限</button>
			</div>
			<div class="modal fade" id="addrole" tabindex="-1" role="dialog" aria-labelledby="addroleLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">新增权限</h4>
						</div>
						<div class="modal-body">
							<form id="addpermission" class="form-horizontal" role="form" method="POST" action="{{ url('/permission/store') }}">
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
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
									<button type="submit" class="btn btn-magenta">确定</button>
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
									<a href="javascript:void(0);" data-toggle="modal" data-target="#adduser" class="magenta-color mr-r">修改</a>
									<a href="javascript:void(0);" class="magenta-color">删除</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
    
@endsection
@section('customize_js')
    @parent
	$('#addpermission').formValidation({
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

@endsection