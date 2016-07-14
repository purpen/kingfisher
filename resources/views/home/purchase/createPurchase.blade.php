@extends('home.base')

@section('title', '新增采购单')

@section('customize_css')
    @parent
	.scrollt{
		height:400px;
		overflow:hidden;
	}
	.sublock{
		display: block !important;
    	margin-left: -15px;
    	margin-right: -15px;
	}
@endsection

@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						新增采购单
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		<form id="add-purchase" role="form" method="post" action="{{ url('/purchase/store') }}">
			<div class="row ui white ptb-4r">
				<div class="col-md-12">
					<div class="form-inline">
						<div class="form-group vt-34">选择供应商：</div>
						<div class="form-group pr-4r mr-2r">
							<select class="selectpicker" id="supplier_id" name="supplier_id" style="display: none;">
								<option value=''>选择供应商</option>
								@foreach($suppliers as $supplier)
									<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group vt-34">入库仓库：</div>
                        <div class="form-group pr-4r mr-2r">
                            <select class="selectpicker" name="storage_id" style="display: none;">
                                <option value="">选择仓库</option>
								@foreach($storages as $storage)
									<option value="{{ $storage->id }}">{{ $storage->name }}</option>
								@endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-magenta" data-toggle="modal" id="addpurchase-button">
							＋添加采购商品
						</button>
						<div class="modal fade" id="addpurchase" tabindex="-1" role="dialog" aria-labelledby="addpurchaseLabel">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
										<h4 class="modal-title" id="gridSystemModalLabel">添加商品</h4>
									</div>
									<div class="modal-body">
										<div class="input-group">
											<input id="search_val" type="text" placeholder="请输入SKU编码/商品名称" class="form-control">
											<span class="input-group-btn">
                  								<button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                  							</span>
										</div>
										<div class="mt-4r scrollt">
												<div id="sku-list"></div>
										</div>
										<div class="form-group mb-0 sublock">
											<div class="modal-footer pb-r">
												<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
												<button type="button" id="choose-sku" class="btn btn-magenta">确定</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ui white ptb-4r">
				<div class="well-lg textc mlr-3r mt-r">
						<div id="append-sku"></div>
						{{--<table class="table" style="margin-bottom:20px;">
							<thead class=" table-bordered">
							<tr>
								<th>商品图片</th>
								<th>SKU编码</th>
								<th>商品名称</th>
								<th>商品属性</th>
								<th>采购数量</th>
								<th>已入库数量</th>
								<th>采购价</th>
								<th>总价</th>
								<th>备注</th>
								<th>操作</th>
							</tr>
							</thead>
							<tbody>
							<!---->

							<tr>
								<td><img src="" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
								<td class="fb">12121</td>
								<td>自行车</td>
								<td>自行车</td>
								<td><div class="form-group" style="width:100px;"><input type="text" class="form-control integer operate-caigou-blur" placeholder=""></div></td>
								<td id="warehouseQuantity0">0</td>
								<td><div class="form-group" style="width:100px;"><input type="text" name="price" class="form-control operate-caigou-blur" placeholder="0.00"></div></td>
								<td id="totalTD0">0.00</td>
								<td><div class="form-group"><input type="text" class="form-control" placeholder="输入备注"></div></td>
								<td><a class="delete" href="javascript:void(0)">删除</a></td>
							</tr>

							<!---->
							<tr style="background:#dcdcdc;border:1px solid #dcdcdc; ">
								<td colspan="4" class="fb">合计：</td>
								<td colspan="2" class="fb">采购数量总计：<span class="red" id="skuTotalQuantity">0</span></td>
								<td colspan="3" class="fb">采购总价：<span class="red" id="skuTotalFee">0.00</span></td>
							</tr>
							</tbody>
						</table>--}}

				</div>
				<div class="form-horizontal">
					<div class="form-group mlr-0">
						<div class="lh-34 m-56 ml-3r fl">备注</div>
						<div class="col-sm-5 pl-0">
							<textarea rows="3" class="form-control" name="summary" id="memo"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-4r pt-2r">
				<button type="submit" class="btn btn-magenta mr-r save">保存</button>
				<button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">取消</button>
			</div>
			{!! csrf_field() !!}
		</form>
	</div>
@endsection

@section('customize_js')
    @parent
	{{--<script>--}}
	var sku_data = '';
	var sku_id = [];
	$("#checkAll").click(function () {
        $("input[name='Order']:checkbox").prop("checked", this.checked);
    });
    $('.scrollt tbody tr').click(function(){
    	if( $(this).find("input[name='Order']").attr('active') == 0 ){
    		$(this).find("input[name='Order']").prop("checked", "checked").attr('active','1');
    	}else{
    		$(this).find("input[name='Order']").prop("checked", "").attr('active','0');
    	}
    });

	{{--根据供应商显示商品列表--}}
	$("#addpurchase-button").click(function () {
		var supplier_id = $("#supplier_id").val();
		if(supplier_id == ''){
			alert('请选择供应商');
		}else{
			$.get('/productsSku/ajaxSkus',{'supplier_id':supplier_id},function (e) {
				if (e.status){
					var template = ['<table class="table table-bordered table-striped">',
							'<thead>',
							'<tr class="gblack">',
								'<th class="text-center"><input type="checkbox" id="checkAll"></th>',
								'<th>商品图</th>',
								'<th>SKU编码</th>',
								'<th>商品名称</th>',
								'<th>属性</th>',
								'<th>库存</th>',
								'</tr>',
							'</thead>',
						'<tbody>',
						'@{{#data}}<tr>',
						'<td class="text-center"><input name="Order" class="sku-order" type="checkbox" active="0" value="@{{id}}"></td>',
						'<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
						'<td>@{{ number }}</td>',
						'<td>@{{ name }}</td>',
						'<td>@{{ mode }}</td>',
						'<td>@{{ quantity }}</td>',
						'</tr>@{{/data}}',
						'</tbody>',
						'</table>',
						].join("");
					var views = Mustache.render(template, e);
					sku_data = e.data;
					$("#sku-list").html(views);
					$("#addpurchase").modal('show');
				}
			},'json');
		}
	});

	{{--根据名称或编号搜索--}}
	$("#sku_search").click(function () {
		var val = $("#search_val").val();
		if(val == ''){
			alert('输入为空');
		}else{
			$.get('/productsSku/ajaxSearch',{'where':val},function (e) {
				if (e.status){
					var template = ['<table class="table table-bordered table-striped">',
						'<thead>',
						'<tr class="gblack">',
						'<th class="text-center"><input type="checkbox" id="checkAll"></th>',
						'<th>商品图</th>',
						'<th>SKU编码</th>',
						'<th>商品名称</th>',
						'<th>属性</th>',
						'<th>库存</th>',
						'</tr>',
						'</thead>',
						'<tbody>',
						'@{{#data}}<tr>',
						'<td class="text-center"><input type="checkbox" active="0" value="@{{id}}"></td>',
						'<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
						'<td>@{{ number }}</td>',
						'<td>@{{ name }}</td>',
						'<td>@{{ mode }}</td>',
						'<td>@{{ quantity }}</td>',
						'</tr>@{{/data}}',
						'</tbody>',
						'</table>',
					].join("");
					var views = Mustache.render(template, e);
					$("#sku-list").html(views);
					sku_data = e.data;
				}
			},'json');
		}
	});

	$("#choose-sku").click(function () {
		var skus = [];
		$(".sku-order").each(function () {
			if($(this).is(':checked')){
				sku_id.push(parseInt($(this).attr('value')));
			}
		});
		for (var i=0;i < sku_data.length;i++){
			if(jQuery.inArray(sku_data[i].id,sku_id) != -1){

				skus.push(sku_data[i]);
			}
		}
		var template = ['<table class="table" style="margin-bottom:20px;">',
		'							<thead class=" table-bordered">',
		'							<tr>',
			'								<th>商品图片</th>',
			'								<th>SKU编码</th>',
			'								<th>商品名称</th>',
			'								<th>商品属性</th>',
			'								<th>采购数量</th>',
			'								<th>已入库数量</th>',
			'								<th>采购价</th>',
			'								<th>总价</th>',
			'								<th>操作</th>',
			'							</tr>',
		'							</thead>',
		'							<tbody>',
		'							<!---->',
		'					@{{#skus}}<tr>',
			'								<td><img src="" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>',
			'								<td class="fb">@{{number}}</td>',
			'<input type="hidden" name="sku_id[]" value="@{{id}}">',
			'								<td>@{{name}}</td>',
			'								<td>@{{mode}}</td>',
			'								<td><div class="form-group" style="width:100px;"><input type="text" class="form-control integer operate-caigou-blur" name="count[]" placeholder="采购数量"></div></td>',
			'								<td id="warehouseQuantity0">@{{quantity}}</td>',
			'								<td><div class="form-group" style="width:100px;"><input type="text" name="price[]" class="form-control operate-caigou-blur" placeholder="0.00"></div></td>',
			'								<td id="totalTD0">0.00</td>',
			'								<td class="delete"><a href="javascript:void(0)">删除</a></td>',
			'							</tr>@{{/skus}}',
		'							',
		'							<!---->',
		'							<tr style="background:#dcdcdc;border:1px solid #dcdcdc; ">',
			'								<td colspan="4" class="fb">合计：</td>',
			'								<td colspan="2" class="fb">采购数量总计：<span class="red" id="skuTotalQuantity">0</span></td>',
			'								<td colspan="3" class="fb">采购总价：<span class="red" id="skuTotalFee">0.00</span></td>',
			'							</tr>',
		'							</tbody>',
		'						</table>'].join("");;
		var data = {};
		data['skus'] = skus;
		var views = Mustache.render(template, data);
		console.log(skus);
		$("#append-sku").html(views);
		$("#addpurchase").modal('hide');
		$(".delete").click(function () {
			$(this).parent().remove();
		});
	});


@endsection
