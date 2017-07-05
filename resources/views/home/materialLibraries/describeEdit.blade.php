@extends('home.base')

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
					新增图片
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/describe/update') }}">
						{!! csrf_field() !!}
						<input type="hidden" id="materialLibrary_id" name="materialLibrary_id" value="{{ $materialLibrary->id }}">
						<h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
                            <label for="product_number" class="col-sm-1 control-label {{ $errors->has('product_number') ? ' has-error' : '' }}">*商品编号</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="product_number" value="{{$product_number}}" readonly>
                              @if ($errors->has('product_number'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('product_number') }}</strong>
                                  </span>
                              @endif
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
                product_number: {
                    validators: {
                    notEmpty: {
                        message: '商品编号不能为空！'
                    }
                }
            }

        }
    });


@endsection