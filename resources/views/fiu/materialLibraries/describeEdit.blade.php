@extends('fiu.base')

@section('title', '商品文字段')
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
					编辑文字段
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/fiu/saas/describe/update') }}">
						{!! csrf_field() !!}
						<input type="hidden" id="materialLibrary_id" name="materialLibrary_id" value="{{ $materialLibrary->id }}">
						<h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
							<label for="product_title" class="col-sm-1 control-label">选择商品</label>
							<div class="col-sm-6">
								<div class="input-group">
									<select class="chosen-select" name="product_id" style="display: none;">
										<option value="">选择商品</option>
										@foreach($products as $product)
											<option value="{{$product->id}}"{{$product->number == $materialLibrary->product_number ? 'selected' : ''}}>{{$product->title}}</option>
										@endforeach
									</select>
								</div>
							</div>
                        </div>
						<div class="form-group">
							<label for="describe" class="col-sm-1 control-label">文字段</label>
							<div class="col-sm-6">
								<textarea  rows="10" cols="20" name="describe" class="form-control">{{$materialLibrary->describe}}</textarea>
							</div>
						</div>
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