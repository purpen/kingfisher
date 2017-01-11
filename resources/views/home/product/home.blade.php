@extends('home.base')

@section('customize_css')
    @parent
	.classify{
		background: rgba(221,221,221,0.3)
	}
	.classify .ui.dividing.header{
		padding: 5px 15px 10px;
    	border-bottom: 1px solid rgba(0,0,0,0.2);
    	font-size:16px;
	}
	.panel-group .panel-heading{
		padding: 20px;
    	margin-top: 10px;
    	position: relative;
	}
	.panel-title {
	    font-size: 14px;
	    width: 100%;
	    height: 100%;
	    position: absolute;
	    top: 0;
	    left: 0;
	    padding: 0px 15px;
	    line-height: 40px;
	    text-decoration: none !important;
	}
	.panel-title:hover{
		background:#f5f5f5;
	}
	.panel-title.collapsed span.glyphicon.glyphicon-triangle-bottom {
	    transform: rotate(-90deg);
	    -webkit-transform: rotate(-90deg);
	}
	.panel-group .panel-heading+.panel-collapse>.list-group{
		margin-left: 15px;
	    border: none;
	}
	.list-group-item{
		padding: 5px 15px;
	    background-color: rgba(0,0,0,0);
	    border: 0 !important;
	    border-radius: 0 !important;
	}
	tr.bone > td{
		border:none !important;
		border-bottom: 1px solid #ddd !important;
	}
	tr.brnone > td{
		border: none !important;
    	border-bottom: 1px solid #ddd !important;
	}
	.popover-content tr{
	    line-height: 24px;
    	font-size: 13px;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					商品管理
				</div>
			</div>
            <div class="navbar-collapse collapse">
                @include('home.product.subnav')
            </div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/product/create') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 上传商品
                        </a>
                    </div>
					@if($tab_menu == 'default')
						<button type="button" class="btn btn-success mr-2r" id="upProduct">
							<i class="glyphicon glyphicon-circle-arrow-up"></i> 上架
						</button>
						<button type="button" class="btn btn-warning mr-2r" id="downProduct">
							<i class="glyphicon glyphicon-circle-arrow-down"></i> 下架
						</button>
					@endif
                    <div class="form-group">
                        @if($tab_menu == 'unpublish')
                            <button type="button" class="btn btn-success mr-2r" id="upProduct">
                                <i class="glyphicon glyphicon-circle-arrow-up"></i> 上架
                            </button>
                        @endif
                        @if($tab_menu == 'saled')
                            <button type="button" class="btn btn-warning mr-2r" id="downProduct">
                                <i class="glyphicon glyphicon-circle-arrow-down"></i> 下架
                            </button>
                        @endif
                        @if($tab_menu !== 'canceled')
                            <button type="button" class="btn btn-white" onclick="destroyProduct()">
                                <i class="glyphicon glyphicon-trash"></i> 取消
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="datatable-length">
                    <select class="form-control selectpicker input-sm" name="per_page">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="datatable-info ml-r">
                    条/页，显示 {{ $products->firstItem() }} 至 {{ $products->lastItem() }} 条，共 {{ $products->total() }} 条记录
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
        		<table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>状态</th>
                            <th>缩略图</th>
                            <th>编号</th>
                            <th>商品简称</th>
                            <th>供应商</th>
                            @role(['buyer', 'director', 'admin'])
        					<th>成本价</th>
                            @endrole
                            <th>市场售价</th>
                            <th>建议售价</th>
                            <th class="text-center">库存总量</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
        				@foreach($products as $product)
        					<tr class="brnone">
                    		<td class="text-center">
                    			<input type="checkbox" name="Order" value="{{ $product->id }}">
                    		</td>
    						<td>
    							@if ($product->status == 1)
    								<span class="label label-danger">待上架</span>
    							@endif

    							@if ($product->status == 2)
    								<span class="label label-success">在售中</span>
    							@endif

    							@if ($product->status == 3)
    								<span class="label label-default">已取消</span>
    							@endif
    						</td>
                    		<td>
                    			<img src="{{$product->first_img}}" class="img-thumbnail" style="width: 80px;">
                    		</td>
                    		<td class="magenta-color">
                    			{{ $product->number }}
                    		</td>
                    		<td class="table-name" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $product->title }}">
                    			<span class="proname">{{ $product->tit }}</span>
                    		</td>
        					<td>
        						@if ($product->supplier) {{ $product->supplier->nam }} @endif
        					</td>
                            @role(['buyer', 'director', 'admin'])
        					<td>
        						{{ $product->cost_price }}
        					</td>
                            @endrole
        					<td>
        						{{ $product->market_price }}
        					</td>
                    		<td>
                    			{{ $product->sale_price }}
                    		</td>
                    		<td class="magenta-color text-center">{{$product->inventory}}</td>
                    		<td class="table-mark" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $product->summary }}">{{ str_limit($product->summary, 80) }}</td>
                    		<td>
    							@if(in_array($product->id , $skuId) )
    								<button class="btn btn-default btn-sm showSku" onclick="showSku({{$product->id}})">显示SKU</button>
    							@else
    								<button class="btn btn-default btn-sm" disabled="true">显示SKU</button>
    							@endif
    							<a class="btn btn-default btn-sm" href="{{ url('/product/edit') }}?id={{$product->id}}" target="_blank">编辑</a>
                    		</td>
                    	</tr>
        					@foreach($product->productsSku as $sku)
        						<tr class="bone product{{$product->id}} active" active="0" hidden>
        							<td class="text-center"></td>
    								@if(in_array($product->status,[1,2,3]))
    								<td></td>
    								@endif
        							<td>
                                        <img src="{{ $sku->first_img }}"  class="img-thumbnail" style="width: 80px;">
                                    </td>
        							<td>SKU<br>{{ $sku->number }}</td>
        							<td colspan="2">属性：{{ $sku->mode }}</td>
        							<td>{{ $sku->bid_price }}</td>
        							<td>{{ $sku->cost_price }}</td>
        							<td>{{ $sku->price }}</td>
        							<td>{{ $sku->weight }}</td>
        							<td class="magenta-color text-center">{{ $sku->quantity }}</td>
        							<td>{{ $sku->summary }}</td>
        							<td><a class="btn btn-danger btn-sm" onclick="destroySku({{ $sku->id }})">删除</a></td>
        						</tr>
        					@endforeach
        				@endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">{!! $products->appends(['q' => $name])->render() !!}</div>
        </div>
	</div>
	<input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('customize_js')
    @parent
	var _token = $('#_token').val();
	$(function () { $("[data-toggle='popover']").popover(); });

	$('.operate-update-offlineEshop').click(function(){
		$(this).siblings().css('display','none');
		$(this).css('display','none');
		$(this).siblings('input[name=txtTitle]').css('display','block');
		$(this).siblings('input[name=txtTitle]').focus();
	});

	$('input[name=txtTitle]').bind('keypress',function(event){
		if(event.keyCode == "13") {
			$(this).css('display','none');
        	$(this).siblings().removeAttr("style");
        	$(this).siblings('.proname').html($(this).val());
		}
    });

    $('input[name=txtTitle]').bind('blur',function(){
    	$(this).css('display','none');
    	$(this).siblings().removeAttr("style");
        $(this).siblings('.proname').html($(this).val());
    });
	{{--删除sku--}}
	function destroySku(id){
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

	{{--上架商品--}}
	$("#upProduct").click(function () {
		if(confirm('确认上架选中商品吗？')) {
			var id = [];
			$("input[name='Order']").each(function () {
				if ($(this).is(':checked')) {
					id.push($(this).val());
				}
			});
			$.post('{{ url('/product/ajaxUpShelves') }}', {"_token": _token, "id": id}, function (e) {
				if (e.status == 1) {
					location.reload();
				} else if (e.status ==0){
					alert(e.message);
				} if (e.status == -1){
					alert(e.msg);
				}
			}, 'json');
		}
	});

	{{--下架商品--}}
	$("#downProduct").click(function () {
		if(confirm('确认下架选中的商品吗？')) {
			var id = [];
			$("input[name='Order']").each(function () {
				if ($(this).is(':checked')) {
					id.push($(this).val());
				}
			});
			$.post('{{ url('/product/ajaxDownShelves') }}', {"_token": _token, "id": id}, function (e) {
				if (e.status == 1) {
					location.reload();
				} else {
					alert(e.message);
				}
			}, 'json');
		}
	});

	function destroyProduct() {
		if(confirm('确认删除选中的商品？')){
			var order = $("input[name='Order']");
			var id_json = {};
			for (var i=0;i < order.length;i++){
				if(order[i].checked == true){
					id_json[i] = order[i].value;
				}
			}
			var data = {"_token":_token,"id":id_json};
			$.post('{{ url('/product/ajaxDestroy') }}',data,function (e) {
				if(e.status == 1){
					location.reload();
				}else{
					alert(e.message);
				}
			},'json');

		}
	}

	{{--展示隐藏SKU--}}
	function showSku(id) {
		var dom = '.product' + id;
		console.log(dom);
		if($(dom).eq(0).attr('active') == 0){
			$(dom).each(function () {
				$(this).attr("active",1);
			});
			$(dom).show("slow");

		}else{
			$(dom).each(function () {
			$(this).attr("active",0);
			});
			$(dom).hide("slow");
		}

	}
@endsection