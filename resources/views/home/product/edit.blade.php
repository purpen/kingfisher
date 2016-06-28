@extends('home.base')

@section('title', 'console')
@section('partial_css')
	@parent

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
		<form id="addproduct" role="form">
			<div class="row mb-0 ui white pt-3r pb-2r">
				<div class="col-md-12">
					<h5>商品分类</h5>
				</div>
			</div>
			<div class="row ui white pb-4r">
				<div class="col-md-8">
					<div class="form-inline">
						<div class="form-group">请选择商品分类：</div>
						<div class="form-group">{{--
							<select class="selectpicker" id="orderType" name="category_id" style="display: none;">
                                <option value="0">未分类</option>
                             @foreach($lists as $list)
								<option value="{{ $list->id }}">{{ $list->title }}</option>
                            @endforeach
							</select>--}}
						</div>
					</div>
				</div>
			</div>
            <input type="hidden" value="random">{{----}}
			<div class="row mb-0 pt-3r pb-2r ui white">
				<div class="col-md-12">
					<h5>基本信息</h5>
				</div>
			</div>
			<div class="row mb-0 pb-4r ui white">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">货号：</div>
						<div class="form-group">
							<input type="text" name="number" ordertype="b2cCode" class="form-control" id="b2cCode">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">商品名称：</div>
						<div class="form-group">
							<input type="text" name="name" ordertype="b2cCode" class="form-control" id="b2cCode">
						</div>
					</div>
				</div>
			</div>
			<div class="row pb-4r ui white">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">标准售价(元)：</div>
						<div class="form-group">
							<input type="text" name="sale_price" ordertype="b2cCode" class="form-control" id="b2cCode">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92">重量(kg)：</div>
						<div class="form-group">
							<input type="text" name="weight" ordertype="b2cCode" class="form-control" id="b2cCode">
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
				<div class="col-md-2 mb-3r">
					<img src="" style="width: 100px;height: 100px;" class="img-thumbnail">
					<a class="removeimg">删除</a>
				</div>
				<div class="col-md-2 mb-3r">
					<div id="picForm" enctype="multipart/form-data">
						<input  type="file" name="picUrl" placeholder="添加本地图片" class="form-control">
						<div class="img-add">
							<span class="glyphicon glyphicon-plus f46"></span>
							<p>添加图片</p>
						</div>
					</div>
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
            <div class="row pb-4r ui white">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th>序号</th>
                            <th>SKU编码</th>
                            <th>售价</th>
                            <th>重量(kg)</th>
                            <th>颜色/型号</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                               123123123
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                红色
                            </td>
                            <td>
                            	<a  class="mr-r">删除</a>
                            	<a  data-toggle="modal" data-target="#appendskuModal">修改</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            

			<div class="row mt-4r pt-2r">
				<button type="submit" class="btn btn-magenta mr-r save">保存</button>
				<button type="button" class="btn btn-white cancel once">取消</button>
			</div>
		</form>
		
		{{--  添加SKU --}}
            <div class="modal fade" id="appendskuModal" tabindex="-1" role="dialog"
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
		                	<form id="addsku">
								<div class="row">
									<div class="col-md-6 lh-34">
										<div class="form-inline">
											<div class="form-group m-56">sku编码</div>
											<div class="form-group">
												<input type="text" name=" " class="form-control float" id=" " placeholder=" ">
											</div>
										</div>
									</div>
									<div class="col-md-6 lh-34">
										<div class="form-inline">
											<div class="form-group m-56 mr-r">售价</div>
											<div class="form-group">
												<input type="text" name=" " class="form-control float" id=" " placeholder=" ">
											</div>
										</div>
									</div>
								</div>
								<div class="row mb-2r">
									<div class="col-md-6 lh-34">
										<div class="form-inline">
											<div class="form-group m-56">重量</div>
											<div class="form-group">
												<input type="text" name=" " class="form-control float" id=" " placeholder=" ">
											</div>
										</div>
									</div>
									<div class="col-md-6 lh-34">
										<div class="form-inline">
											<div class="form-group m-56">颜色/型号</div>
											<div class="form-group">
												<input type="text" name=" " class="form-control float" id=" " placeholder=" ">
											</div>
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

@endsection
@section('customize_js')
    @parent
	
	
@endsection