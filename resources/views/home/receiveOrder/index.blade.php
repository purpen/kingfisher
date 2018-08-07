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
                        {{--<th>状态</th>--}}
                        <th>店铺名 </th>
                        <th>订单号/下单时间</th>
                        <th>买家</th>
                        <th>物流/运单号</th>
                        <th>数量</th>
                        <th>实付/运费</th>
                        <th>结算方式</th>
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
                            <td>{{$order->store ? $order->store->name : ''}}</td>
                            <td class="magenta-color">
                                <span>{{$order->number}}</span><br>
                                <small class="text-muted">{{$order->order_start_time}}</small>
                            </td>
                            <td>{{$order->buyer_name}}</td>
                            <td>
                                <span>{{$order->logistics ? $order->logistics->name : ''}}</span><br>
                                <small class="text-muted">{{$order->express_no}}</small>
                            </td>
                            <td>{{$order->count}}</td>
                            <td>{{$order->total_money}} / {{$order->freight}}</td>
                            <td>{{$order->payment_type}}</td>
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
@endsection