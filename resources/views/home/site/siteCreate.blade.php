@extends('home.base')

@section('title', '站点')
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
					新增站点
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/saas/site/store') }}">
						{!! csrf_field() !!}
    					<h5>基本信息</h5>
                        <hr>
						<div class="form-group">
							<label for="site_type" class="col-sm-1 control-label">类型</label>
							<div class="col-sm-6">
								<div class="input-group">
									<select class="selectpicker" name="site_type" style="display: none;">
										<option value="1">公众号</option>
										<option value="2">众筹</option>
										<option value="3">普通销售</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-1 control-label">站点名称</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="name" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="mark" class="col-sm-1 control-label">站点标识</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="mark" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="url" class="col-sm-1 control-label">网址</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="url" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="remark" class="col-sm-1 control-label">备注</label>
							<div class="col-sm-6">
								<textarea  rows="10" cols="20" name="remark" class="form-control"></textarea>
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



@endsection