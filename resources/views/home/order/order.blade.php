@extends('home.base')

@section('title', 'console')
@section('customize_css')
    @parent
    .bnonef{
    	padding:0;
    	box-shadow:none !important; 
    	background:none;
    	color:#fff !important;
    }
    #form-user,#form-product,#form-jyi,#form-beiz {
        height: 200px;
        overflow: scroll;
    }
    .scrollspy{
        height:160px;
        overflow: scroll;
        margin-top: 10px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						订单查询
					</div>
				</div>
				<ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action=" " method="POST">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="店铺名">
                                <input type="hidden" id="_token" name="_token" value=" ">
                            </div>
                            <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row">
				<div class="form-inline">
					<div class="form-group mr-2r">
						<a href="{{ url('/order/create') }}">
							<button type="button" class="btn btn-white">
								新增订单
							</button>
						</a>
					</div>
					<div class="form-group mr-2r">
						<button type="button" class="btn btn-white">
							导出
						</button>
					</div>
					<div class="form-group mr-2r">
						<button type="button" class="btn btn-white">
							导入
						</button>
					</div>
				</div>
			</div>
			<div class="row scroll">
				<table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>
                            	<div class="dropdown">
                            		<button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                            			<span class="title">提醒</span> 
                            			<span class="caret"></span>
                    				</button>
                    				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        {{--
                                        <li role="presentation" class="sort" type="up">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                            </a>
                                        </li>
                                        <li role="presentation" class="sort" type="down">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                            </a>
                                        </li>--}}
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">提醒</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">退款</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">锁单</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">无法送达</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">货到付款</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">预售</a>
                                        </li>
                                    </ul>
                            	</div>
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">状态</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose" class="sort" type="up">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                            </a>
                                        </li>
                                        <li role="lichoose" class="sort" type="down">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">待付款</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">已付款待审核</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">已审核待发货</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">已发货</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">已取消</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">已完成</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">店铺名</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose" class="sort" type="up">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                            </a>
                                        </li>
                                        <li role="lichoose" class="sort" type="down">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">待付款</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">已付款待审核</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>订单号/下单时间</th>
                            <th>买家</th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">买家备注</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">有买家备注</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">无买家备注</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">卖家备注</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">有卖家备注</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">无卖家备注</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>地址</th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">物流/运单号</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose" class="sort" type="up">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                            </a>
                                        </li>
                                        <li role="lichoose" class="sort" type="down">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">物流</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose" class="sort" type="up">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                            </a>
                                        </li>
                                        <li role="lichoose" class="sort" type="down">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">数量</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose" class="sort" type="up">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                            </a>
                                        </li>
                                        <li role="lichoose" class="sort" type="down">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>实付/运费</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                            </td>
                            <td></td>
                            <td>已付款待审核</td>
                            <td>飞行鱼</td>
                            <td>6163312</td>
                            <td>伟哥</td>
                            <td></td>
                            <td></td>
                            <td>北京北京市朝阳区马辛店</td>
                            <td>ert</td>
                            <td>ert</td>
                            <td>3</td>
                            <td>100/20</td>
                            <td tdr="nochect">
                                <button class="btn btn-gray btn-sm mr-2r show-order" type="button" id="change_status">详情</button>
                                <a href="javascript:void(0);" class="magenta-color">删除</a>
                            </td>
                        </tr>
                        <tr class="order-list">
                            <td colspan="20">
                                <div class="btn-group ptb-2r pl-2r" data-toggle="buttons">
                                    <label class="btn btn-default active" id="label-user">
                                        <input type="radio" id="user"> 客户信息
                                    </label>
                                    <label class="btn btn-default" id="label-product">
                                        <input type="radio" id="product"> 商品信息
                                    </label>
                                    <label class="btn btn-default" id="label-jyi">
                                        <input type="radio" id="jyi"> 交易信息
                                    </label>
                                    <label class="btn btn-default" id="label-beiz" style="width: 82px;">
                                        <input type="radio" id="beiz"> 备注
                                    </label>
                                </div>
                                <form id="form-user" role="form" class="navbar-form">
                                    <div class="form-inline mtb-4r">
                                        <div class="form-group mr-2r">
                                        用户名称
                                        </div>
                                        <div style="width:106px;" class="form-group mr-4r">
                                            <input type="text" class="form-control" disabled="disabled" name="customerNickName" value="伟哥" style="width: 100%;">
                                        </div>
                                        <div class="form-group mr-2r">
                                        收货人
                                        </div>
                                        <div style="width:96px;" class="form-group mr-4r">
                                            <input validate="" showname="收货人" type="text" class="form-control order" name="receiverName" value="伟哥" style="width: 100%;">
                                        </div>
                                        <div class="form-group mr-2r">
                                        电话号
                                        </div>
                                        <div style="width:106px;" class="form-group mr-4r">
                                            <input validate="" showname="收货人" type="text" class="form-control order" name="receiverName" value="伟哥" style="width: 100%;">
                                        </div>
                                        <div class="form-group mr-2r">
                                        手机号
                                        </div>
                                        <div style="width:120px;" class="form-group mr-4r">
                                            <input type="text" class="form-control order mobile" name="receiverMobile" value="18923405430" style="width: 100%;">
                                        </div>
                                        <div class="form-group vt-34 mr-2r">物流公司</div>
                                            <div class="form-group pr-4r mr-2r">
                                                <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
                                                    <option value="">选择仓库</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline mtb-4r">
                                        <div class="form-group vt-34 mr-2r">发货仓库</div>
                                        <div class="form-group pr-4r mr-4r">
                                            <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
                                                <option value="">选择仓库</option>
                                            </select>
                                        </div>
                                        <div class="form-group mr-2r">
                                        详细地址
                                        </div>
                                        <div class="form-group mr-4r">
                                            <input type="text" class="form-control order mobile" name="receiverStreet" value="">
                                        </div>
                                    </div>
                                    <div class="form-inline mtb-4r">
                                        <div class="form-group vt-34 mr-2r">邮政编码</div>
                                        <div class="form-group pr-4r mr-4r">
                                            <input type="text" class="form-control order mobile" name="receiverStreet" value="">
                                        </div>
                                    </div>
                                </form>
                                <form id="form-product" role="form" class="navbar-form" style="display:none;">
                                    <div class="form-inline">
                                        <div class="form-group mr-2r">
                                            <a href="#" data-toggle="modal" data-target="#addproduct" id="addproduct-button">+添加商品</a>
                                            <div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <h4 class="modal-title" id="gridSystemModalLabel">添加客户</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="input-group">
                                                                <input id="search_val" type="text" placeholder="SKU编码/商品名称" class="form-control">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                </span>
                                                            </div>
                                                            <div class="mt-4r scrollt">
                                                                <div id="user-list"> 
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
                                                                                <td class="text-center">
                                                                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                                                                                </td>
                                                                                <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                                                <td>伟哥</td>
                                                                                <td>18923405430</td>
                                                                                <td>100015</td>
                                                                                <td>北京北京市朝阳区马辛店</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                                                                                </td>
                                                                                <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                                                <td>伟哥</td>
                                                                                <td>18923405430</td>
                                                                                <td>100015</td>
                                                                                <td>北京北京市朝阳区马辛店</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer pb-r">
                                                                <div class="form-group mb-0 sublock">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                                    <button type="button" id="choose-user" class="btn btn-magenta">确定</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group pull-right">
                                            <span class="mr-4r">共计<b class="magenta-color"> 5 </b>件商品，总重量 <b class="magenta-color">0.00</b> kg</span>
                                            <span class="mr-4r">商品总金额：721.00 － 订单优惠：0.00 － 商品总优惠：10.00 = 711.00</span>
                                             <span class="mr-2r">实付：<b class="magenta-color">741.00</b></span>
                                        </div>
                                    </div>
                                    <div class="scrollspy">
                                        <table class="table">
                                            <thead class="table-bordered">
                                                <tr>
                                                    <th>商品图</th>
                                                    <th>SKU编码</th>
                                                    <th>商品名称</th>
                                                    <th>属性</th>
                                                    <th>零售价</th>
                                                    <th>数量</th>
                                                    <th>优惠</th>
                                                    <th>应付</th>
                                                    <th>操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                    <td>伟哥</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td><a href="#" data-toggle="modal" data-target="#addproduct" id="addproduct-button">换货</a></td>
                                                </tr>
                                                <tr>
                                                    <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                    <td>伟哥</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td>qwe</td>
                                                    <td><a href="#" data-toggle="modal" data-target="#addproduct" id="addproduct-button">换货</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </form>
                                <form id="form-jyi" role="form" class="navbar-form" style="display:none;">

                                </form>
                                <form id="form-beiz" role="form" class="navbar-form" style="display:none;">

                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                            </td>
                            <td></td>
                            <td>已付款待审核</td>
                            <td>飞行鱼</td>
                            <td>6163312</td>
                            <td>伟哥</td>
                            <td></td>
                            <td></td>
                            <td>北京北京市朝阳区马辛店</td>
                            <td>ert</td>
                            <td>ert</td>
                            <td>3</td>
                            <td>100/20</td>
                            <td tdr="nochect">
                                <button class="btn btn-gray btn-sm mr-2r show-order" type="button" id="change_status">详情</button>
                                <a href="javascript:void(0);" class="magenta-color">删除</a>
                            </td>
                        </tr>

                    </tbody>
                </table>
			</div>
		</div>
	</div>

@endsection
@section('customize_js')
    @parent
    {{--<script>--}}
    
    /*var liname = $('li[role=lichoose]');
    liname.click(function(){
        var htmltitle = $(this).find('a').text();
        $(this).parent().siblings().find('.title').html(htmltitle);
    });*/
    {{--</script>--}}
@endsection