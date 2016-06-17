@extends('home.base')

@section('title', '店铺')

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						店铺授权
					</div>
				</div>
			</div>
		</div>

		<div class="container mainwrap">
			<div class="row">
				<div class="col-md-4">
					<a data-toggle="modal" data-target="#addShop">
						<div class="text-center addshopbtn">
							<span class="glyphicon glyphicon-plus cccicon" style="font-size: 30px;"></span>
							<div>添加店铺</div>
						</div>
					</a>
					<div class="modal fade" id="addShop" tabindex="-1" role="dialog" aria-labelledby="addShopLabel">
						<div class="modal-dialog modal-zm" role="document">
							<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="gridSystemModalLabel">添加店铺</h4>
								</div>
								<div class="modal-body">
									<form id="addusername">
										<div class="row">
											<div class="col-md-2 lh-34 pr-0 mr-r">
												<div class="m-56">平台名称</div>
											</div>
											<div class="col-md-8 pl-4r">
												<div class="form-inline">
													<div class="form-group mb-0">
														<select class="selectpicker" id="orderType" style="display: none;">
															<option value=" ">太火鸟</option>
															<option value=" ">飞行雨</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-2 lh-34 pr-0 mr-r">
												<div class="m-56">店铺名称</div>
											</div>
											<div class="col-md-8 pl-4r">
												<input type="text" name="tel" ordertype="discountFee" class="form-control float" id="orderFee" placeholder="店铺名称">
											</div>
										</div>
									</form>
									
					            </div>
					            <div class="modal-footer">
		                    		<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		                    		<button id="submit_supplier" type="button" class="btn btn-magenta">立即授权</button>
		                		</div>
					        </div>
					    </div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="shopblock">
						<h4>
							<div class="form-inline mb-4r">
								<div class="form-group">
									<label id="Editname" class="mb-0">飞行鱼</label>
								</div>
								<div class="form-group pull-right" id="Editmsg">
									<a class="operate-update-offlineEshop">
										<span class="glyphicon glyphicon-pencil" style="font-size: 14px"></span>
									</a>
								</div>
							</div>
						</h4>
						<div id="showmsg" style="display: block;">
	                        <div class="lh-34">
	                        	<lable class="w-60">联系人:</lable>
	                        	<span class="ml-2r">小鱼儿</span>
	                        </div>
	                        <div class="lh-34">
	                        	<lable class="w-60">联系电话:</lable>
	                        	<span class="ml-2r">18610350752</span>
	                        </div>
	                    </div>
	                    <div id="editmsg" style="display: none;">
	                        <div class="lh-34">
	                        	<lable class="w-60">联系人:</lable>
	                        	<input class="form-control ml-2r form-shop" type="text" placeholder="小鱼儿">
	                        </div>
	                        <div class="lh-34">
	                        	<lable class="w-60">联系电话:</lable>
	                        	<input class="form-control ml-2r form-shop" type="text" placeholder="18610350752">
	                        </div>
	                    </div>


					</div>
				</div>
			</div>

		</div>


	</div>
@endsection

@section('customize_js');
@parent
	$('#Editmsg').click(function(){
		$('#showmsg').css('display','none');
		$('#editmsg').css('display','block');
		$('#Editmsg').html('<a href="" class="save-shopmsg" style="font-size: 14px;">保存</a>');
		$('#Editname').html('<input class="form-control form-shop" type="text" placeholder="飞行鱼">');
	});


@endsection