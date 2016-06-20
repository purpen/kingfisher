@extends('home.base')

@section('title', 'console')

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						用户
					</div>
				</div>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row">
				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#adduser">新增用户</button>
			</div>
			<div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">新增用户</h4>
						</div>
						<div class="modal-body">
							<form id="addusername"  method="POST" action="{{ url('/user/store') }}">
								{!! csrf_field() !!}
								<input type="hidden" name="id" value="" >
								<div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">帐号：</div>
									</div>
									<div class="col-md-8">
										<input type="text" name="account" ordertype="discountFee" class="form-control float" id="orderFee" placeholder="帐号">
									</div>
								</div>
								<div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">手机号：</div>
									</div>
									<div class="col-md-8">
										<input type="text" name="phone" ordertype="discountFee" class="form-control float" id="orderFee" placeholder="手机号码">
									</div>
								</div>
                                <div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">角色：</div>
									</div>
									<div class="col-md-8">
										<div class="form-control ptb-3r" style="height:100%;">
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
										</div>
									</div>
								</div>
								{{--
								<div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">备注：</div>
									</div>
									<div class="col-md-8">
										<input type="text" name="remark" ordertype="discountFee" class="form-control float" id="orderFee" placeholder=" ">
									</div>
								</div>
								--}}
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
									<button id="submit_supplier" type="button" class="btn btn-magenta">确定</button>
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
							<th>用户名ID</th>
							<th>帐号</th>
							<th>手机号</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $val)
							<tr>
								<td>{{ $val->id }}</td>
								<td class="magenta-color">{{ $val->account }}</td>
								<td>{{ $val->phone }}</td>
								<td>{{ $val->status_val }}</td>
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
            phone: {
                validators: {
                    notEmpty: {
                        message: '手机号不能为空！'
                    }
                }
            }
        }
    });

@endsection