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
							<select class="selectpicker" name="supplier_id" style="display: none;">
								<option value="">选择供应商</option>
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
                        <button type="button" class="btn btn-magenta" data-toggle="modal" data-target="#addpurchase">
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
											<input name="q" value="" type="text" placeholder="请输入SKU编码/商品名称" class="form-control">
											<span class="input-group-btn">
                  								<button class="btn btn-magenta query" type="button"><span class="glyphicon glyphicon-search"></span></button>
                  							</span>
										</div>
										<div class="mt-4r scrollt">
											<table class="table table-bordered table-striped">
												<thead>
								                    <tr class="gblack">
								                    	<th class="text-center"><input type="checkbox" id="checkAll"></th>
								                        <th>商品图</th>
								                        <th>SKU编码</th>
								                        <th>商品名称</th>
								                        <th>属性</th>
								                        <th>库存</th>
								                    </tr>
								                </thead>
								                <tbody>
													<tr>
														{{-- 未选中 active == '0' --}}
														<td class="text-center"><input name="Order" type="checkbox" active="0"></td>
														<td><img src="http://ht-goods.oss-cn-hangzhou.aliyuncs.com/29988/1463743132454Hiking-And-Trekking.jpg" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
														<td>12121</td>
														<td>自行车</td>
														<td>自行车</td>
														<td>0</td>
													</tr>
													<tr>
														{{-- 未选中 active == '0' --}}
														<td class="text-center"><input name="Order" type="checkbox" active="0"></td>
														<td><img src="http://ht-goods.oss-cn-hangzhou.aliyuncs.com/29988/1463743132454Hiking-And-Trekking.jpg" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
														<td>12121</td>
														<td>自行车</td>
														<td>自行车</td>
														<td>0</td>
													</tr>
							                    </tbody>
											</table>
										</div>
										<div class="form-group mb-0 sublock">
											<div class="modal-footer pb-r">
												<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
												<button type="button" class="btn btn-magenta">确定</button>
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
				<div class="well well-lg textc mlr-3r mt-r">
					请添加采购商品
				</div>
				<div class="form-horizontal">
					<div class="form-group mlr-0">
						<div class="lh-34 m-56 ml-3r fl">备注</div>
						<div class="col-sm-5 pl-0">
							<textarea rows="3" class="form-control" name="memo" id="memo"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-4r pt-2r">
				<button type="submit" class="btn btn-magenta mr-r save">保存</button>
				<button type="button" class="btn btn-white cancel once">取消</button>
			</div>
		</form>
	</div>
@endsection

@section('customize_js')
    @parent
	$("#checkAll").click(function () {
        $("input[name='Order']:checkbox").prop("checked", this.checked);
    });
    $('.scrollt tbody tr').click(function(){
    	if( $(this).find("input[name='Order']").attr('active') == 0 ){
    		$(this).find("input[name='Order']").prop("checked", "checked").attr('active','1');
    	}else{
    		$(this).find("input[name='Order']").prop("checked", "").attr('active','0');
    	}
    })
@endsection