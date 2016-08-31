@extends('home.base')

@section('title', 'console')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
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
		font-size:30px;
	}
	#picForm{
		position:relative;
		color: #f36;
	    height: 100px;
	    text-decoration: none;
	    width: 100px;
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
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <h3 style="color: #9c0033">{{ $error }}</h3>
                    @endforeach
        @endif
		<form id="add-product" role="form" method="post" action="{{ url('/product/update') }}">
			<div class="row mb-0 ui white pt-3r pb-2r">
				<div class="col-md-12">
					<h5>商品分类</h5>
				</div>
			</div>
			<div class="row ui white pb-4r">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group">请选择商品分类：</div>
						<div class="form-group">
							<select class="selectpicker" id="orderType" name="category_id" style="display: none;">
                                <option value="0">未分类</option>
                             @foreach($lists as $list)
								<option value="{{ $list->id }}" {{ $product->category_id == $list->id?'selected':'' }}>{{ $list->title }}</option>
                            @endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group">请选择供应商：</div>
						<div class="form-group">
							<select class="selectpicker" id="orderType" name="supplier_id" style="display: none;">
								<option value="">选择供应商</option>
								@foreach($suppliers as $supplier)
									<option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id?'selected':'' }}>{{ $supplier->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-0 pt-3r pb-2r ui white">
				<div class="col-md-12">
					<h5>基本信息</h5>
				</div>
			</div>
			<div class="row mb-0 pb-4r ui white">
                {{ csrf_field() }}{{--token--}}
				<input type="hidden" name="product_id" value="{{ $product->id }}">
				<input type="hidden" name="url" value="{{ $url }}">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">货号：</div>
						<div class="form-group">
							<input type="text" name="number" ordertype="b2cCode" class="form-control" id="b2cCode" value="{{ $product->number }}">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">商品名称：</div>
						<div class="form-group">
							<input type="text" name="title" ordertype="b2cCode" class="form-control" id="b2cCode" value="{{ $product->title }}">
						</div>
					</div>
				</div>
			</div>
            <div class="row mb-0 pb-4r ui white">
                <div class="col-md-4">
                    <div class="form-inline">
                        <div class="form-group m-92">标准进价：</div>
                        <div class="form-group">
                            <input type="text" name="market_price" ordertype="b2cCode" class="form-control" id="b2cCode" value="{{ $product->market_price }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-inline">
                        <div class="form-group m-92">成本价：</div>
                        <div class="form-group">
                            <input type="text" name="cost_price" ordertype="b2cCode" class="form-control" id="b2cCode" value="{{ $product->cost_price }}">
                        </div>
                    </div>
                </div>
            </div>
			<div class="row pb-4r ui white">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">售价(元)：</div>
						<div class="form-group">
							<input type="text" name="sale_price" ordertype="b2cCode" class="form-control" id="b2cCode" value="{{ $product->sale_price }}">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">重量(kg)：</div>
						<div class="form-group">
							<input type="text" name="weight" ordertype="b2cCode" class="form-control" id="b2cCode" value="{{ $product->weight }}">
						</div>
					</div>
				</div>
			</div>
            <div class="row pb-4r ui white">
                <div class="col-md-4">
                    <div class="form-inline">
                        <div class="form-group m-92">备注：</div>
                        <div class="form-group">
                            <input type="text" name="summary" ordertype="b2cCode" class="form-control" id="b2cCode" value="{{ $product->summary }}">
                        </div>
                    </div>
                </div>
            </div>
			<div class="row mb-0 pt-3r pb-2r ui white">
				<div class="col-md-12">
					<h5>商品图片</h5>
				</div>
			</div>
			<div class="row addcol pb-4r ui white">
				@foreach($assets as $asset)
					<div class="col-md-2 mb-3r">
						<img src="{{ $asset->path }}" style="width: 100px;height: 100px;" class="img-thumbnail">
						<a class="removeimg" value="{{ $asset->id }}">删除</a>
					</div>
				@endforeach
					<div class="col-md-2 mb-3r">
						<div id="picForm" enctype="multipart/form-data">
							<div class="img-add">
								<span class="glyphicon glyphicon-plus f46"></span>
								<p>添加图片</p>
								<div id="fine-uploader"></div>
							</div>
						</div>
                        <input type="hidden" id="cover_id" name="cover_id">
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
			</div>
			 
            <div class="row mb-0 pt-3r pb-2r ui white">
                <div class="col-md-12">
                    <h5>
                        SKU信息
                        <a id="appendsku" data-toggle="modal" data-target="#appendskuModal">
                            <span class="glyphicon glyphicon-plus f46"></span> 添加SKU
                        </a>

                    </h5>
                </div>
            </div>
            @if(isset($skus))
            <div class="row pb-4r ui white">
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
                        @foreach($skus as $sku)
                        <tr class=".tr">
                            <td>{{ $sku->id }}</td>
                            <td>
                                <img src="{{ $sku->path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;">
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
                            	<a  class="mr-r" onclick="destroySku({{ $sku->id }})">删除</a>
                            	<a  data-toggle="modal" onclick="editSku({{ $sku->id }})">修改</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            

			<div class="row mt-4r pt-2r">
				<button type="submit" class="btn btn-magenta mr-r save">保存</button>
				<button type="button" class="btn btn-white cancel once">取消</button>
			</div>
		</form>
		
		{{--  添加SKU --}}
            <div class="modal fade bs-example-modal-lg" id="appendskuModal" tabindex="-1" role="dialog"
         aria-labelledby="appendskuLabel" aria-hidden="true">
				<div class="modal-dialog">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close"
		                            data-dismiss="modal" aria-hidden="true">
		                        &times;
		                    </button>
		                    <h4 class="modal-title" id="myModalLabel">
		                        添加SKU
		                    </h4>
		                </div>
		                <div class="modal-body">
		                	<form id="addsku" method="post" action="{{ url('/productsSku/store') }}">
                                {{ csrf_field() }}{{--token--}}
                                <input type="hidden" name="random" id="create_sku_random" value="{{ $random[0] }}">{{--图片上传回调随机数--}}
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
								<input type="hidden" name="name" value="{{ $product->title }}">
                                <div class="row mb-2r">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56">SKU编码</div>
                                            <div class="form-group">
                                                <input type="text" name="number" class="form-control float" id=" " placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56 mr-r">售价</div>
                                            <div class="form-group">
                                                <input type="text" name="price" class="form-control float" id=" " placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2r">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56 mr-r">标准进价</div>
                                            <div class="form-group">
                                                <input type="text" name="bid_price" class="form-control float" id=" " placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56">成本价</div>
                                            <div class="form-group">
                                                <input type="text" name="cost_price" class="form-control float" id=" " placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2r">
									<div class="col-md-6 lh-34">
										<div class="form-inline">
											<div class="form-group m-56">颜色/型号</div>
											<div class="form-group">
												<input type="text" name="mode" class="form-control float" id=" " placeholder=" ">
											</div>
										</div>
									</div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56 mr-r">重量(kg)</div>
                                            <div class="form-group">
                                                <input type="text" name="weight" class="form-control float" id=" " placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
								</div>
                                <div class="row mb-2r">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56">备注</div>
                                            <div class="form-group">
                                                <input type="text" name="summary" class="form-control float" id=" " placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2r sku-pic">
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

        {{--  更改SKU --}}
        <div class="modal fade" id="updateskuModal" tabindex="-1" role="dialog"
             aria-labelledby="appendskuLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            更改SKU
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="upsku" method="post" action="{{ url('/productsSku/update') }}">
                            {{ csrf_field() }}{{--token--}}
                            <input type="hidden" name="random" id="update_sku_random" value="{{ $random[1] }}">{{--图片上传回调随机数--}}
                            <input type="hidden" name="id" id="sku-id" value="">
                            <div class="row">
                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group m-56 mr-r">sku编码</div>
                                        <div class="form-group">
                                            <input type="text" name="number" class="form-control float" id="up-number" placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group m-56 mr-r">售价</div>
                                        <div class="form-group fz-0">
                                            <input type="text" name="price" class="form-control float" id="up-price" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2r">
                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group m-56 mr-r">标准进价</div>
                                        <div class="form-group fz-0">
                                            <input type="text" name="bid_price" class="form-control float" id="up-bid-price" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group m-56 mr-r">成本价</div>
                                        <div class="form-group">
                                            <input type="text" name="cost_price" class="form-control float" id="up-cost-price" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2r">

                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group m-56 mr-r">颜色/型号</div>
                                        <div class="form-group">
                                            <input type="text" name="mode" class="form-control float" id="up-mode" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group m-56 mr-r">重量(kg)</div>
                                        <div class="form-group fz-0">
                                            <input type="text" name="weight" class="form-control float" id="up-weight" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2r">
                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group m-56 mr-r">备注</div>
                                        <div class="form-group fz-0">
                                            <input type="text" name="summary" class="form-control float" id="up-summary" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-4r ui white">
                                <div id="update-sku-pic"></div>
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
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection
@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
@endsection
@section('customize_js')
    @parent
    {{--<script>--}}
    var _token = $('#_token').val();
    {{--获取sku信息--}}
    function editSku(id) {
        $.get('{{ url('/productsSku/ajaxEdit') }}',{'id':id},function (e) {
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
            $('#update-sku-pic').html(views);

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

	$(document).ready(function() {
		new qq.FineUploader({
			element: document.getElementById('fine-uploader'),
			autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
			// 远程请求地址（相对或者绝对地址）
			request: {
				endpoint: 'http://upload.qiniu.com/',
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
			//回调函数
			callbacks: {
				//上传完成后
				onComplete: function(id, fileName, responseJSON) {
					if (responseJSON.success) {
						console.log(responseJSON.success);
						$('.addcol').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
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
				}
			}
		});
	});

    $(document).ready(function() {
        new qq.FineUploader({
            element: document.getElementById('add-sku-uploader'),
            autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
            // 远程请求地址（相对或者绝对地址）
            request: {
                endpoint: 'http://upload.qiniu.com/',
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
                        $('.sku-pic').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
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
                }
            }
        });
    });

    $(document).ready(function() {
        new qq.FineUploader({
            element: document.getElementById('update-sku-uploader'),
            autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
            // 远程请求地址（相对或者绝对地址）
            request: {
                endpoint: 'http://upload.qiniu.com/',
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
                        $('#update-sku-pic').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
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
                }
            }
        });
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

@endsection