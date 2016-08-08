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
                            <td>
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
    for (var i=0; i<$(".scroll tbody tr td").length-1;i++){
        var forclick = $(".scroll tbody tr td").eq(i);
        forclick.click(function(){
            if( forclick.siblings().find("input[name='Order']").attr('active') == 0 ){
                forclick.siblings().find("input[name='Order']").prop("checked", "checked").attr('active','1');
            }else{
                forclick.siblings().find("input[name='Order']").prop("checked", "").attr('active','0');
            }
        })
    }
    
    
    

    /*var liname = $('li[role=lichoose]');
    liname.click(function(){
        var htmltitle = $(this).find('a').text();
        $(this).parent().siblings().find('.title').html(htmltitle);
    });*/
    {{--</script>--}}
@endsection