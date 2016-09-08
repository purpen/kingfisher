@extends('home.base')

@section('title', '退款售后')
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
                <div class="navbar-header">
                    <div class="navbar-brand">
                        退款售后
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li><a href="{{url('/refund')}}">售前退款</a></li>
                        <li class="active"><a href="{{url('/refund/refundMoney')}}">售后退款</a></li>
                        <li><a href="{{url('')}}">退款退货</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="" method="POST">
                                <div class="form-group">
                                    <input type="text" name="where" class="form-control" placeholder="">
                                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                                </div>
                                <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row fz-0">
            <a href="{{url('/refund/createRefundGood')}}">
                <button type="button" id="batch-verify" class="btn btn-white mlr-2r">
                    新增退货单
                </button>
            </a>
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
                            </ul>
                        </div>
                    </th>
                    <th>退单编号</th>
                    <th>申请时间</th>
                    <th>订单编号</th>
                    <th>买家</th>
                    <th>收货人</th>
                    <th>手机号</th>
                    <th>地址</th>
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
                            </ul>
                        </div>
                    </th>
                    <th>交易金额</th>
                    <th>退款金额</th>
                    <th>买家申请原因</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                {{--@foreach($order_list as $order)
                    <tr>
                        <td class="text-center">
                            <input name="Order" class="sku-order" type="checkbox" active="0" value="1" order_id="{{$order->id}}">
                        </td>
                        <td></td>
                        <td>{{$order->status}}</td>
                        <td>{{$order->store->name}}</td>
                        <td>{{$order->number}}</td>
                        <td>{{$order->created_at_val}}</td>
                        <td>{{$order->buyer_name}}</td>
                        <td>{{$order->buyer_summary}}</td>
                        <td>{{$order->seller_summary}}</td>
                        <td>{{$order->buyer_address}}</td>
                        <td>{{$order->express_no}}</td>
                        <td>{{$order->logistics->name}}</td>
                        <td>{{$order->count}}</td>
                        <td>{{$order->pay_money}} / {{$order->freight}}</td>
                        <td tdr="nochect">
                            <button class="btn btn-gray btn-sm mr-2r verify_order" type="button" value="{{$order->id}}">审单</button>
                            <button class="btn btn-gray btn-sm mr-2r show-order" type="button" value="{{$order->id}}" active="1" id="change_status">详情</button>
                        </td>
                    </tr>
                @endforeach--}}
                </tbody>
            </table>
        </div>
        {{--@if ($order_list)
            <div class="col-md-6 col-md-offset-6">{!! $order_list->render() !!}</div>
        @endif--}}
    </div>
    </div>
@endsection
@section('customize_js')
    @parent
    {{--<script>--}}

    var sku_data = '';
    var _token = $('#_token').val();
    $(".show-order").click(function () {
    var skus = [];
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
                        '                    <a href="#" data-toggle="modal" data-target="#addproduct" id="addproduct-button">+添加赠品</a>',
                        '                    <div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">',
                            '                        <div class="modal-dialog modal-lg" role="document">',
                                '                            <div class="modal-content">',
                                    '                                <div class="modal-header">',
                                        '                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">',
                                            '                                        <span aria-hidden="true">×</span>',
                                            '</button>',
                                        '<h4 class="modal-title" id="gridSystemModalLabel">添加赠品</h4>',
                                        '</div>',
                                    '<div class="modal-body">',
                                        '<div class="input-group">',
                                            '<input id="sku_search_val" type="text" placeholder="SKU编码/商品名称" class="form-control">',
                                            '<span class="input-group-btn">',
                                '<button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>',
                                '</span>',
                                            '</div>',
                                        '<div class="mt-4r scrollt">',
                                            '<div id="user-list"> ',
                                                '<table class="table table-bordered table-striped">',
                                                    '<thead>',
                                                    '<tr class="gblack">',
                                                        '<th class="text-center"><input type="checkbox" id="checkAll"></th>',
                                                        '<th>商品图</th>',
                                                        '<th>SKU编码</th>',
                                                        '<th>商品名称</th>',
                                                        '<th>属性</th>',
                                                        '<th>库存</th>',
                                                        '</tr>',
                                                    '</thead>',
                                                    '<tbody id="gift">',
                                                    '</tbody>',
                                                    '</table>',
                                                '</div>',
                                            '</div>',
                                        '<div class="modal-footer pb-r">',
                                            '<div class="form-group mb-0 sublock">',
                                                '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
                                                '<button type="button" id="choose-gift" class="btn btn-magenta">确定</button>',
                                                '</div>',
                                            '</div>',
                                        '</div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>',
                    '<div class="form-group pull-right">',
                        '<span class="mr-4r">共计<b class="magenta-color"> @{{ count }} </b>件商品，总重量 <b class="magenta-color">0.00</b> kg</span>',
                        '<span class="mr-4r">商品总金额：@{{ total_money }}  － 商品优惠：@{{ discount_money }}  + 运费: @{{ freight }} = @{{pay_money}}</span>',
                        '<span class="mr-2r">实付：<b class="magenta-color">@{{pay_money}}</b></span>',
                        '</div>',
                    '</div>',
                '<div class="scrollspy">',
                    '<table class="table mb-0">',
                        '<thead class="table-bordered">',
                        '<tr>',
                            '                            <th>商品图</th>',
                            '                            <th>SKU编码</th>',
                            '                            <th>商品名称</th>',
                            '                            <th>属性</th>',
                            '                            <th>零售价</th>',
                            '                            <th>数量</th>',
                            '                            <th>优惠</th>',
                            '                            <th>操作</th>',
                            '                        </tr>',
                        '                    </thead>',
                        '                    <tbody id="order_sku">',
                        '                    @{{ #order_sku }}<tr>',
                            '                            <td><img src="@{{path}}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
                            '                            <td>@{{ number }}</td>',
                            '                            <td>@{{#status}}[赠品]@{{/status}}@{{ name }}</td>',
                            '                            <td>@{{ mode }}</td>',
                            '                            <td>@{{ price }}</td>',
                            '                            <td>@{{ quantity }}</td>',
                            '                            <td>-@{{ discount }}</td>',
                            '                            <td><a href="#" data-toggle="modal" data-target="#" id="addproduct-button" value="@{{ sku_id }}">{{--换货--}}</a></td>',
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

    //选择赠品列表
    $("#addproduct-button").click(function(){
    var storage_id = $('#storage_id').val();
    $.get('{{url('/order/ajaxSkuList')}}',{'id':storage_id},function (e) {
    if(e.data){
    template = ['@{{#data}}<tr>',
        '<td class="text-center">',
            '<input name="Order" class="sku-order" type="checkbox" active="0" value="1" id="@{{id}}">',
            '</td>',
        '<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
        '<td>@{{ number }}</td>',
        '<td>@{{ name }}</td>',
        '<td>@{{ mode }}</td>',
        '<td>@{{ count }}</td>',
        '</tr>@{{/data}}'].join("");
    var views = Mustache.render(template, e);
    $('#gift').html(views);
    sku_data = e.data;
    }else{
    alert('参数错误');
    }
    },'json');

    $("#sku_search").click(function () {
    var where = $("#sku_search_val").val();
    if(where == '' || where == undefined ||where == null){
    alert('未输入内容');
    return false;
    }
    $.get('{{url('/order/ajaxSkuSearch')}}',{'storage_id':storage_id, 'where':where},function (e) {
    if (e.status){
    template = ['@{{#data}}<tr>',
        '<td class="text-center">',
            '<input name="Order" class="sku-order" type="checkbox" active="0" value="1" id="@{{id}}">',
            '</td>',
        '<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
        '<td>@{{ number }}</td>',
        '<td>@{{ name }}</td>',
        '<td>@{{ mode }}</td>',
        '<td>@{{ count }}</td>',
        '</tr>@{{/data}}'].join("");
    var views = Mustache.render(template, e);
    sku_data = e.data;
    $("#gift").html(views);
    console.log(e);
    }
    },'json');
    });
    });

    $("#choose-gift").click(function () {
    skus = [];
    var sku_tmp = [];
    $(".sku-order").each(function () {
    if($(this).is(':checked')){
    sku_tmp.push(parseInt($(this).attr('id')));
    }
    });
    for (var i=0;i < sku_data.length;i++){
    if(jQuery.inArray(parseInt(sku_data[i].id),sku_tmp) != -1){
    skus.push(sku_data[i]);
    }
    }
    var template = ['@{{ #skus }}<tr>',
        '<td><img src="@{{path}}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
        '<td>@{{ number }}</td>',
        '<td>@{{ name }}</td>',
        '<td>@{{ mode }}</td>',
        '<td>@{{ price }}</td>',
        '<td>1</td>',
        '<td>-@{{ price }}</td>',
        '<td><a href="#" id="delete_gift" value="@{{ sku_id }}">删除</a></td>',
        '</tr>@{{ /skus }}'].join("");
    var data = {};
    data['skus'] = skus;
    var views = Mustache.render(template, data);
    $("#order_sku").append(views);
    $("#addproduct").modal('hide');

    $("#delete_gift").click(function () {
    $(this).parent().parent().remove();
    });
    });


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
    data:{'_token': _token, 'order_id': order_id, 'buyer_name': buyer_name, 'buyer_tel': buyer_tel,'buyer_phone': buyer_phone,'express_id': express_id,'storage_id': storage_id,'buyer_address': buyer_address,'buyer_zip': buyer_zip,'seller_summary': seller_summary,'buyer_summary': buyer_summary,'skus': skus},
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

    $(".verify_order").click(function () {
    var order_id = $(this).attr('value');
    var obj = $(this).parent().parent();
    $.post('{{url('/order/ajaxVerifyOrder')}}',{'_token': _token,'order': [order_id]}, function (e) {
    if(e.status){
    obj.remove();
    }else{
    alert(e.message);
    }
    },'json');
    });

    $('#batch-verify').click(function () {
    var order = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    order.push($(this).attr('order_id'));
    }
    $.post('{{url('/order/ajaxVerifyOrder')}}',{'_token': _token,'order': order}, function (e) {
    if(e.status){
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    });
    });
@endsection