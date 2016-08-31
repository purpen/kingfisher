@extends('home.base')

@section('title', '商品')
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
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						仓库商品
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		<div class="row">
			{{--<div class="col-md-2 p-0 m-0 classify" style="height: 580px;">
				<h5 class="ui dividing header"> 
					商品分类
				</h5>
				<div class="plr-3r ptb-r">
					<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addclass">新增分类</button>
					<div class="modal fade" id="addclass" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
						<div class="modal-dialog modal-zm" role="document">
							<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="gridSystemModalLabel">新增分类</h4>
								</div>
								<div class="modal-body">
									<form id="addclassify" class="form-horizontal" role="form" method="POST" action="{{ url('/category/store') }}">
										{!! csrf_field() !!}
										<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
											<label for="title" class="col-sm-2 control-label p-0 lh-34 m-56">分类名</label>
											<div class="col-sm-8">
												<input type="text" name="title" class="form-control float" id="title" placeholder="输入分类名"  value="{{ old('title') }}">
												@if ($errors->has('title'))
													<span class="help-block">
														<strong>{{ $errors->first('title') }}</strong>
													</span>
												@endif
											</div>
										</div>
										<div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
											<label for="order" class="col-sm-2 control-label p-0 lh-34 m-56">排序</label>
											<div class="col-sm-8">
												<input type="text" name="order" class="form-control float" id="order" placeholder="选填"  value="{{ old('order') }}">
												@if ($errors->has('order'))
													<span class="help-block">
														<strong>{{ $errors->first('order') }}</strong>
													</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label for="type" class="col-sm-2 control-label p-0 lh-34 m-56">类型</label>
											<div class="col-md-8 pl-4r ml-3r">
												<div class="form-inline">
													<div class="form-group mb-0">
														<select class="selectpicker" id="type" name="type" style="display: none;">
															<option value="1">商品</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group mb-0">
											<div class="modal-footer pb-r">
												<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
												<button type="submit" class="btn btn-magenta">确定</button>
											</div>
										</div>
									</form>
					            </div>
					        </div>
					    </div>
					</div>
				</div>
				--}}{{--<div class="panel-group" role="tablist">
					<div class="panel-heading" role="tab">
						<a class="panel-title collapsed" href="#collapseListGroup1" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseListGroup1">
							<span class="glyphicon glyphicon-triangle-bottom mr-r" aria-hidden="true"></span>全部分类
						</a>
					</div>
					<div id="collapseListGroup1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false">
						<ul class="list-group">
							@foreach($lists as $list)
							<a class="list-group-item" href="{{ $list['id'] }}">{{ $list['title'] }}</a>
                            @endforeach
						</ul>
					</div>
				</div>--}}{{--
			</div>--}}
			<div class="col-md-12 pr-0">
				<table class="table classify mb-3r">
					<thead>
						<tr>
							<th style="border:none;">
								<form class="form-inline" role="form">
									<div class="form-group">商品列表
										<span class="ml-4r">共 
											<span class="magenta-color" id="goodsTotalNum">3</span> 件商品
										</span>
									</div>
								</form>
							</th>
						</tr>
					</thead>
        		</table>
				<div class="row pl-4r mb-3r">
					<div class="form-inline">
						<div class="form-group mr-2r">
							<a href="{{ url('/product/create') }}">
								<button type="button" class="btn btn-white">
									新增
								</button>
							</a>
						</div>	
						<div class="form-group">
							<button type="button" class="btn btn-white" onclick="destroyProduct()">
								删除
							</button>
						</div>
						<div class="navbar-right mr-0">
							<form class="navbar-form navbar-left m-0" role="search" id="search" action="{{ url('/product/search') }}" method="POST">
	                            <div class="form-group">
	                                <input type="text" name="name" class="form-control" placeholder="请输入商品货号,商品名称" style="width:200px">
	                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
	                            </div>
	                            <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
	                        </form>
						</div>
					</div>
				</div>
				<div class="row pl-4r mr-0">
					<table class="table table-bordered table-striped">
	                    <thead>
	                        <tr class="gblack">
	                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
	                            <th>商品图</th>
	                            <th>商品货号</th>
	                            <th>商品名称</th>
								<th>标准进价</th>
								<th>成本价</th>
	                            <th>售价</th>
	                            <th>重量(kg)</th>
	                            <th>库存总量</th>
	                            <th>备注</th>
	                            <th>操作</th>
	                        </tr>
	                    </thead>
	                    <tbody>
							@foreach($products as $product)
								<tr class="brnone">
	                    		<td class="text-center">
	                    			<input type="checkbox" name="order" value="{{ $product->id }}">
	                    		</td>
	                    		<td>
	                    			<img src="{{ $product->path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;">
	                    		</td>
	                    		<td>
	                    			{{ $product->number }}
	                    		</td>
	                    		<td>
	                    			<span class="proname">{{ $product->title }}</span>
	                    		</td>
								<td>
									{{ $product->market_price }}
								</td>
								<td>
									{{ $product->cost_price }}
								</td>
	                    		<td>
	                    			{{ $product->sale_price }}
	                    		</td>
	                    		<td>
	                    			{{ $product->weight }}
	                    		</td>
	                    		<td>{{$product->inventory}}</td>
	                    		<td>{{$product->summary}}</td>
	                    		<td>
	                    			<a href="{{ url('/product/edit') }}?id={{$product->id}}">编辑</a>
	                    		</td>
	                    	</tr>
							@foreach($product->skus as $sku)
								<tr class="bone">
									<td class="text-center">
									</td>
									<td><img src="{{ $sku->path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
									<td>SKU编码：{{ $sku->number }}</td>
									<td></td>
									<td>属性：{{ $sku->mode }}</td>
									<td>{{ $sku->bid_price }}</td>
									<td>{{ $sku->cost_price }}</td>
									<td>{{ $sku->price }}</td>
									<td>{{ $sku->weight }}</td>
									<td>{{ $sku->quantity }}
										{{--<a name="example" tabindex="0" data-placement="left" data-content="<table>
									    <tr>
									      <td><a>北京</a></td>
									      <td width=8px;></td>
									      <td>30</td>
									    </tr>
									    <tr>
									      <td><a>上海</a></td>
									      <td width=8px;></td>
									      <td>30</td>
									    </tr>
									</table>" data-html="true" data-trigger="focus" data-toggle="popover" data-original-title="仓库信息1">
											<span class="glyphicon glyphicon-list"></span>
										</a>--}}</td>
									<td>{{ $sku->summary }}</td>
									<td><a  onclick="destroySku({{ $sku->id }})">删除</a></td>
								</tr>
							@endforeach
							@endforeach
	                    </tbody>
	                </table>
					<div class="col-md-6 col-md-offset-6">{!! $products->render() !!}</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('customize_js')
    @parent
	{{--<script>--}}
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

	function destroyProduct() {
		if(confirm('确认删除选中的商品？')){
			var order = $("input[name='order']");
			var id_json = {};
			for (var i=0;i < order.length;i++){
				if(order[i].checked == true){
					id_json[i] = order[i].value;
				}
			}
			var data = {"_token":_token,"id":id_json}
			$.post('{{ url('/product/ajaxDestroy') }}',data,function (e) {
				if(e.status == 1){
					location.reload();
				}else{
					alert(e.message);
				}
			},'json');

		}
	}

@endsection