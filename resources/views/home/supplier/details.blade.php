@extends('home.base')

@section('title', '供应商详情')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
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
	.qq-upload-button {
		width: 100px;
		height: 100px;
		position: absolute !important;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
                    供应商详情
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                        <div class="row mb-2r" id="update-product-img">

                            <div class="col-md-2 mb-3r" style="display: none">
                                <div style="width: 70px;height: 5px;background: lightblue;">
                                    <div id="progress_bar" style="width: 0px;height: 5px;background: blue;"></div>
                                </div>
                            </div>
            					<div class="asset col-md-12">
                                    <ul class="form-group" style="list-style-type:none">
                                        <li for="name" class="mb-0r control-label"><b>公司全称:</b>{{ $supplier->name }}</li></br>
                                        <li for="nam" class="mb-0r control-label"><b>品牌:</b>{{ $supplier->nam }}</li></br>
                                        <li for="address" class="mb-0r control-label"><b>地址:</b>{{ $supplier->address }}</li></br>
                                        <li for="legal_person" class="mb-0r control-label"><b>法人:</b>{{ $supplier->legal_person }}</li></br>
                                        <li for="tel" class="mb-0r control-label"><b>联系人电话:</b>{{ $supplier->tel }}</li></br>
                                        <li for="ein" class="mb-0r control-label"><b>税号:</b>{{ $supplier->ein }}</li></br>
                                        <li for="bank_number" class="mb-0r control-label"><b>开户行号:</b>{{ $supplier->bank_number }}</li></br>
                                        <li for="bank_address" class="mb-0r control-label"><b>开户行地址:</b>{{ $supplier->bank_address }}</li></br>
                                        <li for="contact_user" class="mb-0r control-label"><b>联系人:</b>{{ $supplier->contact_user }}</li></br>
                                        <li for="contact_number" class="mb-0r control-label"><b>联系人手机:</b>{{ $supplier->contact_number }}</li></br>
                                        <li for="contact_email" class="mb-0r control-label"><b>联系邮箱:</b>{{ $supplier->contact_email }}</li></br>
                                        <li for="contact_qq" class="mb-0r control-label"><b>联系人QQ:</b>{{ $supplier->contact_qq }}</li></br>
                                        <li for="contact_wx" class="mb-0r control-label"><b>联系人微信:</b>{{ $supplier->contact_wx }}</li></br>
                                        <li for="start_time" class="mb-0r control-label"><b>合作开始时间:</b>{{ $supplier->start_time }}</li></br>
                                        <li for="end_time" class="mb-0r control-label"><b>合作结束时间:</b>{{ $supplier->end_time }}</li></br>
                                        <li for="tax_rate" class="mb-0r control-label"><b>开票税率:</b>{{ $supplier->tax_rate }}</li></br>
                                        <li for="cover_id" class="mb-0r control-label"><b>pdf附件:</b><a href="{{ $supplier->assets ? $supplier->assets->file->srcfile.'.'.$mime : ''}}" @if($supplier->assets) download="下载" @endif>下载</a></li></br>
                                    </ul>
            					</div>

                        </div>
                </div>
            </div>
        </div>

	</div>
@endsection

@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
@endsection
