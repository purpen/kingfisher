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
			<div id="warning" class="alert alert-danger" role="alert" style="display: none">
				<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong id="showtext"></strong>
			</div>
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
										<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
										<div class="row">
											<div class="col-md-2 lh-34 pr-0 mr-r">
												<div class="m-56">平台名称</div>
											</div>
											<div class="col-md-8 pl-4r">
												<div class="form-inline">
													<div class="form-group mb-0">
														<select class="selectpicker" id="platform" style="display: none;">
															<option value="1">淘宝平台</option>
															<option value="2">京东平台</option>
															<option value="3">自营平台</option>
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
												<input type="text" name="name" id="name" ordertype="discountFee" class="form-control float" placeholder="店铺名称">
											</div>
										</div>
									</form>
									
					            </div>
					            <div class="modal-footer">
		                    		<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		                    		<button id="submit_store" type="submit" class="btn btn-magenta">立即授权</button>
		                		</div>
					        </div>
					    </div>
					</div>
				</div>
				@foreach( $stores as $store)
				<div class="col-md-4 mb-4r" id="{{ $store->id }}">
					<div class="shopblock">
						<h4>
							<div class="form-inline mb-4r">
								<div class="form-group">
									<label class="Editname" class="mb-0">{{ $store->name }}</label>
								</div>
								<div class="form-group pull-right Editmsg">
									<a class="operate-update-offlineEshop">
										<span class="glyphicon glyphicon-pencil" style="font-size: 14px"></span>
									</a>
								</div>
							</div>
						</h4>
						<div class="showmsg" style="display: block;">
	                        <div class="lh-34">
	                        	<lable class="w-60">联系人:</lable>
	                        	<span class="ml-2r">{{ $store->contact_user }}</span>
	                        </div>
	                        <div class="lh-34">
	                        	<lable class="w-60">联系电话:</lable>
	                        	<span class="ml-2r">{{ $store->contact_number }}</span>
	                        </div>
							<div class="lh-34">
								<lable class="w-60">授权失效时间:</lable>
								<span class="ml-2r">{{ $store->authorize_overtime }}</span>
							</div>
	                    </div>
	                    <div class="editmsg" style="display: none;">
	                        <div class="lh-34">
	                        	<lable class="w-60">联系人:</lable>
	                        	<input class="form-control ml-2r form-shop" type="text" id="contact_user{{ $store->id }}" placeholder="{{ $store->contact_user }}" value="{{ $store->contact_user }}">
	                        </div>
	                        <div class="lh-34">
	                        	<lable class="w-60">联系电话:</lable>
	                        	<input class="form-control ml-2r form-shop" type="text" id="contact_number{{ $store->id }}" placeholder="{{ $store->contact_number }}" value="{{ $store->contact_number }}">
	                        </div>
	                    </div>


					</div>
				</div>
				@endforeach
			</div>

		</div>


	</div>
@endsection

@section('customize_js');
@parent
{{--<script>--}}
	var _token = $("#_token").val();
	@foreach($stores as $store)
	$('#{{$store->id}} .Editmsg').click(function(){
		$('#{{$store->id}} .showmsg').css('display','none');
		$('#{{$store->id}} .editmsg').css('display','block');
		$('#{{$store->id}} .Editmsg').html('<a href="#" class="save-shopmsg" onclick="update({{$store->id}})" style="font-size: 14px;">保存</a>');
		$('#{{$store->id}} .Editname').html('<input class="form-control form-shop" id="up{{$store->id}}" type="text" placeholder="{{ $store->name }}" value="{{ $store->name }}">');
	});
	@endforeach
	$("#submit_store").click(function () {
		var platform = $("#platform").val();
		var name = $("#name").val();
		$.ajax({
			type: 'post',
			url: '/store/store',
			data: {"_token": _token, "name": name, "platform": platform},
			dataType: 'json',
			success: function(data){
				$('#addShop').modal('hide');
				if (data.status == 1){
					window.location.href=data.data;
				}
				if (data.status == 0){
					$('#showtext').html(data.message);
					$('#warning').show();
				}
			},
			error: function(data){
				$('#addShop').modal('hide');
				var messages = eval("("+data.responseText+")");
				for(i in messages){
					var message = messages[i][0];
					break;
				}
				$('#showtext').html(message);
				$('#warning').show();
			}
		});
	});

	function update(id) {
		var name = $("#up"+id).val();
		var contact_user = $("#contact_user"+id).val();
		var contact_number = $("#contact_number"+id).val();
		$.ajax({
			type: 'post',
			url: '/store/update',
			data: {"_token": _token, "name": name,"id":id,"contact_user":contact_user, "contact_number":contact_number},
			dataType: 'json',
			success: function(data){
				if (data.status == 1){
					location.reload();
				}
				if (data.status == 0){
					$('#showtext').html(data.message);
					$('#warning').show();
				}
			},
			error: function(data){
				var messages = eval("("+data.responseText+")");
				for(i in messages){
					var message = messages[i][0];
					break;
				}
				$('#showtext').html(message);
				$('#warning').show();
			}
		});
	}
@endsection