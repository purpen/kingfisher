@extends('home.base')

@section('title', '修改商品')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
    .formwrapper {
        background-color: #fff;
    }
	.m-92{
		min-width:92px;
		text-align:right;
	}
	.img-add{
	    width: 100px;
	    height: 100px;
	    background: #f5f5f5;
	    vertical-align: middle;
	    text-align: center;
	    padding: 24px 0;
	}
	.img-add .glyphicon{
		font-size: 24px;
	}
	#picForm{
		position:relative;
		color: #f36;
	    height: 100px;
	    text-decoration: none;
	    width: 100px;
        margin-bottom: 30px;
	}
	#picForm:hover{
		color:#e50039;
	}
	#picForm .form-control{
		top: 0;
	    left: 0;
	    position: absolute;
	    opacity: 0;
	    width: 100px;
	    height: 100px;
	    z-index: 3;
	    cursor: pointer;
	}
	.removeimg{
	    position: absolute;
    	left: 75px;
    	bottom: 10px;
    	font-size: 13px;
	}
	#appendsku{
		margin-left:40px;
		font-size:14px;
	}
	.qq-uploader {
	    position: relative;
	    width: 100%;
	    width: 100px;
	    height: 100px;
	    top: 0;
	    left: 0;
	    position: absolute;
	    opacity: 0;
	}
	.qq-upload-button{
		width:100px;
		height:100px;
		position:absolute !important;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
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
	</div>
	<div class="container mainwrap">
        <div class="row formwrapper">
            <div class="col-md-12">
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
                            <div class="input-group">
            					<select class="selectpicker" id="orderType" name="category_id" style="display: none;">
                                    <option value="0">默认分类</option>
                                     @foreach($lists as $list)
            						<option value="{{ $list->id }}" {{ $product->category_id == $list->id?'selected':'' }}>{{ $list->title }}</option>
                                    @endforeach
            					</select>
                            </div>
                        </div>
                        <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">选择供应商</label>
                        <div class="col-sm-3">
                            <div class="input-group">
            					<select class="selectpicker" id="orderType" name="supplier_id" style="display: none;">
            						<option value="">选择供应商</option>
            						@foreach($suppliers as $supplier)
            						<option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id?'selected':'' }}>{{ $supplier->nam }}</option>
            						@endforeach
            					</select>
                            </div>
                        </div>
                    </div>
            
        			<h5>基本信息</h5>
                    <hr>
                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">货号</label>
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
                        <label for="title" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">商品名称</label>
                        <div class="col-sm-9">
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
                        <div class="col-sm-3">
                            <input type="text" name="tit" ordertype="b2cCode" class="form-control" value="{{ $product->tit }}">
                            @if ($errors->has('tit'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tit') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <label for="supplier_name" class="col-sm-2 control-label {{ $errors->has('supplier_name') ? ' has-error' : '' }}">供应商简称</label>
                        <div class="col-sm-3">
                            <input type="text" name="supplier_name" ordertype="b2cCode" class="form-control" value="{{ $product->supplier_name }}">
                            @if ($errors->has('supplier_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('supplier_name') }}</strong>
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
                        
                        <label for="market_price" class="col-sm-1 control-label {{ $errors->has('market_price') ? ' has-error' : '' }}">标准进价<small>(元)</small></label>
                        <div class="col-sm-2">
                            <input type="text" id="market_price" name="market_price" ordertype="b2cCode" class="form-control" value="{{ $product->market_price }}">
                            @if ($errors->has('market_price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('market_price') }}</strong>
                                </span>
                            @endif
                        </div>
                
                        <label for="sale_price" class="col-sm-1 control-label {{ $errors->has('sale_price') ? ' has-error' : '' }}">零售价<small>(元)</small></label>
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
                            <input type="text" name="summary" ordertype="b2cCode" class="form-control" value="{{ $product->summary }}">
                            @if ($errors->has('summary'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
        			<h5>商品图片</h5>
                    <hr>

    				@foreach($assets as $asset)
                    <div class="form-group col-sm-2">
    					<div class="asset">
    						<img src="{{ $asset->file->small }}" style="width: 100px;" class="img-thumbnail">
    						<a class="removeimg" value="{{ $asset->id }}">删除</a>
    					</div>
                    </div>
    				@endforeach

                    <div class="row mb-2r" id="update-product-img">
                        <div class="col-md-1 mb-3r">
                            <div id="picForm" enctype="multipart/form-data">
                                <div class="img-add">
                                    <span class="glyphicon glyphicon-plus f46"></span>
                                    <p>添加图片</p>
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
                        <div class="col-md-1 mb-3r" style="display: none">
                            <div style="width: 70px;height: 5px;background: lightblue;">
                                <div id="progress_bar" style="width: 0px;height: 5px;background: blue;"></div>
                            </div>
                        </div>
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
                                    <th>标准进价</th>
                                    <th>成本价</th>
                                    <th>售价</th>
                                    <th>颜色/型号</th>
                                    <th>重量（kg）</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product->productsSku as $sku)
                                <tr class=".tr">
                                    <td>{{ $sku->id }}</td>
                                    <td>
                                        <img src="@if($sku->assets){{ $sku->assets->file->small }}@endif" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;">
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
            				<button type="submit" class="btn btn-magenta mr-r save">确认更新</button>
            				<button type="button" class="btn btn-white cancel once" onclick="history.back(-1)">取消</button>
                        </div>
                    </div>
        		</form>
                
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
                                    <input type="text" id="cost_price1" name="cost_price" ordertype="b2cCode" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">售价</label>
                                <div class="col-sm-4">
                                    <input type="text" id="price" name="price" ordertype="b2cCode" class="form-control">
                                </div>
                                <label for="bid_price" class="col-sm-2 control-label">标准进价</label>
                                <div class="col-sm-4">
                                    <input type="text" id="bid_price" name="bid_price" ordertype="b2cCode" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mode" class="col-sm-2 control-label">颜色/型号</label>
                                <div class="col-sm-4">
                                    <input type="text" name="mode" ordertype="b2cCode" class="form-control">
                                </div>
                                <label for="weight" class="col-sm-2 control-label">重量(kg)</label>
                                <div class="col-sm-4">
                                    <input type="text" name="weight" ordertype="b2cCode" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="summary" class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-10">
                                    <input type="text" name="summary" ordertype="b2cCode" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-2r" id="create-sku-img">
                                <div class="col-md-2 mb-3r">
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
    							<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
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
                                <label for="price" class="col-sm-2 control-label">售价</label>
                                <div class="col-sm-4">
                                    <input type="text" name="price" ordertype="b2cCode" id="up-price" class="form-control">
                                </div>
                                <label for="bid_price" class="col-sm-2 control-label">标准进价</label>
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
                                <label for="summary" class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-10">
                                    <input type="text" name="summary" ordertype="b2cCode" id="up-summary" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-2r" id="update-sku-img">
                                <div class="col-md-2 mb-3r">
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
@endsection

@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();

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


    {{--获取sku信息--}}
    function editSku(id) {
        $.get('{{ url('/productsSku/ajaxEdit') }}', {'id':id}, function (e) {
            $('#sku-id').val(e.data.id);
            $('#up-number').val(e.data.number);
            $('#up-price').val(e.data.price);
            $('#up-bid-price').val(e.data.bid_price);
            $('#up-cost-price').val(e.data.cost_price);
            $('#up-mode').val(e.data.mode);
            $('#up-weight').val(e.data.weight);
            $('#up-summary').val(e.data.summary);
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
    
    $(function(){
		new qq.FineUploader({
			element: document.getElementById('fine-uploader'),
			autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
			// 远程请求地址（相对或者绝对地址）
			request: {
				endpoint: 'https://up.qbox.me',
				params:  {
					"token": '{{ $token }}',
					"x:user_id":'{{ $user_id }}',
					"x:target_id":'{{ $product->id }}'
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
						$('#update-product-img').append('<div class="col-md-1 mb-3r"><img src="'+responseJSON.name+'" style="width: 80px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
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
                        $('#create-sku-img').append('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
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
                        $('#update-sku-img').append('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
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
    			supplier_id: {
    				validators: {
    					notEmpty: {
    						message: '请选择供应商！'
    					}
    				}
    			},
    			number: {
    				validators: {
    					notEmpty: {
    						message: '货号不能为空！'
    					},
    					regexp: {
    						regexp: /^[0-9\-]+$/,
    						message: '货号格式不正确'
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
        
    });
@endsection