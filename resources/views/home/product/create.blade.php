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
	.nav-tab>li{
		float:left;
	}
	.nav-tab li.active{
		background-color: #eee;
	}
	#picForm{
		position:relative;
	}
	#picForm .form-control{
		top: 0;
	    left: 0;
	    position: absolute;
	    opacity:0;
	}
	#picForm .filename{
		width: 100%;
	    height: 34px;
	    padding: 6px 12px;
	    background-color: #fff;
	    background-image: none;
	    border: 1px solid #ccc;
	    border-radius: 4px;
	    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
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
						添加商品
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
						<div class="form-group">
							<select class="selectpicker" id="orderType" name="category_id" style="display: none;">
                                <option value="0">未分类</option>
                            @foreach($lists as $list)
								<option value="{{ $list->id }}">{{ $list->title }}</option>
                            @endforeach
							</select>
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
			<div class="row mb-2r addcol pb-4r ui white">
				<div class="col-md-2 mb-3r">
					<img src="" style="width: 100px;height: 100px;" class="img-thumbnail">
					<a class="removeimg">删除</a>
				</div>
				<div class="col-md-2 mb-3r">
					<a data-toggle="modal" data-target="#addimg" style="text-decoration: none;">
						<div class="img-add">
							<span class="glyphicon glyphicon-plus f46"></span>
							<p>添加图片</p>
						</div>
					</a>
					<div class="modal fade" id="addimg" tabindex="-1" role="dialog" aria-labelledby="addimgLabel">
						<div class="modal-dialog modal-zm" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="gridSystemModalLabel">添加图片</h4>
								</div>
								<div class="modal-body">
									<ul class="nav nav-tab" role="tablist">
										<li class="active">
											<a data-target="#one" role="tab" data-toggle="tab">网络图片地址</a>
										</li>
										<li>
								            <a data-target="#two" role="tab" data-toggle="tab">
								            <span class="glyphicon glyphicon-link"></span> 添加本地图片</a>
								        </li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="one">
											<div class="mt-3r">
												<input type="text" name="picUrl" placeholder="请输入网络图片地址" class="form-control">
											</div>
										</div>
										<div class="tab-pane" id="two">
											<div class="mt-3r">
												<div id="picForm" enctype="multipart/form-data">
									                <input  type="file" name="picUrl" placeholder="添加本地图片" class="form-control">
									                <div class="filename">
									                	点击选择文件
									                </div>
									            </div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
									<button id="addpicUrl" type="button" class="btn btn-magenta">确定</button>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="Modalerror" tabindex="-1" role="dialog" aria-labelledby="ModalerrorLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-body">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<div class="bootbox-body">请上传本地图片或输入网络图片地址</div>
								</div>
								<div class="modal-footer">
									<button data-dismiss="modal" type="button" class="btn btn-magenta">OK</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

            <div class="row mb-2r">
                <div class="col-md-12">
                    <h5>
                        SKU信息
                        <a id="appendsku">
                            <span class="glyphicon glyphicon-plus f46"></span> 添加SKU
                        </a>
                    </h5>
                </div>
            </div>
            <div class="row mb-2r">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th class="m-56"></th>
                            <th>序号</th>
                            <th>SKU编码</th>
                            <th>售价</th>
                            <th>重量(kg)</th>
                            <th>颜色/型号</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="m-56"></td>
                            <td>1</td>
                            <td>
                                <input type="text" class="form-control" name="number" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sale_price" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="skucod" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="mode" value="">
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
		



	</div>
	
@endsection
@section('partial_js')
	@parent

@endsection
@section('customize_js')
    @parent
    $('#picForm input[type=file]').change(function(){
		var filebtnn = $('#picForm input[type=file]').val();
		var pos = filebtnn.lastIndexOf("\\");
		var filename = filebtnn.substring(pos+1); 
		$('#picForm .filename').html(filename);
    });
	$('#addpicUrl').click(function(){
		if( $('#picForm .form-control').val() == '' && $('.tab-pane input[type=text]').val() == '' ){
			$('#Modalerror').modal('show');
		}
		else{
			$('.addcol').prepend('<div class="col-md-2 mb-3r"><img src="" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg">删除</a></div>');
			$('#addimg').modal('hide');
		}
	})
	
	
@endsection