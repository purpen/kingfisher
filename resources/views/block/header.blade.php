<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        
        <div class="navbar-header">
            <!-- Branding Image -->
            <a class="navbar-brand logo" href="{{ url('/') }}">
                <img id="logo" src="{{ url('images/logo.png') }}" class="img-responsive" alt="logo" title="logo">
            </a>
        </div>

        <div class="navbar-collapse collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown"><a href="{{ url('/home') }}">首页</a></li>
                @role(['servicer', 'shopkeeper', 'director', 'admin'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">客服
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="{{url('/order')}}">订单查询</a></li>
                        <li><a href="{{url('/order/nonOrderList')}}">待付款订单</a></li>
                        <li><a href="{{url('/refund')}}">退款售后</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="{{ url('/product') }}">商品列表</a></li>
                    </ul>
                </li>
                @endrole

                @role(['servicer', 'shopkeeper', 'director', 'admin'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">订单
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <li><a href="{{ url('/order/verifyOrderList') }}">审单</a></li>
                        <li><a href="{{ url('/order/reversedOrderList') }}">返审</a></li>
                        <li><a href="{{ url('/order/sendOrderList') }}">打单发货</a></li>
                        <li><a href="{{ url('/article') }}">验货</a></li>
                        <li><a href="{{ url('/article') }}">称重</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="{{ url('/product') }}">商品列表</a></li>
                    </ul>
                </li>
                @endrole

                @role(['storekeeper','shopkeeper','admin'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">库管
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                        <li><a href="{{url('/enterWarehouse')}}">入库单</a></li>
                        <li><a href="{{url('/outWarehouse')}}">出库单</a></li>
                        <li><a href="{{url('/changeWarehouse')}}">调拨单</a></li>
                        <li><a href="">盘点单</a></li>
                        <li><a href="{{url('/storageSkuCount/list')}}">库存监控</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="{{ url('/logistics') }}">物流管理</a></li>
                        <li><a href="{{url('/storageSkuCount/productCount')}}">仓库管理</a></li>
                    </ul>
                </li>
                @endrole

                @role(['buyer','admin','marketer','director'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">采购
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
                        <li><a href="{{ url('/purchase') }}">采购单</a></li>
                        <li><a href="{{ url('/returned') }}">采购退货单</a></li>
                        <li><a href="{{ url('/storageSkuCount/list') }}">库存监控</a></li>
                        <li><a href="{{ url('/storageSkuCount/storageCost') }}">库存成本</a></li>
                        <li><a href="{{ url('/product') }}">商品列表</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="{{ url('/supplier') }}">供应商信息</a></li>
                    </ul>
                </li>
                @endrole

                @role(['buyer', 'director', 'shopkeeper', 'admin','marketer'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">运营
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu5">
                        <li><a href="{{ url('/product') }}">商品列表</a></li>
                        <li><a href="">库存同步</a></li>
                        <li><a href="">赠品策略</a></li>
                        <li><a href="{{url('/order')}}">订单查询</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="{{ url('/supplier') }}">供应商信息</a></li>
                    </ul>
                </li>
                @endrole

                @role(['financer','admin'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">财务
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu6">
                        <li><a href="{{url('/receive')}}">收款</a></li>
                        <li><a href="{{url('/payment')}}">付款</a></li>
                        <li><a href="{{ url('/storageSkuCount/storageCost') }}">库存成本</a></li>
                        <li><a href="{{url('/order')}}">订单查询</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="{{url('/paymentAccount')}}">财务资料</a></li>
                    </ul>
                </li>
                @endrole

                @role(['admin'])
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu6">
                        <li><a href="{{url('/user')}}">用户管理</a></li>
                        <li><a href="{{url('/role')}}">角色管理</a></li>
                        <li><a href="{{url('/permission')}}">权限管理</a></li>
                        <li><a href="{{url('/rolePermission')}}">分配权限</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="{{url('/category')}}">分类管理</a></li>
                        <li><a href="{{url('/chinaCity')}}">城市管理</a></li>
                        <li><a href="{{url('/record')}}">日志管理</a></li>
                        <li><a href="{{url('/positiveEnergy')}}">短语管理</a></li>
                        <li><a href="{{url('/store')}}">店铺管理</a></li>
                    </ul>
                </li>
                @endrole

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right mr-0">

                <!-- Authentication Links -->
                @if (Auth::guest())
                   <li class="dropdown">
                        <a href="{{ url('/login') }}" class="transparent btn-magenta btn"> 登录</a>
                        <a href="{{ url('/register') }}" class="transparent btn-magenta btn"> 注册</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-bell"></span>
                        </a>
                        <ul class="dropdown-menu mr-r" aria-labelledby="dropdownMenu7">
                            <li>
                                <div class="ptb-4r plr-4r">
                                    暂时没有新的提醒哦 ...
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->account}}
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user img-circle" src="{{ Auth::user()->cover ?  Auth::user()->cover->file->small : url('images/default/headportrait.jpg') }}" align="absmiddle">
                            <span class="glyphicon glyphicon-menu-down"></span>
                        </a>
                        <ul class="dropdown-menu mr-3r" aria-labelledby="dropdownMenu8">
                            <li><a href="{{ url('/user/edit') }}">个人资料</a></li>
                            <li><a href="{{url('/logout')}}">退出</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</nav>

