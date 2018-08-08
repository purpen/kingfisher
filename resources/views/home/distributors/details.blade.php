@extends('home.base')

@section('title', '经销商详情')
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
                    经销商详情
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
                            <h5>门店信息</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="store_name" class="mb-0r control-label col-md-6"><b>门店名称:</b>{{ $distributors->store_name }}</li>
                                <li for="province_id" class="mb-0r control-label col-md-6"><b>门店所在省:</b>{{ $distributors->province }}</li>
                                <li for="category_id" class="mb-0r control-label col-md-6"><b>商品分类:</b>{{ $distributors->category }}</li>
                                <li for="authorization_id" class="mb-0r control-label col-md-6"><b>授权条件:</b>{{ $distributors->authorization }}</li>
                                <li for="store_address" class="mb-0r control-label col-md-6"><b>门店地址:</b>{{ $distributors->store_address }}</li>
                                <li for="operation_situation" class="mb-0r control-label col-md-6"><b>经营情况:</b>{{ $distributors->operation_situation }}</li>
                                <li for="business_license_number" class="mb-0r control-label col-md-6"><b>营业执照号:</b>{{ $distributors->business_license_number }}</li>
                            </ul>
                            <h5>经销商信息</h5>
                            <hr>

                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="name" class="mb-0r control-label col-md-6"><b>姓名:</b>{{ $distributors->name }}</li>
                                <li for="phone" class="mb-0r control-label col-md-6"><b>手机号:</b>{{ $distributors->phone }}</li>
                                <li for="bank_number" class="mb-0r control-label col-md-6"><b>银行账号:</b>{{ $distributors->bank_number }}</li>
                                <li for="bank_name" class="mb-0r control-label col-md-6"><b>开户行:</b>{{ $distributors->bank_name }}</li>
                                <li for="taxpayer" class="mb-0r control-label col-md-6"><b>纳税人类型:</b>    @if($distributors->taxpayer == 1)
                                        <td>一般纳税人</td>
                                    @elseif($distributors->taxpayer == 2)
                                                   <td>小规模纳税人</td>
                                    @endif</li>
                            </ul>

                            <h5>图片信息</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="front_id" class="mb-0r control-label col-md-6"><b>门店正面照片:</b>
                                    @if($distributors->first_front)
                                        <a href="{{ $distributors->first_front}}" target="_blank">{{$distributors->assetsFront->name}}</a>
                                    @endif
                                </li>
                                <li for="Inside_id" class="mb-0r control-label col-md-6"><b>门店内部照片:</b>
                                    @if($distributors->first_inside)
                                        <a href="{{$distributors->first_inside}}" target="_blank">{{$distributors->assetsInside->name}}</a>
                                    @endif
                                </li>

                                <li for="portrait_id" class="mb-0r control-label col-md-6"><b>身份证人像面照片:</b>
                                    @if($distributors->first_portrait)
                                        <a href="{{$distributors->first_portrait}}" target="_blank">{{$distributors->assetsPortrait->name}}</a>
                                    @endif
                                </li>

                                <li for="national_emblem_id" class="mb-0r control-label col-md-6"><b>身份证国徽面照片:</b>
                                    @if($distributors->First_national_emblem)
                                        <a href="{{$distributors->First_national_emblem}}" target="_blank">{{$distributors->assetsNationalEmblem->name}}</a>
                                    @endif
                                </li>

                                <li for="license_id" class="mb-0r control-label col-md-6"><b>营业执照照片:</b>
                                    @if($distributors->first_license)
                                        {{--<img src="{{ $distributors->assets->small }}" style="width: 150px;" class="img-thumbnail">--}}
                                        <a href="{{$distributors->first_license}}" target="_blank">{{$distributors->assets->name}}</a>
                                    @endif
                                </li>

                            </ul>

                            <h5>审核状态</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="status" class="mb-0r control-label col-md-6"><b>状态:</b>
                                @if($distributors->status == 1)
                                    <td>待审核</td>
                                @elseif($distributors->status == 2)
                                    <td>已审核</td>
                                @elseif($distributors->status == 3)
                                    <td>未通过</td>

                                @elseif($distributors->status == 4)
                                    <td>重新审核</td>

                                @endif
                                </li>
                                {{--<li for="msg" class="mb-0r control-label col-md-6"><b>原因:</b>{{ $supplier->msg}}</li>--}}

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