@extends('home.base')

@section('title', 'console')
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
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						用户
					</div>
				</div>
				<div id="warning" class="alert alert-danger" role="alert" style="display: none">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="showtext"></strong>
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
							<form id="addusername" role="form" class="form-horizontal" method="post" action="{{ url('/user/store') }}">
								{!! csrf_field() !!}
								<input type="hidden" name="id" value="" >
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
                                	<label class="col-sm-2 control-label p-0 lh-34 m-56">角色：</label>
									<div class="col-sm-8">
										<div class="form-control ptb-3r" style="height:100%;">
											@foreach ($data->role as $key => $value)
											<label class="checkbox-inline check-btn">
												<input type="checkbox" name="roles[]" value="{{ $value->id }}" key="{{ $key }}">
												<button type="button" class="btn btn-magenta mtb-r btn-sm">
													{{ $value->display_name }}
												</button>
											</label>
											@endforeach
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
									<a href="#" data-toggle="modal" data-target="#adduser" class="magenta-color mr-r">修改</a>
									<a href="#" class="magenta-color">删除</a>
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
                    },
					regexp: {
						regexp: /^1[34578][0-9]{9}$/,
						message: '手机号码不合法！'
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

@endsection