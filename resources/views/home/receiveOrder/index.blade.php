@extends('home.base')

@section('customize_js')
    @parent
    var _token = $("#_token").val();
@endsection


@section('load_private')
    @parent
    {{--<script>--}}
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
    });

    $('#charge').click(function () {
    layer.confirm('确认要通过审核吗？',function(index){
    var arr_id = [];var trs = $(this);
    $("input[name='Order']").each(function () {
    if ($(this).is(':checked')) {

    arr_id.push($(this).val());
    }
    })
    $.post('/receive/ajaxCharge',{'_token':_token,'id':arr_id},function (e) {
    if(e.status){
    layer.msg('操作成功！');
    location.reload();
    trs.parent().remove();
    }else if(e.status == 0){
    alert(e.message);
    }
    },'json');
    });
    });



    {{--post请求--}}
    function post(URL, PARAMS) {
    var temp = document.createElement("form");
    temp.action = URL;
    temp.method = "post";
    temp.style.display = "none";
    var opt = document.createElement("textarea");
    opt.name = '_token';
    opt.value = _token;
    temp.appendChild(opt);
    for (var x in PARAMS) {
    var opt = document.createElement("textarea");
    opt.name = x;
    opt.value = PARAMS[x];
    // alert(opt.name)
    temp.appendChild(opt);
    }
    document.body.appendChild(temp);
    temp.submit();
    return temp;
    };

@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    付款单
                </div>
            </div>

            <div class="navbar-collapse collapse">
                @include('home/receiveOrder.subnav')

            </div>

        </div>

    </div>

    <div class="container mainwrap">
        <div class="row fz-0">
            <div class="col-md-12">
                <button type="button" class="btn btn-success mr-2r" id="charge">
                    <i class="glyphicon glyphicon-check"></i>审核
                </button>
            </div>
        </div>
        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>企业全称</th>
                        <th>门店名称 </th>
                        <th>订单号</th>
                        <th>订单时间</th>
                        <th>订单金额</th>
                        <th>结算方式</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order_list as $order)
                        <tr>
                            <td class="text-center">
                                <input name="Order" class="sku-order" type="checkbox" active="0" value="{{ $order->id }}">
                            </td>
                            {{--<td>--}}
                                {{--@if (in_array($order->status, array(0)))--}}
                                    {{--<span class="label label-default">{{$order->status_val}}</span>--}}
                                {{--@endif--}}

                                {{--@if (in_array($order->status, array(1,5,8)))--}}
                                    {{--<span class="label label-danger">{{$order->status_val}}</span>--}}
                                {{--@endif--}}

                                {{--@if (in_array($order->status, array(10,20)))--}}
                                    {{--<span class="label label-success">{{$order->status_val}}</span>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            <td>{{$order->full_name?$order->full_name:''}}</td>
                            <td>{{$order->store_name?$order->store_name : ''}}</td>
                            {{--<td class="magenta-color">--}}
                                {{--{{$order->number}}--}}
                            {{--</td>--}}
                                <td><a target="_blank" href="{{url('/order/search')}}?number={{$order->number}}">{{$order->number}}</a></td>
                            <td>{{$order->order_start_time}}</td>
                            <td>{{$order->total_money}}</td>
                            <td>{{$order->payment_type}}</td>
                            <td tdr="nochect">
                                {{--<a href="{{url('/receiveOrder/show')}}?id={{$order->id}}" class="btn btn-white btn-sm mr-r">查看详情</a>--}}
                                <button class="btn btn-gray btn-sm show-order mb-2r" type="button" value="{{$order->id}}" active="1">
                                    <i class="glyphicon glyphicon-eye-open"></i> 查看
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{--@if ($purchases)--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-6 col-md-offset-6">{!! $purchases->render() !!}</div>--}}
            {{--</div>--}}
        {{--@endif--}}
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>

    @include('mustache.receiveOrder_info')
@endsection

@section('load_private')
    @parent
$(".show-order").click(function() {
var skus = [];
$(".order-list").remove();
var order = $(this).parent().parent();
var obj = $(this);
if ($(this).attr("active") == 1) {
var id = $(this).attr("value");
$.get('{{url('/receive/ajaxEdit')}}',{'id':id},function (e) {
if(e.status == 1){
var template = $('#order-info-form').html();
var views = Mustache.render(template, e.data);
order.after(views);
obj.attr("active", 0)

    {{--收回详情--}}
    $("#fold").click(function () {
    $(".order-list").remove();
    obj.attr("active",1);
    });

    }else{
    $(".order-list").remove();
    $(this).attr("active",1);
    }
    },'json');
    }
    });
@endsection