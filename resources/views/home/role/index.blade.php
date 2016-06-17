@extends('home.base')

@section('title', 'console')

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						角色
					</div>
				</div>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row">
				<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addrole">新增角色</button>
			</div>
			<div class="modal fade" id="addrole" tabindex="-1" role="dialog" aria-labelledby="addroleLabel">
				<div class="modal-dialog modal-zm" role="document">
					<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="gridSystemModalLabel">新增角色</h4>
						</div>
						<div class="modal-body">
							<form id="addrole">
								<div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">名称：</div>
									</div>
									<div class="col-md-8">
										<input type="text" name="rname" ordertype="discountFee" class="form-control float" id="orderFee" placeholder=" ">
									</div>
								</div>
								<div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">默认名：</div>
									</div>
									<div class="col-md-8">
										<input type="text" name="default_name" ordertype="discountFee" class="form-control float" id="orderFee" placeholder=" ">
									</div>
								</div>
								<div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">描述：</div>
									</div>
									<div class="col-md-8">
										<textarea name="des" class="form-control" rows="4"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2 lh-34">
										<div class="m-56">权限：</div>
									</div>
									<div class="col-md-8">
										<div class="form-control ptb-3r" style="height:100%;">
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
											<button type="button" class="btn btn-magenta mtb-r btn-sm">
												客服
											</button>
										</div>
									</div>
								</div>
							</form>
							
			            </div>
			            <div class="modal-footer">
                    		<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    		<button id="submit_supplier" type="button" class="btn btn-magenta">确定</button>
                		</div>
			        </div>
			    </div>
			</div>
			
			<div class="row">
				<table class="table table-bordered table-striped">
					<thead>
						<tr class="gblack">
							<th>角色ID</th>
							<th>名称</th>
							<th>默认名</th>
							<th>描述</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>李三</td>
							<td class="magenta-color">12388888888</td>
							<td>12388888888</td>
							<td>12388888888</td>
							<td>在线</td>
							<td>
								<a href="javascript:void(0);" class="magenta-color mr-r">修改</a>
								<a href="javascript:void(0);" class="magenta-color">删除</a>
							</td>
						</tr>
						<tr>
							<td>李三</td>
							<td class="magenta-color">12388888888</td>
							<td>12388888888</td>
							<td>12388888888</td>
							<td>在线</td>
							<td>
								<a href="javascript:void(0);" class="magenta-color mr-r">修改</a>
								<a href="javascript:void(0);" class="magenta-color">删除</a>
							</td>
						</tr>
						<tr>
							<td>李三</td>
							<td class="magenta-color">12388888888</td>
							<td>12388888888</td>
							<td>12388888888</td>
							<td>在线</td>
							<td>
								<a href="javascript:void(0);" class="magenta-color mr-r">修改</a>
								<a href="javascript:void(0);" class="magenta-color">删除</a>
							</td>
						</tr>
					</tbody>
				</table>
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
			default_name: {
                validators: {
                    notEmpty: {
                        message: '默认名不能为空！'
                    }
                }
            },
            des: {
                validators: {
                    notEmpty: {
                        message: '描述不能为空！'
                    }
                }
            }
        }
    });

@endsection