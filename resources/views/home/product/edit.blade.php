@extends('home.base')

@section('title', '修改商品')
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

    .sty_cla li{
        float:left;
        width:50px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					编辑商品
				</div>
			</div>
            <div class="navbar-collapse collapse">
                @include('home.product.subnav')
            </div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <h3 style="color: #9c0033">{{ $error }}</h3>
                        @endforeach
                    @endif
            		<form id="add-product" role="form" method="post" class="form-horizontal" action="{{ url('/product/update') }}">
                        {{ csrf_field() }}{{--token--}}
            			<input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
            			<input type="hidden" name="url" value="{{ $url }}">
            
                        <h5>商品分类</h5>
                        <hr>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">选择商品分类</label>
                            <div class="col-sm-3">
                                <div class="input-group col-md-12">
                					<select class="selectpicker" name="category_id">
                                        <option value="0">默认分类</option>
                                         @foreach($lists as $list)
                                            @if($list['type'] == 1)
                						<option value="{{ $list->id }}" {{ $product->category_id == $list->id?'selected':'' }}>{{ $list->title }}</option>
                                            @endif
                                         @endforeach
                					</select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="authorization_id" class="col-sm-2 control-label {{ $errors->has('authorization_id') ? ' has-error' : '' }}">选择授权类型</label>
                            <div class="col-sm-3">
                                <div class="input-group col-md-12">
                                    <div class="col-sm-8" style="padding-top:5px">
                                        @foreach($lists as $list)
                                            @if($list['type'] == 2)
                                                <input type="checkbox" name="authorization_id[]" class="checkcla" value="{{ $list->id }}"  @if(in_array($list->id,$authorization)) checked="checked" @endif>{{ $list->title }}
                                            @endif
                                        @endforeach

                                    </div>
                                    <input type="hidden" name="Jszzdm" id="Jszzdm" value="@Model.Jszzdm" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="region_id" class="col-sm-2 control-label {{ $errors->has('region_id') ? ' has-error' : '' }}">选择地域分类</label>
                            <div class="col-sm-3">
                                <div class="input-group col-md-12">
                                    <div class="col-sm-8" style="width: 100%;margin-left: -15px">
                                        <select class="chosen-select" name="region_id">
                                            <option value="">请选择省份</option>
                                            @foreach($provinces as $v)
                                                <option value="{{ $v->id }}" {{ $v->id == $product->region_id?'selected':'' }}>{{ $v->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_id" class="col-sm-2 control-label {{ $errors->has('supplier_id') ? ' has-error' : '' }}">选择供应商</label>
                            <div class="col-sm-3">
                                <div class="input-group col-md-11">
                					<select class="chosen-select" name="supplier_id">
                                        <option value="">请选择供应商</option>
                                    @foreach($suppliers as $supplier)
                						<option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id?'selected':'' }}>{{ $supplier->name }}</option>
                						@endforeach
                					</select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{--<label for="supplier_id" class="col-sm-2 control-label">商品类别</label>--}}
                            {{--<div class="col-sm-3">--}}
                                {{--<div class="input-group">--}}
                                    {{--<select class="selectpicker" name="product_type" style="display: none;">--}}
                                        {{--<option value="">选择类别</option>--}}
                                        {{--<option value="1" {{ $product->product_type == 1 ? 'selected' : '' }}>众筹商品</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
            			<h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">编号</label>
                            <div class="col-sm-3">
                                <input type="text" name="number" ordertype="b2cCode" class="form-control" value="{{ $product->number }}" readonly>
                                @if ($errors->has('number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label {{ $errors->has('title') ? ' has-error' : '' }}">商品名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="title" ordertype="b2cCode" class="form-control" value="{{ $product->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label for="tit" class="col-sm-2 control-label {{ $errors->has('tit') ? ' has-error' : '' }}">商品简称</label>
                            <div class="col-sm-4">
                                <input type="text" name="tit" ordertype="b2cCode" class="form-control" value="{{ $product->tit }}">
                                @if ($errors->has('tit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label for="cost_price" class="col-sm-2 control-label {{ $errors->has('cost_price') ? ' has-error' : '' }}">成本价<small>(元)</small></label>
                            <div class="col-sm-2">
                                <input type="text" id="cost_price" name="cost_price" ordertype="b2cCode" class="form-control" value="{{ $product->cost_price }}">
                                @if ($errors->has('cost_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cost_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <label for="market_price" class="col-sm-1 control-label {{ $errors->has('market_price') ? ' has-error' : '' }}">市场售价<small>(元)</small></label>
                            <div class="col-sm-2">
                                <input type="text" id="market_price" name="market_price" ordertype="b2cCode" class="form-control" value="{{ $product->market_price }}">
                                @if ($errors->has('market_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('market_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                
                            <label for="sale_price" class="col-sm-1 control-label {{ $errors->has('sale_price') ? ' has-error' : '' }}">建议售价<small>(元)</small></label>
                            <div class="col-sm-2">
                                <input type="text" id="sale_price" name="sale_price" ordertype="b2cCode" class="form-control" value="{{ $product->sale_price }}">
                                @if ($errors->has('sale_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sale_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="weight" class="col-sm-2 control-label {{ $errors->has('weight') ? ' has-error' : '' }}">重量<small>(kg)</small></label>
                            <div class="col-sm-3">
                                <input type="text" name="weight" ordertype="b2cCode" class="form-control" value="{{ $product->weight }}">
                                @if ($errors->has('weight'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="summary" class="col-sm-2 control-label {{ $errors->has('summary') ? ' has-error' : '' }}">备注说明</label>
                            <div class="col-sm-9">
                                <input type="text" name="summary" class="form-control" value="{{ $product->summary }}">
                                @if ($errors->has('summary'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('summary') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

            			<h5>商品图片<small class="text-warning">［仅支持后缀(jpeg,jpg,png)格式图片，大小3MB以内］</small></h5>
                        <hr>

                        <div class="row mb-2r" id="update-product-img">
                            <div class="col-md-2">
                                <div id="picForm" enctype="multipart/form-data">
                                    <div class="img-add">
                                        <span class="glyphicon glyphicon-plus f46"></span>
                                        <p class="uptitle">添加图片</p>
                                        <div id="fine-uploader"></div>
                                    </div>
                                </div>
                                <input type="hidden" id="cover_id" name="cover_id" value="{{$product->cover_id}}">
                                <script type="text/template" id="qq-template">
                                    <div id="add-img" class="qq-uploader-selector qq-uploader">
                                        <div class="qq-upload-button-selector qq-upload-button">
                                            <div>上传图片</div>
                                        </div>
                                        <ul class="qq-upload-list-selector qq-upload-list">
                                            <li hidden></li>
                                        </ul>
                                    </div>
                                </script>
                            </div>
                            <div class="col-md-2 mb-3r" style="display: none">
                                <div style="width: 70px;height: 5px;background: lightblue;">
                                    <div id="progress_bar" style="width: 0px;height: 5px;background: blue;"></div>
                                </div>
                            </div>
            				@foreach($assets as $asset)
                            <div class="col-md-2">
            					<div class="asset">
            						<img src="{{ $asset->file->small }}" style="width: 150px;" class="img-thumbnail">
            						<a class="removeimg" value="{{ $asset->id }}"><i class="glyphicon glyphicon-remove"></i></a>
            					</div>
                            </div>
            				@endforeach
                        </div>
                    
            			<h5>SKU信息 <a id="appendsku" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>添加SKU</a></h5>
                        <hr>
                        @if(isset($product->productsSku))
                        <div class="form-group">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="gblack">
                                        <th>序号</th>
                                        <th>图片</th>
                                        <th>SKU编码</th>
                                        <th>成本价</th>
                                        <th>市场售价</th>
                                        <th>建议售价</th>
                                        <th>颜色/型号</th>
                                        <th>重量（kg）</th>
                                        <th>自定义库存</th>
                                        <th>备注</th>
                                        <th>操作</th>
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
                                            {{$sku->cost_price}}
                                        </td>
                                        <td>
                                            {{$sku->bid_price}}
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
                                        <td>
                                            <a class="btn btn-default" data-toggle="modal" onclick="editSku({{ $sku->id }})">修改</a>
                                        	<a class="btn btn-default" onclick="destroySku({{ $sku->id }})">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    
                        <div class="form-group">
                            <div class="col-sm-12">
                				<button type="submit" class="btn btn-magenta mr-r btn-lg save">确认更新</button>
                				<button type="button" class="btn btn-white cancel btn-lg once" onclick="window.history.back()">取消</button>
                            </div>
                        </div>
            		</form>
                </div>
            </div>
        </div>
        
		{{-- 添加SKU模板 --}}
        <div class="modal fade bs-example-modal-lg" id="appendskuModal" tabindex="-1" role="dialog"
         aria-labelledby="appendskuLabel" aria-hidden="true">
			<div class="modal-dialog">
		        <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
	                        &times;
	                    </button>
	                    <h4 class="modal-title" id="myModalLabel">
	                        添加SKU
	                    </h4>
	                </div>
		            <div class="modal-body">
	                	<form id="addsku" method="post" class="form-horizontal" action="{{ url('/productsSku/store') }}">
                            {{ csrf_field() }}{{--token--}}
                            <input type="hidden" name="random" id="create_sku_random" value="{{ $random[0] }}">{{--图片上传回调随机数--}}
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
							<input type="hidden" name="name" value="{{ $product->title }}">
							<input type="hidden" name="product_number" value="{{ $product->number }}">
                            
                            <div class="form-group">
                                <label for="number" class="col-sm-2 control-label">SKU编码</label>
                                <div class="col-sm-4">
                                    <input type="text" name="number" ordertype="b2cCode" class="form-control" id="add_number" readonly>
                                </div>
                                <label for="cost_price" class="col-sm-2 control-label">成本价</label>
                                <div class="col-sm-4">
                                    <input type="text" id="cost_price1" name="cost_price" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">建议售价</label>
                                <div class="col-sm-4">
                                    <input type="text" id="price" name="price" class="form-control">
                                </div>
                                <label for="bid_price" class="col-sm-2 control-label">市场售价</label>
                                <div class="col-sm-4">
                                    <input type="text" id="bid_price" name="bid_price" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mode" class="col-sm-2 control-label">颜色/型号</label>
                                <div class="col-sm-4">
                                    <input type="text" name="mode" class="form-control">
                                </div>
                                <label for="weight" class="col-sm-2 control-label">重量(kg)</label>
                                <div class="col-sm-4">
                                    <input type="text" name="weight" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unique_number" class="col-sm-2 control-label">69码</label>
                                <div class="col-sm-4">
                                    <input type="text" name="unique_number" id="unique_number" class="form-control">
                                </div>
                                <label for="zc_quantity" class="col-sm-2 control-label">自定义库存</label>
                                <div class="col-sm-4">
                                    <input type="text" name="zc_quantity" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="summary" class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-10">
                                    <input type="text" name="summary" class="form-control">
                                </div>
                            </div>


                            <div class="form-group">

                                <div class="col-md-12">
                                    <h5> <a id="appendnum" data-toggle="modal" style="float: right"><i class="glyphicon glyphicon-plus"></i>添加价格区间</a></h5>
                                    <hr>
                                    <strong style="float: left;color: red">注:价格区间第一行下限数量必须是1;从第二行开始每一行的下限数量需是上一行上限数量+1</strong>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr class="gblack">
                                            <th>下限数量</th>
                                            <th>上限数量</th>
                                            <th>批发价格</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody id="abc">
                                            <tr class="trs">

                                                <td>
                                                    <input type="text" class="min" name="min[]" required>
                                                </td>
                                                <td>
                                                <input type="text" class="max" name="max[]" required>
                                            </td>
                                                <td>
                                                    <input type="text" name="sell_price[]" required>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" onclick="deleteRow(this)" id="">删除</a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <input type="hidden" name="length" value="" id="length">
                                </div>
                                <div id="okay" style="margin-left: 47%"><a href="javascript:void(0)" style="color: black;font-size: 18px;">保存</a></div>
                            </div>




                            <h5>sku图片<small class="text-warning">［仅支持后缀(jpeg,jpg,png)格式图片，大小3MB以内］</small></h5>
                            <hr>
                            <div class="row mb-2r" id="create-sku-img">
                                <div class="col-md-4 mb-3r">
                                    <div id="picForm" enctype="multipart/form-data">
                                        <div class="img-add">
                                            <span class="glyphicon glyphicon-plus f46"></span>
                                            <p>添加图片</p>
                                            <div id="add-sku-uploader"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="create_cover_id" name="cover_id">
                                    <script type="text/template" id="qq-template">
                                        <div id="add-img" class="qq-uploader-selector qq-uploader">
                                            <div class="qq-upload-button-selector qq-upload-button">
                                                <div>上传图片</div>
                                            </div>
                                            <ul class="qq-upload-list-selector qq-upload-list">
                                                <li hidden></li>
                                            </ul>
                                        </div>
                                    </script>
                                </div>
                                <div class="col-md-2 mb-3r" style="display: none">
                                    <div style="width: 70px;height: 5px;background: lightblue;">
                                        <div id="progress_bar_sku" style="width: 0px;height: 5px;background: blue;"></div>
                                    </div>
                                </div>
                            </div>

    		                <div class="modal-footer">
    							<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.history.back()">取消</button>
    							<button type="submit" class="btn btn-magenta">确定</button>
    						</div>
					    </form>
		            </div>
		        </div>
			</div>
        </div>

        {{--  更改SKU --}}
        <div class="modal fade" id="updateskuModal" tabindex="-1" role="dialog"
             aria-labelledby="appendskuLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            更改SKU
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="upsku" method="post" class="form-horizontal" action="{{ url('/productsSku/update') }}">
                            {{ csrf_field() }}{{--token--}}
                            <input type="hidden" name="random" id="update_sku_random" value="{{ $random[1] }}">{{--图片上传回调随机数--}}
                            <input type="hidden" name="id" id="sku-id">
                            
                            <div class="form-group">
                                <label for="number" class="col-sm-2 control-label">SKU编码</label>
                                <div class="col-sm-4">
                                    <input type="text" name="number" ordertype="b2cCode" id="up-number" class="form-control" disabled>
                                </div>
                                <label for="cost_price" class="col-sm-2 control-label">成本价</label>
                                <div class="col-sm-4">
                                    <input type="text" name="cost_price" ordertype="b2cCode" id="up-cost-price" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">建议售价</label>
                                <div class="col-sm-4">
                                    <input type="text" name="price" ordertype="b2cCode" id="up-price" class="form-control">
                                </div>
                                <label for="bid_price" class="col-sm-2 control-label">市场售价</label>
                                <div class="col-sm-4">
                                    <input type="text" name="bid_price" ordertype="b2cCode" id="up-bid-price" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mode" class="col-sm-2 control-label">颜色/型号</label>
                                <div class="col-sm-4">
                                    <input type="text" name="mode" ordertype="b2cCode" id="up-mode" class="form-control">
                                </div>
                                <label for="weight" class="col-sm-2 control-label">重量(kg)</label>
                                <div class="col-sm-4">
                                    <input type="text" name="weight" ordertype="b2cCode" id="up-weight" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unique_number" class="col-sm-2 control-label">69码</label>
                                <div class="col-sm-4">
                                    <input type="text" name="unique_number" id="up-unique_number" class="form-control">
                                </div>
                                <label for="summary" class="col-sm-2 control-label">自定义库存</label>
                                <div class="col-sm-4">
                                    <input type="text" name="zc_quantity" id="up-zc_quantity" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="summary" class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-10">
                                    <input type="text" name="summary" ordertype="b2cCode" id="up-summary" class="form-control">
                                </div>
                            </div>


                            <div class="form-group">

                                <div class="col-md-12">
                                    <h5> <a id="appendnums" data-toggle="modal" style="float: right"><i class="glyphicon glyphicon-plus"></i>添加价格区间</a></h5>
                                    <hr>
                                    <strong style="float: left;color: red">注:价格区间第一行下限数量必须是1;从第二行开始每一行的下限数量需是上一行上限数量+1</strong>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr class="gblack">
                                            <th>下限数量</th>
                                            <th>上限数量</th>
                                            <th>批发价格</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody id="def">
                                            {{--<tr class="trs">--}}
    {{----}}
                                                {{--<td>--}}
                                                    {{--<input type="text" name="mins[]" class="min">--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" name="maxs[]" class="max">--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" name="sell_prices[]" class="sell_price">--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}

                                        </tbody>
                                    </table>
                                    <input type="hidden" name="lengths" value="" id="lengths">
                                </div>
                                <div id="okays" style="margin-left: 47%"><a href="javascript:void(0)" style="color: black;font-size: 18px">保存</a></div>
                            </div>


                            <h5>sku图片<small class="text-warning">［仅支持后缀(jpeg,jpg,png)格式图片，大小3MB以内］</small></h5>
                            <hr>
                            <div class="row mb-2r" id="update-sku-img">
                                <div class="col-md-4 mb-3r">
                                    <div id="picForm" enctype="multipart/form-data">
                                        <div class="img-add">
                                            <span class="glyphicon glyphicon-plus f46"></span>
                                            <p>添加图片</p>
                                            <div id="update-sku-uploader"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="update_cover_id" name="cover_id">
                                    <script type="text/template" id="qq-template">
                                        <div id="add-img" class="qq-uploader-selector qq-uploader">
                                            <div class="qq-upload-button-selector qq-upload-button">
                                                <div>上传图片</div>
                                            </div>
                                            <ul class="qq-upload-list-selector qq-upload-list">
                                                <li hidden></li>
                                            </ul>
                                        </div>
                                    </script>
                                </div>
                                <div class="col-md-2 mb-3r" style="display: none">
                                    <div style="width: 70px;height: 5px;background: lightblue;">
                                        <div id="progress_bar_sku_e" style="width: 0px;height: 5px;background: blue;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-magenta">确定</button>
                            </div>
                        </form>
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

@section('customize_js')
    @parent
    var is_form = 0; // 判断是否允许提交表单

    var _token = $("#_token").val();


    {{--编辑获取sku信息--}}
    function editSku(id) {
        $.get('{{ url('/productsSku/ajaxEdit') }}', {'id':id}, function (e) {

            {{--console.log(e);--}}
            {{--return false;--}}
            $('#sku-id').val(e.data.id);
            $('#up-number').val(e.data.number);
            $('#up-price').val(e.data.price);
            $('#up-bid-price').val(e.data.bid_price);
            $('#up-cost-price').val(e.data.cost_price);
            $('#up-mode').val(e.data.mode);
            $('#up-weight').val(e.data.weight);
            $('#up-summary').val(e.data.summary);
            $('#up-zc_quantity').val(e.data.zc_quantity);
            $('#up-unique_number').val(e.data.unique_number);

            {{--$min = $('.min');--}}
            {{--$max = $('.max');--}}
            {{--$sell_price = $('.sell_price');--}}
            {{--var arr = e.data.sku_region;--}}
            {{--console.log(arr);--}}
            var arr = e.data.sku_region;

            var str = "";
            var length = arr.length;
            for(var i=0;i < length;i++){

                str += "<tr class='trs'>";
                str += "<td><input type='text' class='mins' name='mins[]' value='"+arr[i].min+"' required></td>";
                str += "<td><input type='text' class='maxs' name='maxs[]' value='"+arr[i].max+"' required></td>";
                str += "<td><input type='text' class='sell_prices' name='sell_prices[]' value='"+arr[i].sell_price+"' required ></td>";
                str += "<td><a href='javascript:;' onclick='deleteRow(this)' id='"+arr[i].id+"'>删除</a></td>";
                str += "</tr>";
            }
            $("#def").html(str);

            $('#updateskuModal').modal('show');

            var template = ['@{{ #assets }}<div class="col-md-2 mb-3r">',
                '<img src="@{{ path }}" style="width: 100px;height: 100px;" class="img-thumbnail">',
                '<a class="removeimg" value="@{{ id }}">删除</a>',
                '</div>@{{ /assets }}'].join("");
                
            var views = Mustache.render(template, e.data);
            $('#update-sku-img').prepend(views);

            $('.removeimg').click(function(){
                var id = $(this).attr("value");
                var img = $(this);
                $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                    if(e.status){
                        img.parent().remove();
                    }else{
                        console.log(e.message);
                    }
                },'json');
            });

        },'json');

    }

    {{--点删除删除tr--}}
    function deleteRow(Obj)
    {
        Obj.parentNode.parentNode.remove(Obj.parentNode);
    }

    {{--判断上限数量与下限数量--}}
    $(document).on("change",".mins",function () {
    var thisData= $(this).val();
    var maxs = $(this).parent().parent().prev().find(".maxs").val();
    if(thisData == maxs){
    alert("下限数量与上限数量不可相等！");
    $(this).val("");
    return false;
    }
    })

    $(document).on("change",".min",function () {
    var thisData= $(this).val();
    var max = $(this).parent().parent().prev().find(".max").val();
    if(thisData == max){
    alert("下限数量与上限数量不可相等！");
    $(this).val("");
    return false;
    }
    })

    new qq.FineUploader({
		element: document.getElementById('fine-uploader'),
		autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
		// 远程请求地址（相对或者绝对地址)
		request: {
			endpoint: 'https://up.qbox.me',
			params:  {
				"token": '{{ $token }}',
				"x:user_id":'{{ $user_id }}',
				"x:target_id":'{{ $product->id }}',
                "x:type": 1,
			},
			inputName:'file',
		},
		validation: {
			allowedExtensions: ['jpeg', 'jpg', 'png'],
			sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
		},
        messages: {
            typeError: "仅支持后缀['jpeg', 'jpg', 'png']格式文件",
            sizeError: "上传文件最大不超过3M"
        },
		//回调函数
		callbacks: {
			//上传完成后
			onComplete: function(id, fileName, responseJSON) {
				if (responseJSON.success) {
					console.log(responseJSON.success);
					$('#update-product-img').append('<div class="col-md-2"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
                    $("#cover_id").val(responseJSON.asset_id);
					$('.removeimg').click(function(){
						var id = $(this).attr("value");
						var img = $(this);
						$.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
							if(e.status){
								img.parent().remove();
							}else{
								console.log(e.message);
							}
						},'json');

					});
				} else {
					alert('上传图片失败');
				}
			},
            onProgress:  function(id,  fileName,  loaded,  total)  {
                var number = loaded/total*70;
                console.log(number);
                $("#progress_bar").parent().parent().show();
                $("#progress_bar").css({'width':number+'px'});
                if(loaded == total){
                    $("#progress_bar").parent().parent().hide();
                }

            }
		}
	});
    
    new qq.FineUploader({
        element: document.getElementById('add-sku-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: 'https://up.qbox.me',
            params:  {
                "token": '{{ $token }}',
                "x:random": '{{ $random[0] }}',
                "x:user_id":'{{ $user_id }}'
            },
            inputName:'file',
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png'],
            sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
        },
        //回调函数
        callbacks: {
            //上传完成后
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    console.log(responseJSON.success);
                    $("#create_cover_id").val(responseJSON.asset_id);
                    $('#create-sku-img').append('<div class="col-md-4"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
                    $('.removeimg').click(function(){
                        var id = $(this).attr("value");
                        var img = $(this);
                        $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                            if(e.status){
                                img.parent().remove();
                            }else{
                                console.log(e.message);
                            }
                        },'json');
                    });
                } else {
                    alert('上传图片失败');
                }
            },
            onProgress:  function(id,  fileName,  loaded,  total)  {
                var number = loaded/total*70;
                $("#progress_bar_sku").parent().parent().show();
                $("#progress_bar_sku").css({'width':number+'px'});
                if(loaded == total){
                    $("#progress_bar_sku").parent().parent().hide();
                }

            }
        }
    });
    
    new qq.FineUploader({
        element: document.getElementById('update-sku-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: 'https://up.qbox.me',
            params:  {
                "token": '{{ $token }}',
                "x:random": '{{ $random[1] }}',
                "x:user_id":'{{ $user_id }}',
            },
            inputName:'file',
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png'],
            sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
        },
        //回调函数
        callbacks: {
            //上传完成后
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    console.log(responseJSON.success);
                    $("#update_cover_id").val(responseJSON.asset_id);
                    $('#update-sku-img').append('<div class="col-md-4"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
                    $('.removeimg').click(function(){
                        var id = $(this).attr("value");
                        var img = $(this);
                        $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                            if(e.status){
                                img.parent().remove();
                            }else{
                                console.log(e.message);
                            }
                        },'json');

                    });
                } else {
                    alert('上传图片失败');
                }
            },
            onProgress:  function(id,  fileName,  loaded,  total)  {
                var number = loaded/total*70;
                $("#progress_bar_sku_e").parent().parent().show();
                $("#progress_bar_sku_e").css({'width':number+'px'});
                if(loaded == total){
                    $("#progress_bar_sku_e").parent().parent().hide();
                }

            }
        }
    });



	$("#add-product").formValidation({
		framework: 'bootstrap',
		icon: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			category_id: {
				validators: {
					notEmpty: {
						message: '请选择商品分类！'
					}
				}
			},
            authorization_id: {
                validators: {
                    notEmpty: {
                        message: '请选择授权类型！'
                    }
                }
            },
			{{--supplier_id: {--}}
				{{--validators: {--}}
					{{--notEmpty: {--}}
						{{--message: '请选择供应商！'--}}
					{{--}--}}
				{{--}--}}
			{{--},--}}
			number: {
				validators: {
					notEmpty: {
						message: '编号不能为空！'
					},
					regexp: {
						regexp: /^[0-9\-]+$/,
						message: '编号格式不正确'
					}
				}
			},
			title: {
				validators: {
					notEmpty: {
						message: '商品名称不能为空！'
					}
				}
			},
			sale_price: {
				validators: {
					notEmpty: {
						message: '商品价格不能为空！'
					},
					regexp: {
						regexp: /^[0-9\.]+$/,
						message: '商品价格填写不正确'
					}
				}
			},
			weight: {
				validators: {
					regexp: {
						regexp: /^[0-9\.]+$/,
						message: '重量填写不正确'
					},
				}
			}

		}
	});

    $("#addsku").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            mode: {
                validators: {
                    notEmpty: {
                        message: '颜色或型号不能为空！'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: '价格不能为空！'
                    }
                }
            },
            bid_price: {
                validators: {
                    notEmpty: {
                        message: '标准进价不能为空！'
                    }
                }
            },
            cost_price: {
                validators: {
                    notEmpty: {
                        message: '成本价不能为空！'
                    }
                }
            },
            unique_number: {
                validators: {
                    notEmpty: {
                        message: '站外编号不能为空！'
                    }
                },
                onError: function(e, data) {
                    remove_message();
                },
                onSuccess: function(e, data) {
                    if (!data.fv.isValidField('unique_number')) {
                        data.fv.revalidateField('unique_number');
                        return false;
                    }

                    if(!is_form){
                        var insert_message = data.element;
                        {{--// 请求站外编号是否已存在--}}
                        var unique_number = $('#unique_number').val();
                        $.post('/productsSku/uniqueNumberCaptcha',{unique_number:unique_number,  _token: _token},function(data){
                            var obj = eval("("+data+")");
                            if(obj.status){
                                {{--remove_message();--}}
                                alert("站外编号已存在,请重新输入！");
                                {{--location.reload();--}}
                                return false;
                            }
                        });
                    }
                }
            }

        }
    });

    {{--删除sku--}}
    function destroySku(id) {
        if(confirm('确认删除该SKU吗？')){
            $.post('/productsSku/ajaxDestroy',{"_token":_token, "id":id},function (e) {
                if(e.status == 1){
                    location.reload();
                }else{
                    alert(e.message);
                }
            },'json');
        }
    }

    /*搜索下拉框*/
    $(".chosen-select").chosen({
        no_results_text: "未找到：",
        search_contains: true,
        width: "100%",
    });
@endsection

@section('load_private')
    @parent
    $("#appendsku").click(function(){
        $.get('/productsSku/uniqueNumber',{},function (e) {
            if(e.status){
                $("#add_number").val(e.data);
                $("#cost_price1").val($("#cost_price").val());
                $("#price").val($("#sale_price").val());
                $("#bid_price").val($("#market_price").val());
            }
        },'json');
        $("#appendskuModal").modal('show');
    });

    $("#appendnum").click(function(){


        $("#abc").append('<tr class="trs"><td><input type="text" class="min" name="min[]" required></td><td><input type="text" class="max" name="max[]" required></td><td><input type="text" name="sell_price[]" required></td><td><a href="javascript:;" onclick="deleteRow(this)" id="">删除</a></td></tr>');
    })

    $("#okay").click(function(){
        $('#length').val($('#abc tr').length);
    })
    $("#appendnums").click(function(){
        $("#def").append('<tr class="ts"><td><input type="text" class="mins" name="mins[]" required></td><td><input type="text" class="maxs" name="maxs[]" required></td><td><input type="text" name="sell_prices[]" required></td><td><a href="javascript:;" onclick="deleteRow(this)" id="">删除</a></td></tr>');
    })

    $("#okays").click(function(){
        $('#lengths').val($('#def tr').length);
    })





    $('.removeimg').click(function(){
        var id = $(this).attr("value");
        var img = $(this);
        $.post('{{url('/asset/ajaxDelete')}}',{'id': id,'_token': _token},function (e) {
            if(e.status){
                img.parent().parent().remove();
            }else{
                console.log(e.message);
            }
        },'json');
    });



    $('input[type=checkbox]').change(function(){
    $('#Jszzdm').val($('input[type=checkbox]:checked').map(function(){
    return this.value
    }).get().join(','))
    })
@endsection