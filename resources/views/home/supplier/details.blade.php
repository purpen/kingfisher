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
                            <h5>公司信息</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="name" class="mb-0r control-label col-md-6"><b>公司全称:</b>{{ $supplier->name }}</li>
                                <li for="nam" class="mb-0r control-label col-md-6"><b>简称:</b>{{ $supplier->nam }}</li>
                                <li for="address" class="mb-0r control-label col-md-6"><b>地址:</b>{{ $supplier->address }}</li>
                                <li for="legal_person" class="mb-0r control-label col-md-6"><b>法人:</b>{{ $supplier->legal_person }}</li>
                                <li for="ein" class="mb-0r control-label col-md-6"><b>税号:</b>{{ $supplier->ein }}</li>
                                <li for="tax_rate" class="mb-0r control-label col-md-6"><b>开票税率:</b>{{ $supplier->tax_rate }}</li>
                                <li for="bank_number" class="mb-0r control-label col-md-6"><b>开户行号:</b>{{ $supplier->bank_number }}</li>
                                <li for="bank_address" class="mb-0r control-label col-md-6"><b>开户行地址:</b>{{ $supplier->bank_address }}</li>
                                <li for="start_time" class="mb-0r control-label col-md-6"><b>合作开始时间:</b>{{ $supplier->start_time == '0000-00-00' ? '' : $supplier->start_time }}</li>
                                <li for="end_time" class="mb-0r control-label col-md-6"><b>合作结束时间:</b>{{ $supplier->end_time == '0000-00-00' ? '' : $supplier->end_time }}</li>
                                <li for="authorization_deadline" class="mb-0r control-label col-md-6"><b>授权期限:</b>{{ $supplier->authorization_deadline == '0000-00-00' ? '' : $supplier->authorization_deadline }}</li>


                            </ul>
                            <h5>联系人信息</h5>
                            <hr>

                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="contact_user" class="mb-0r control-label col-md-6"><b>联系人:</b>{{ $supplier->contact_user }}</li>
                                <li for="contact_number" class="mb-0r control-label col-md-6"><b>联系人手机:</b>{{ $supplier->contact_number }}</li>
                                <li for="contact_email" class="mb-0r control-label col-md-6"><b>联系邮箱:</b>{{ $supplier->contact_email }}</li>
                                <li for="contact_wx" class="mb-0r control-label col-md-6"><b>联系人微信:</b>{{ $supplier->contact_wx }}</li>
                                <li for="contact_qq" class="mb-0r control-label col-md-6"><b>联系人QQ:</b>{{ $supplier->contact_qq }}</li>
                                <li for="tel" class="mb-0r control-label col-md-6"><b>联系人电话:</b>{{ $supplier->tel }}</li>
                            </ul>

                            <h5>图片信息</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="cover_id" class="mb-0r control-label col-md-6"><b>pdf附件(电子版合同):</b>
                                    @if($supplier->first_asset)
                                        <a href="{{ $supplier->first_asset}}" target="_blank">{{$supplier->assets->file->name}}</a>
                                    @endif
                                </li>
                                <li for="trademark_id" class="mb-0r control-label col-md-6"><b>商标:</b>
                                    @if($supplier->first_trademark)
                                        <a href="{{$supplier->first_trademark}}" target="_blank">{{$supplier->assetsTrademark->file->name}}</a>
                                    @endif
                                </li>

                                <li for="power_of_attorney_id" class="mb-0r control-label col-md-6"><b>授权书:</b>
                                    @if($supplier->first_power_of_attorney)
                                        <a href="{{$supplier->first_power_of_attorney}}" target="_blank">{{$supplier->assetsPowerOfAttorney->file->name}}</a>
                                    @endif
                                </li>

                                <li for="quality_inspection_report_id" class="mb-0r control-label col-md-6"><b>质检报告:</b>
                                    @if($supplier->first_quality_inspection_report)
                                        <a href="{{$supplier->first_quality_inspection_report}}" target="_blank">{{$supplier->assetsQualityInspectionReport->file->name}}</a>
                                    @endif
                                </li>

                                {{--<li for="electronic_contract_report_id" class="mb-0r control-label col-md-6"><b>电子版合同:</b>--}}
                                    {{--@if($supplier->first_electronic_contract_report)--}}
                                        {{--<a href="{{$supplier->first_electronic_contract_report}}" target="_blank">{{$supplier->assetsElectronicContractReport->file->name}}</a>--}}
                                    {{--@endif--}}
                                {{--</li>--}}

                            </ul>

                            <h5>审核状态</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="status" class="mb-0r control-label col-md-6"><b>状态:</b>
                                @if($supplier->status == 1)
                                    <td>待审核</td>
                                @elseif($supplier->status == 2)
                                    <td>已审核</td>
                                @elseif($supplier->status == 3)
                                    <td>未通过</td>

                                @elseif($supplier->status == 4)
                                    <td>重新审核</td>

                                @endif
                                </li>
                                <li for="msg" class="mb-0r control-label col-md-6"><b>原因:</b>{{ $supplier->msg}}</li>

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