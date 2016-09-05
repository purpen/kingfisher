@extends('home.base')

@section('title', '未付款订单')
@section('customize_css')
    @parent
    .bnonef{
    padding:0;
    box-shadow:none !important;
    background:none;
    color:#fff !important;
    }
    #form-user,#form-product,#form-jyi,#form-beiz {
    height: 225px;
    overflow: scroll;
    }
    .scrollspy{
    height:180px;
    overflow: scroll;
    margin-top: 10px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        待付款订单
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
                    @foreach($order_list as $order)
                        <tr>
                            <td class="text-center">
                                <input name="Order" class="sku-order" type="checkbox" active="0" value="1" order_id="{{$order->id}}">
                            </td>
                            <td></td>
                            <td>{{$order->status}}</td>
                            <td>{{$order->store->name}}</td>
                            <td>{{$order->number}} / {{$order->created_at_val}}</td>
                            <td>{{$order->buyer_name}}</td>
                            <td>{{$order->buyer_summary}}</td>
                            <td>{{$order->seller_summary}}</td>
                            <td>{{$order->buyer_address}}</td>
                            <td>{{$order->logistics->name}} / {{$order->express_no}}</td>
                            <td>{{$order->logistics->name}}</td>
                            <td>{{$order->count}}</td>
                            <td>{{$order->pay_money}} / {{$order->freight}}</td>
                            <td tdr="nochect">
                                <button class="btn btn-gray btn-sm mr-2r show-order" type="button" value="{{$order->id}}" active="1" id="change_status">详情</button>
                                @if($order->status === '待付款' || $order->status === '待审核')
                                    <a href="javascript:void(0);" value="{{$order->id}}" class="magenta-color delete-order">删除</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($order_list)
                <div class="col-md-6 col-md-offset-6">{!! $order_list->render() !!}</div>
            @endif
        </div>
    </div>
@endsection
@section('customize_js')
    @parent
    {{--<script>--}}
    {{--var liname = $('li[role=lichoose]');
    liname.click(function(){
        var htmltitle = $(this).find('a').text();
        $(this).parent().siblings().find('.title').html(htmltitle);
    });--}}

    var _token = $('#_token').val();

    $(".show-order").click(function () {
    $(".order-list").remove();
    var order = $(this).parent().parent();
    var obj = $(this);
    if($(this).attr("active") == 1){
    var id = $(this).attr("value");
    $.get('{{url('/order/ajaxEdit')}}',{'id':id},function (e) {
    if(e.status){
    var template = ['@{{ #order }}<tr class="order-list">',
        '    <td colspan="20" class="plr-0 pb-0">',
            '        <div class="btn-group ptb-2r pl-2r" data-toggle="buttons">',
                '            <label class="btn btn-default active" id="label-user">',
                    '                <input type="radio" id="user"> 客户信息',
                    '            </label>',
                '            <label class="btn btn-default" id="label-product">',
                    '                <input type="radio" id="product"> 商品信息',
                    '            </label>',
                '            <label class="btn btn-default" id="label-jyi">',
                    '                <input type="radio" id="jyi"> 交易信息',
                    '            </label>',
                '            <label class="btn btn-default" id="label-beiz" style="width: 82px;">',
                    '                <input type="radio" id="beiz"> 备注',
                    '            </label>',
                '        </div>',
            '        <form id="form-user" role="form" class="navbar-form">',
                '<input type="hidden" id="order_id" value="@{{id}}">',
                '            <div class="form-inline mtb-4r">',
                    '                <div class="form-group mr-2r">',
                        '                用户名称',
                        '                </div>',
                    '                <div style="width:106px;" class="form-group mr-4r">',
                        '                    <input type="text" class="form-control" disabled="disabled" name="" value="@{{buyer_name}}" style="width: 100%;">',
                        '                </div>',
                    '                <div class="form-group mr-2r">',
                        '                收货人',
                        '                </div>',
                    '                <div style="width:96px;" class="form-group mr-4r">',
                        '                    <input validate="" showname="收货人" type="text" class="form-control order" id="buyer_name" name="buyer_name" value="@{{buyer_name}}" style="width: 100%;">',
                        '                </div>',
                    '                <div class="form-group mr-2r">',
                        '                电话号',
                        '                </div>',
                    '                <div style="width:106px;" class="form-group mr-4r">',
                        '                    <input validate="" showname="收货人" type="text" class="form-control order" id="buyer_tel" name="buyer_tel" value="@{{ buyer_tel }}" style="width: 100%;">',
                        '                </div>',
                    '                <div class="form-group mr-2r">',
                        '                手机号',
                        '                </div>',
                    '                <div style="width:120px;" class="form-group mr-4r">',
                        '                    <input type="text" class="form-control order mobile" id="buyer_phone" name="buyer_phone" value="@{{ buyer_phone }}" style="width: 100%;">',
                        '                </div>',
                    '                <div class="form-group vt-34 mr-2r">物流公司</div>',
                    '                    <div class="form-group pr-4r mr-2r">',
                        '                        <select class="selectpicker" id="express_id" name="logistic_id" style="display: none;">',
                            '<option value="@{{ express_id }}">@{{ logistic_name }}</option>',
                            '                            @{{ #logistic_list }}<option value="@{{ id }}">@{{ name }}</option>@{{ /logistic_list }}',
                            '                        </select>',
                        '                    </div>',
                    '                </div>',
                '            </div>',
                '            <div class="form-inline mtb-4r">',
                    '                <div class="form-group vt-34 mr-2r">发货仓库</div>',
                    '                <div class="form-group pr-4r mr-4r">',
                        '                    <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">',
                            '<option value="@{{ storage_id }}">@{{ storage_name }}</option>',
                            '                        @{{ #storage_list }}<option value="@{{ id }}">@{{ name }}</option>@{{ /storage_list }}',
                            '                    </select>',
                        '                </div>',
                    '                <div class="form-group mr-2r">',
                        '                详细地址',
                        '                </div>',
                    '                <div class="form-group mr-4r">',
                        '                    <input type="text" class="form-control order mobile" id="buyer_address" name="buyer_address" value="@{{ buyer_address }}">',
                        '                </div>',
                    '            </div>',
                '            <div class="form-inline mtb-4r">',
                    '                <div class="form-group vt-34 mr-2r">邮政编码</div>',
                    '                <div class="form-group pr-4r mr-4r">',
                        '                    <input type="text" class="form-control order mobile" id="buyer_zip" name="buyer_zip" value="@{{ buyer_zip }}">',
                        '                </div>',
                    '            </div>',
                '        </form>',
            '        <form id="form-product" role="form" class="navbar-form" style="display:none;">',
                '            <div class="form-inline">',
                    '                <div class="form-group mr-2r">',
                        '                    <a href="#" data-toggle="modal" data-target="#addproduct" id="addproduct-button">+添加商品</a>',
                        '                    <div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">',
                            '                        <div class="modal-dialog modal-lg" role="document">',
                                '                            <div class="modal-content">',
                                    '                                <div class="modal-header">',
                                        '                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">',
                                            '                                        <span aria-hidden="true">×</span>',
                                            '                                    </button>',
                                        '                                    <h4 class="modal-title" id="gridSystemModalLabel">添加客户</h4>',
                                        '                                </div>',
                                    '                                <div class="modal-body">',
                                        '                                    <div class="input-group">',
                                            '                                        <input id="search_val" type="text" placeholder="SKU编码/商品名称" class="form-control">',
                                            '                                        <span class="input-group-btn">',
                        '                                            <button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>',
                        '                                        </span>',
                                            '                                    </div>',
                                        '                                    <div class="mt-4r scrollt">',
                                            '                                        <div id="user-list"> ',
                                                '                                            <table class="table table-bordered table-striped">',
                                                    '                                                <thead>',
                                                    '                                                    <tr class="gblack">',
                                                        '                                                        <th class="text-center"><input type="checkbox" id="checkAll"></th>',
                                                        '                                                        <th>商品图</th>',
                                                        '                                                        <th>SKU编码</th>',
                                                        '                                                        <th>商品名称</th>',
                                                        '                                                        <th>属性</th>',
                                                        '                                                        <th>库存</th>',
                                                        '                                                    </tr>',
                                                    '                                                </thead>',
                                                    '                                                <tbody>',
                                                    '                                                    <tr>',
                                                        '                                                        <td class="text-center">',
                                                            '                                                            <input name="Order" class="sku-order" type="checkbox" active="0" value="1">',
                                                            '                                                        </td>',
                                                        '                                                        <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
                                                        '                                                        <td>伟哥</td>',
                                                        '                                                        <td>18923405430</td>',
                                                        '                                                        <td>100015</td>',
                                                        '                                                        <td>北京北京市朝阳区马辛店</td>',
                                                        '                                                    </tr>',
                                                    '                                                </tbody>',
                                                    '                                            </table>',
                                                '                                        </div>',
                                            '                                    </div>',
                                        '                                    <div class="modal-footer pb-r">',
                                            '                                        <div class="form-group mb-0 sublock">',
                                                '                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
                                                '                                            <button type="button" id="choose-user" class="btn btn-magenta">确定</button>',
                                                '                                        </div>',
                                            '                                    </div>',
                                        '                                </div>',
                                    '                            </div>',
                                '                        </div>',
                            '                    </div>',
                        '                </div>',
                    '                <div class="form-group pull-right">',
                        '                    <span class="mr-4r">共计<b class="magenta-color"> @{{ count }} </b>件商品，总重量 <b class="magenta-color">0.00</b> kg</span>',
                        '                    <span class="mr-4r">商品总金额：@{{ total_money }}  － 商品优惠：@{{ discount_money }}  + 运费: @{{ freight }} = @{{pay_money}}</span>',
                        '                     <span class="mr-2r">实付：<b class="magenta-color">@{{pay_money}}</b></span>',
                        '                </div>',
                    '            </div>',
                '            <div class="scrollspy">',
                    '                <table class="table mb-0">',
                        '                    <thead class="table-bordered">',
                        '                        <tr>',
                            '                            <th>商品图</th>',
                            '                            <th>SKU编码</th>',
                            '                            <th>商品名称</th>',
                            '                            <th>属性</th>',
                            '                            <th>零售价</th>',
                            '                            <th>数量</th>',
                            '                            <th>优惠</th>',
                            '                            <th>应付</th>',
                            '                            <th>操作</th>',
                            '                        </tr>',
                        '                    </thead>',
                        '                    <tbody>',
                        '                    @{{ #order_sku }}<tr>',
                            '                            <td><img src="@{{path}}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
                            '                            <td>@{{ number }}</td>',
                            '                            <td>@{{ name }}</td>',
                            '                            <td>@{{ mode }}</td>',
                            '                            <td>@{{ price }}</td>',
                            '                            <td>@{{ quantity }}</td>',
                            '                            <td>@{{ discount }}</td>',
                            '                            <td>@{{  }}</td>',
                            '                            <td><a href="#" data-toggle="modal" data-target="#addproduct" id="addproduct-button" value="@{{ sku_id }}">换货</a></td>',
                            '                        </tr>@{{ /order_sku }}',
                        '                    </tbody>',
                        '                </table>',
                    '            </div>',
                '        </form>',
            '        <form id="form-jyi" role="form" class="navbar-form" style="display:none;">',
                '            <div class="form-inline mtb-4r">',
                    '                <div class="form-group mr-2r">',
                        '                付款方式',
                        '                </div>',
                    '                <div class="form-group mr-4r">',
                        '                    <button class="btn btn-default" type="button">@{{ payment_type }}</button>',
                        '                </div>',
                    '                <div class="form-group mr-2r">',
                        '                付款类型',
                        '                </div>',
                    '                <div class="form-group mr-4r">',
                        '                    <button class="btn btn-default" type="button">网银</button>',
                        '                </div>',
                    '                <div class="form-group mr-2r">',
                        '                支付账号',
                        '                </div>',
                    '                <div class="form-group mr-4r" style="width: 200px">',
                        '                    <input type="text" class="form-control" name="paymentAccount" value="" disabled="disabled" style="width: 100%;">',
                        '                </div>',
                    '                <div class="form-group mr-2r">',
                        '                 付款时间',
                        '                </div>',
                    '                <div class="form-group mr-4r">',
                        '                    <input type="text" class="form-control" name="paymentAccount" value="" disabled="disabled">',
                        '                </div>',
                    '            </div>',
                '            <div class="form-inline mtb-4r">',
                    '                <div id="accordion" class="panel-group">',
                        '                    <div class="panel-heading p-0">',
                            '                        <h4 style="line-height:40px;" class="panel-title">',
                                '                        <a href="#collapseTwo" data-parent="#accordion" data-toggle="collapse">',
                                    '                            <b class="caret"></b> 发票信息',
                                    '                        </a>',
                                '                        </h4>',
                            '                    </div>',
                        '                    <div class="panel-collapse collapse in" id="collapseTwo">',
                            '                      <div class="ptb-r">',
                                '                        <div class="form-group mr20">无发票信息</div>',
                                '                      </div>',
                            '                    </div>',
                        '                </div>',
                    '            </div>',
                '        </form>',
            '        <form id="form-beiz" role="form" class="navbar-form" style="display:none;">',
                '            <div class="form-inline mtb-4r">',
                    '                <div class="form-group mr-2r">买家备注</div>',
                    '                <div class="form-group"><input type="text" class="form-control" id="buyer_summary" name="buyer_summary" value="@{{ buyer_summary }}"></div>',
                    '            </div>',
                '            <div class="form-inline mtb-4r">',
                    '                <div class="form-group mr-2r">卖家备注</div>',
                    '                <div class="form-group"><input type="text" class="form-control" id="seller_summary" name="seller_summary" value="@{{ seller_summary }}"></div>',
                    '            </div>',
                '        </form>',
            '        <div class="ptb-2r plr-2r" style="background: #e6e6e6;">',
                '          <button type="submit" class="btn btn-magenta btn-xs mr-2r" id="ok">确定</button>',
                '        ',
                '        <button type="submit" class="btn btn-default btn-xs" id="fold">收起</button>',
                '      </div>',
            '    </td>',
        ' </tr>@{{ /order }}'].join("");
    var views = Mustache.render(template, e.data);
    order.after(views);
    obj.attr("active",0);

    {{--收回详情--}}
    $("#fold").click(function () {
    $(".order-list").remove();
    obj.attr("active",1);
    });

    {{--更改订单信息--}}
    $("#ok").click(function () {
    var order_id = $("#order_id").val();
    var buyer_name = $("#buyer_name").val();
    var buyer_tel = $("#buyer_tel").val();
    var buyer_phone = $("#buyer_phone").val();
    var express_id = $("#express_id").val();
    var storage_id = $("#storage_id").val();
    var buyer_address = $("#buyer_address").val();
    var buyer_zip = $("#buyer_zip").val();
    var seller_summary = $("#seller_summary").val();
    var buyer_summary = $("#buyer_summary").val();
    $.ajax({
    type: "POST",
    url: "{{url('/order/ajaxUpdate')}}",
    data:{'_token': _token, 'order_id': order_id, 'buyer_name': buyer_name, 'buyer_tel': buyer_tel,'buyer_phone': buyer_phone,'express_id': express_id,'storage_id': storage_id,'buyer_address': buyer_address,'buyer_zip': buyer_zip,'seller_summary': seller_summary,'buyer_summary': buyer_summary},
    dataType: "json",
    success: function (e) {
    if(!e.status){
    alert(e.message);
    }else{
    $(".order-list").remove();
    obj.attr("active",1);
    location.reload();
    }
    },
    error: function (e) {
    console.log(e);
    for(i in e.responseText){
    var message = e.responseText[i][0];
    break;
    }
    alert(message);
    }
    });
    });

    }else{
    alert(e.message);
    return false;
    }
    },'json');
    }else{
    $(".order-list").remove();
    $(this).attr("active",1);
    }

    });

    $('.delete-order').click(function () {
    var order_id = $(this).attr('value');
    var delete_obj = $(this).parent().parent();
    $.post('{{url('/order/ajaxDestroy')}}',{'_token': _token, 'order_id': order_id},function (e) {
    if(e.status){
    delete_obj.remove();
    }else{
    alert(e.message);
    }
    },'json');
    });

@endsection