@extends('home.base')

@section('title', '商品详情')
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
                    商品详情
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
                                    <div class="form-group">
                                        @if(!$assets->isEmpty())
                                            @foreach($assets as $asset)
                                                <div class="form-group col-sm-6">
                                                    <img src="{{$asset->file->small}}" class="img-thumbnail">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="form-group col-sm-6">
                                                <img src="{{url('/images/default/erp_product1.png')}}" class="img-thumbnail">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                    <hr>
                                    @if(isset($product->productsSku))
                                        <h5>sku列表</h5>
                                        <hr>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr class="gblack">
                                                        <th>序号</th>
                                                        <th>图片</th>
                                                        <th>SKU编码</th>
                                                        <th>标准进价</th>
                                                        <th>成本价</th>
                                                        <th>售价</th>
                                                        <th>颜色/型号</th>
                                                        <th>重量（kg）</th>
                                                        <th>自定义库存</th>
                                                        <th>备注</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($product->productsSku as $sku)
                                                        <tr class=".tr">
                                                            <td>{{ $sku->id }}</td>
                                                            <td>
                                                                <img src="{{$sku->first_img}}" class="img-thumbnail" style="width: 80px;">
                                                            </td>
                                                            <td>
                                                                {{ $sku->number }}
                                                            </td>
                                                            <td>
                                                                {{$sku->bid_price}}
                                                            </td>
                                                            <td>
                                                                {{$sku->cost_price}}
                                                            </td>
                                                            <td>
                                                                {{ $sku->price }}
                                                            </td>
                                                            <td>
                                                                {{ $sku->mode }}
                                                            </td>
                                                            <td>
                                                                {{ $sku->weight }}
                                                            </td>
                                                            <td>
                                                                {{ $sku->zc_quantity }}
                                                            </td>
                                                            <td>
                                                                {{ $sku->summary }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                 <div class="asset col-md-12">
                                    <ul class="form-group" style="list-style-type:none">
                                        <li for="number" class="mb-0r control-label"><b>编号:</b>{{ $product->number }}</li></br>
                                        <li for="title" class="mb-0r control-label"><b>商品名称:</b>{{ $product->title }}</li></br>
                                        <li for="tit" class="mb-0r control-label"><b>商品简称:</b>{{ $product->tit }}</li></br>
                                        <li for="category" class="mb-0r control-label"><b>商品分类:</b>{{ $product->CategoriesModel ? $product->CategoriesModel->title :'' }}</li></br>
                                        {{--<li for="supplier" class="mb-0r control-label"><b>供应商:</b>{{ $product->supplier ? $product->supplier->name :'' }}</li></br>--}}
                                        {{--@if($product->product_type == 1)--}}
                                        {{--<li for="product_type" class="mb-0r control-label"><b>商品类别:</b>京东众筹</li></br>--}}
                                        {{--@endif--}}
                                        {{--@if($product->product_type == 2)--}}
                                            {{--<li for="product_type" class="mb-0r control-label"><b>商品类别:</b>淘宝</li></br>--}}
                                        {{--@endif--}}
                                        {{--@if($product->product_type == 3)--}}
                                            {{--<li for="product_type" class="mb-0r control-label"><b>商品类别:</b>太火鸟自营</li></br>--}}
                                        {{--@endif--}}
                                        <li for="weight" class="mb-0r control-label"><b>重量:</b>{{ $product->weight }}</li></br>
                                        <li for="cost_price" class="mb-0r control-label"><b>成本价:</b>{{ $product->cost_price }}</li></br>
                                        <li for="market_price" class="mb-0r control-label"><b>市场售价:</b>{{ $product->market_price }}</li></br>
                                        <li for="sale_price" class="mb-0r control-label"><b>建议售价:</b>{{ $product->sale_price }}</li></br>
                                        <li for="summary" class="mb-0r control-label"><b>备注说明:</b>{{ $product->summary }}</li>
                                    </ul>
            					</div>
                                {{--<label for="content" class="col-sm-2 control-label {{ $errors->has('content') ? ' has-error' : '' }}">商品展示</label>--}}
                                {{--<br>--}}
                                {{--<div class="col-sm-12">--}}
                                    {{--<textarea id="container" style="height:300px;width:100%;" name="content">{{$product->product_details}}</textarea>--}}
                                    {{--<script id="container" name="content" type="text/plain" readonly>--}}


                                  {{--</script>--}}
                                {{--</div>--}}

                                <div class="form-group">
                                    <h5>商品详情介绍图片</h5>
                                    @if(!$assetsProductDetails->isEmpty())
                                        @foreach($assetsProductDetails as $v)
                                            <div class="form-group col-sm-6">
                                                <img src="{{$v->file->p800}}" class="img-bignail" style="text-align: center">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="form-group col-sm-6">
                                            <img src="{{url('/images/default/erp_product1.png')}}" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>

                        </div>
                    


                </div>
            </div>
        </div>

	</div>
@endsection
{{--@include('UEditor::head');--}}
@section('partial_js')
	@parent
	{{--<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>--}}
    {{--<script>--}}
        {{--var ue = UE.getEditor('container');--}}
        {{--ue.ready(function() {--}}
{{--//            不可被编辑--}}
            {{--ue.setDisabled();--}}
        {{--});--}}
    {{--</script>--}}

@endsection
