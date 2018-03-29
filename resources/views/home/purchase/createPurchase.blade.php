@extends('home.base')

@section('title', '新增采购单')

@section('customize_css')
    @parent
	.maindata input{
		width:100px;
	}
@endsection

@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					新增采购单
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		@include('block.form-errors')
		<div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
            		<form id="add-purchase" role="form" method="post" class="form-horizontal" action="{{ url('/purchase/store') }}">
                        <h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
							<div class="col-md-9">
								<label for="weight" class="col-sm-1 control-label">类型</label>
								<div class="col-sm-2">
									<select class="selectpicker" id="supplier_type" name="type" style="display: none;">
										<option value='1'>老款补货</option>
										<option value='2'>新品到货</option>
									</select>
								</div>

								<label for="weight" class="col-sm-1 control-label">供应商</label>
								<div class="col-sm-2">
									<div class="input-group">
										<select class="chosen-select" id="supplier_id"  name="supplier_id">
											@foreach($suppliers as $supplier)
												<option value="{{ $supplier->id }}">{{ $supplier->nam }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<label for="weight" class="col-sm-1 control-label">仓库</label>
								<div class="col-sm-2">
									<select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
										<option value="">选择仓库</option>
										@foreach($storages as $storage)
											<option value="{{ $storage->id }}">{{ $storage->name }}</option>
										@endforeach
									</select>
								</div>
								<label for="weight" class="col-sm-1 control-label">部门</label>
								<div class="col-sm-2">
									<select class="selectpicker" id="" name="department" style="display: none;">
										<option value="">选择部门</option>
											<option value="1">Fiu店</option>
										    <option value="2">D3IN</option>
                                            <option value="3">海外</option>
                                            <option value="4">电商</option>
									</select>
								</div>
							</div>


                            <div class="col-md-3">
                                <button type="button" class="btn btn-magenta" data-toggle="modal" id="addpurchase-button">
        							＋ 添加采购商品
        						</button>
                            </div>
                        </div>
                        <hr>

    					{{--添加商品弹出框--}}
    					@include('modal.create_purchase_add_modal')

                        <div class="form-group">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped">
                                    <thead class=" table-bordered">
                                        <tr class="gblack">
                                            <th>商品图片</th>
                                            <th>SKU编码</th>
                                            <th>商品名称</th>
                                            <th>商品属性</th>
                                            <th>销售价格</th>
                                            <th>库存数量</th>
                                            <th>采购价</th>
                                            <th>采购数量</th>
                                            <th>运费</th>
                                            <th>商品税率</th>
                                            <th>总价</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="append-sku"></tbody>
                                    <tfoot>
                                        <tr style="background:#dcdcdc;border:1px solid #dcdcdc; ">
                                            <td colspan="4" class="fb">合计：</td>
											<td colspan="1" class="fb">
                                                    <input type="text" class="form-control" id="surcharge" name="surcharge" placeholder="附加费用">
											</td>
                                            <td colspan="2" class="fb allquantity">采购数量总计：<span class="red" id="skuTotalQuantity">0</span></td>
                                            <td colspan="5" class="fb alltotal">采购总价：<span class="red" id="skuTotalFee">0.00</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <hr>
						<div class="form-group">
							<label for="invoice_info" class="col-sm-1 control-label">发票信息</label>
							<div class="col-sm-11">
								<input type="text" name="invoice_info" class="form-control">
							</div>
						</div>

                        <div class="form-group">
                            <label class="col-sm-1 control-label">预计到货</label>
                            <div class="col-sm-11">
                                <input type="text" class="input-append date" id="datetimepicker" name="predict_time">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">备注信息</label>
                            <div class="col-sm-11">
                                <textarea rows="2" class="form-control" name="summary" id="memo"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-1">
                				<button type="submit" class="btn btn-magenta btn-lg save">确认保存</button>
                				<button type="button" class="btn btn-white cancel btn-lg once"  onclick="window.history.back()">取消</button>
                            </div>
                        </div>
            			{!! csrf_field() !!}
            		</form>
                </div>
            </div>
        </div>
	</div>
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
	var sku_data = '';
	var sku_id = [];

	{{--选则到货的时间--}}
	$('#datetimepicker').datetimepicker({
		language:  'zh',
		minView: "month",
		format : "yyyy-mm-dd",
		autoclose:true,
		todayBtn: true,
		todayHighlight: true,
	});

	/*搜索下拉框*/
	$(".chosen-select").chosen({
		no_results_text: "未找到：",
		search_contains: true,
        width: "100%",
	});

@endsection

@section('load_private')
	@parent
	{{--<script>--}}
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
        var supplier_id = $("#supplier_id").val();
		if(val == ''){
			alert('输入为空');
		}else{
			$.get('/productsSku/ajaxSearch',{'where':val,'supplier_id':supplier_id},function (e) {
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
					$("#sku-list").html(views);
					sku_data = e.data;
				}
			},'json');
		}
	});

	$("#choose-sku").click(function () {
		var skus = [];
		var sku_tmp = [];
		$(".sku-order").each(function () {
			if($(this).is(':checked')){
				if($.inArray(parseInt($(this).attr('value')),sku_id) == -1){
					sku_id.push(parseInt($(this).attr('value')));
					sku_tmp.push(parseInt($(this).attr('value')));
				}
			}
		});
		for (var i=0;i < sku_data.length;i++){
			if(jQuery.inArray(parseInt(sku_data[i].id),sku_tmp) != -1){
				skus.push(sku_data[i]);
			}
		}
		var template = ['@{{#skus}}<tr class="maindata">',
			'								<td><img src="@{{path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>',
			'								<td class="fb">@{{number}}</td>',
			'<input type="hidden" name="sku_id[]" value="@{{id}}">',
			'								<td>@{{name}}</td>',
			'								<td>@{{mode}}</td>',
			'								<td>@{{sale_price}}</td>',
			'								<td id="warehouseQuantity0">@{{quantity}}</td>',
			'								<td><input type="text" name="price[]" value="@{{ price }}" class="form-control operate-caigou-blur price" id="price" placeholder="0.00"></td>',
			'								<td><input type="text" class="form-control integer operate-caigou-blur count" id="count" name="count[]" value="0" placeholder="采购数量"></td>',
			'								<td><input type="text" name="freight[]" value="0" class="form-control operate-caigou-blur freight" id="freight" placeholder="运费"></td>',
			'								<td><input type="text" class="form-control integer operate-caigou-blur tax_rate" id="tax_rate" name="tax_rate[]" placeholder="0"></td>',
			'								<td class="total">0.00</td>',
			'								<td class="delete" value="@{{id}}"><a href="javascript:void(0)">删除</a></td>',
			'							</tr>@{{/skus}}'].join("");
		var data = {};
		data['skus'] = skus;
		var views = Mustache.render(template, data);
		$("#append-sku").append(views);
		$("#addpurchase").modal('hide');
		$(".delete").click(function () {
			sku_id.pop($(this).attr('value'));
			$(this).parent().remove();
		});

		$("#add-purchase").formValidation({
		framework: 'bootstrap',
		icon: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			storage_id: {
				validators: {
					notEmpty: {
						message: '请选择入库仓库！'
					}
				}
			},
            department: {
                validators: {
                    notEmpty: {
                        message: '请选择部门！'
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
			"count[]": {
				validators: {
					notEmpty: {
						message: '采购数量不能为空！'
					}
				}
			},
			"price[]": {
				validators: {
						notEmpty: {
							message: '采购价格不能为空！'
						}
					}
				}
			}
		});
	});

	$('.count').bind('input propertychange', function() {
		alert($(this).val())
	});
	$("input[name='count[]']").livequery(function(){
		$(this)
		.css("ime-mode", "disabled")
		.keydown(function(){
			if(event.keyCode==13){
				event.keyCode=9;
			}
		})
		.keypress(function(){
			if ((event.keyCode<48 || event.keyCode>57)){
				event.returnValue=false ;
			}
		})
		.keyup(function(){
		var quantity = $(this).val();
		var price = $(this).parent().siblings().children("input[name='price[]']").val();
		var freight = $(this).parent().siblings().children("input[name='freight[]']").val();
		if(freight == ''){
			freight = 0;
		}
		var surcharge = $("#surcharge").val();
		var total = quantity * price + parseInt(freight);
		$(this).parent().siblings(".total").html(total.toFixed(2));
		if(surcharge == ''){
			var alltotal = 0;
		}else{
			var alltotal = parseInt(surcharge);
		}
		var allquantity = 0;
		for(i=0;i<$('.maindata').length;i++){
			alltotal = alltotal + Number($('.maindata').eq(i).find('.total').text());
			allquantity = allquantity + Number($('.maindata').eq(i).find("input[name='count[]']").val())
		}
			$('#skuTotalFee').html(alltotal);
			$('#skuTotalQuantity').html(allquantity);
		})
	});

	$("input[name='price[]']").livequery(function(){
		$(this)
		.css("ime-mode", "disabled")
		.keypress(function(){
			if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
				event.returnValue=false;
			}
		})
		.keyup(function(){
			var quantity = $(this).parent().siblings().children("input[name='count[]']").val();
			var freight = $(this).parent().siblings().children("input[name='freight[]']").val();
		if(freight == ''){
			freight = 0;
		}
		var price = $(this).val();
		var surcharge = $("#surcharge").val();
		var total = quantity * price + parseInt(freight);
		$(this).parent().siblings(".total").html(total.toFixed(2));
		if(surcharge == ''){
			var alltotal = 0;
		}else{
			var alltotal = parseInt(surcharge);
		}
		var allquantity = 0;
		for(i=0;i<$('.maindata').length;i++){
			alltotal = alltotal + Number($('.maindata').eq(i).find('.total').text());
			allquantity = allquantity + Number($('.maindata').eq(i).find("input[name='count[]']").val())
		}
			$('#skuTotalFee').html(alltotal);
			$('#skuTotalQuantity').html(allquantity);
		})
	});

	$("input[name='freight[]']").livequery(function(){
		$(this)
		.css("ime-mode", "disabled")
		.keypress(function(){
			if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
				event.returnValue=false;
			}
		})
		.keyup(function(){
		var quantity = $(this).parent().siblings().children("input[name='count[]']").val();
		var price = $(this).parent().siblings().children("input[name='price[]']").val();

		var freight = $(this).val();
		if(freight == ''){
			freight = 0;
		}
		var surcharge = $("#surcharge").val();
		var total = quantity * price + parseInt(freight);
		$(this).parent().siblings(".total").html(total.toFixed(2));
		if(surcharge == ''){
			var alltotal = 0;
		}else{
			var alltotal = parseInt(surcharge);
		}
		var allquantity = 0;
		for(i=0;i<$('.maindata').length;i++){
			alltotal = alltotal + Number($('.maindata').eq(i).find('.total').text());
			allquantity = allquantity + Number($('.maindata').eq(i).find("input[name='count[]']").val())
		}
			$('#skuTotalFee').html(alltotal);
			$('#skuTotalQuantity').html(allquantity);
		})
	});

	$("#surcharge").livequery(function(){
		$(this)
		.css("ime-mode", "disabled")
		.keypress(function(){
			if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
				event.returnValue=false;
			}
		})
		.keyup(function(){
			var surcharge = $("#surcharge").val();
			if(surcharge == ''){
				var alltotal = 0;
			}else{
				var alltotal = parseInt(surcharge);
			}
			var allquantity = 0;
			for(i=0;i<$('.maindata').length;i++){
				alltotal = alltotal + Number($('.maindata').eq(i).find('.total').text());
				allquantity = allquantity + Number($('.maindata').eq(i).find("input[name='count[]']").val())
			}
			$('#skuTotalFee').html(alltotal);
			$('#skuTotalQuantity').html(allquantity);
		})
	});
@endsection
