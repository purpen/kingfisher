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
			<div class="row">
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
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">状态</a>
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
                                        <span class="title">状态</span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">状态</a>
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
                            <th>店铺名</th>
                            <th>买家</th>
                            <th>订单号/下单时间</th>
                            <th>买家备注</th>
                            <th>地址</th>
                            <th>物流/运单号</th>
                            <th>物流</th>
                            <th>数量</th>
                            <th>实付/运费</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
			</div>
		</div>
	</div>

@endsection
@section('customize_js')
    @parent
    {{--<script>--}}
    var liname = $('li[role=lichoose]');
    liname.click(function(){
        var htmltitle = $(this).find('a').text();
        $(this).parent().siblings().find('.title').html(htmltitle);
        //$(this).parent().find('li[role=lichoose]:eq(0)').before('<li role="lichoose"><a role="menuitem" tabindex="-1" href="javascript:void(0);">提醒</a></li><li class="divider"></li>')
    });
    {{--</script>--}}
@endsection