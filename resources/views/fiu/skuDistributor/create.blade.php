@extends('fiu.base')

@section('title', '添加SKU分销')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
	.m-92{
		min-width:92px;
		text-align:right;
		vertical-align: top !important;
    	line-height: 34px;
	}
	#picForm .form-control {
		top: 0;
	    left: 0;
	    position: absolute;
	    opacity: 0;
	    width: 100px;
	    height: 100px;
	    z-index: 3;
	    cursor: pointer;
	}
	#appendsku {
		margin-left:40px;
		font-size:14px;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					新增绑定SKU
				</div>
			</div>
		</div>
	</div>
	@if (session('error_message'))
		<div class="alert alert-success error_message">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p class="text-danger">{{ session('error_message') }}</p>
		</div>
	@endif
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/fiu/saas/skuDistributor/store') }}">
						{!! csrf_field() !!}
						<h5>绑定SKU信息<h5>
                        <hr>
                        <div class="form-group">
							<label for="sku_number" class="col-sm-2 control-label">选择sku：</label>
							<div class="col-sm-4">
								<select class="chosen-select" name="sku_number" style="display: none;">
									<option value="0">请选择</option>
									@foreach($productSkus as $productSku)
										<option value="{{ $productSku->number }}">{{$productSku->product ? $productSku->product->title : ''}}--{{ $productSku->mode}}</option>
									@endforeach
								</select>
							</div>
                        </div>
						<div class="form-group">
							<label for="display_name" class="col-sm-2 control-label">分销商：</label>
							<div class="col-sm-4">
								<select class="chosen-select" id="distributor_id" name="distributor_id">
									<option value="0">请选择</option>
									@foreach($users as $user)
										<option value="{{ $user->id }}">{{ $user->distribution ? $user->distribution->name : $user->realname.'--'.$user->phone}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="distributor_number" class="col-sm-2 control-label">分销编号：</label>
							<div class="col-sm-4">
								<input type="text" name="distributor_number" class="form-control float" id="distributor_number" placeholder="分销编号">
							</div>
						</div>
						<hr>
						<div class="form-group">
                            <div class="col-sm-12">
                				<button type="submit" class="btn btn-magenta btn-lg save">确认保存</button>
                				<button type="button" class="btn btn-white cancel btn-lg once" onclick="history.back()">取消</button>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div>
	</div>
	<input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
	var _token = $('#_token').val();

    $("#add-material").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
            fields: {
				describe: {
                    validators: {
                    notEmpty: {
                        message: '文字段不能为空！'
                    },
					stringLength: {
						max: 500,
						message:'最多为500个字符'
					}
                }
            }

        }
    });

	/*搜索下拉框*/
	$(".chosen-select").chosen({
		no_results_text: "未找到：",
		search_contains: true,
		width: "100%",
	});

@endsection