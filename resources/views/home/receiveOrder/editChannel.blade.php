@extends('home.base')

@section('title', '渠道收款单')

@section('customize_css')
    @parent
    .maindata input{
    width:100px;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    创建渠道收款单
                </div>
            </div>
        </div>

        <div class="container mainwrap">
            @include('block.form-errors')
            <div class="row">
                <div class="col-md-12">
                    <div class="formwrapper">
                        <form id="add-brand" role="form" method="post" class="form-horizontal" action="{{ url('/receive/update') }}">

                            <h5>收款单信息</h5>
                            <hr>

                            <div class="form-group" style="position: relative;width: 100%">
                                <label for="supplier_id" class="col-sm-1 control-label">分销商</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <select class="selectpicker" id="supplier_id" name="supplier_id" style="display: none;" readonly>
                                            {{--<option value=''>选择分销商</option>--}}
                                            @foreach($uid as $value)
                                                <option value="{{ $value->id }}">{{ $value->account }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <label for="inputStartTime" class="col-sm-2 control-label">开始时间</label>
                                <div class="col-sm-3" style="width: 200px">
                                    <input type="text" class="form-control datetimepicker" name="start_times" value="{{$distributorPayment->start_time}}" placeholder="开始时间 " id="start">
                                </div>
                                <label for="inputEndTime" class="col-sm-2 control-label">结束时间</label>
                                <div class="col-sm-3" style="width: 200px">
                                    <input type="text" class="form-control datetimepicker" name="end_times" value="{{$distributorPayment->end_time}}" placeholder="结束时间" id="end">
                                </div>
                                <input type="hidden"  name="distributor_user_id" value="{{ $value->id }}">
                                <div class="col-sm-2" style="margin: 0 auto;position: absolute;margin-left: 1373px">
                                    <a href="#" class="btn btn-magenta" data-toggle="modal" id="query-button">
                                        <i class="glyphicon glyphicon-search"></i> 确认
                                    </a>
                                </div>
                            </div>

                            @include('modal.create_channel')


                            <h5>详细信息 <a id="appendsku" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>添加促销</a></h5>
                            <hr>

                            <input type="hidden" name="id" value="{{$distributorPayment->id}}">

                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr class="gblack">
                                    <th>商品名称</th>
                                    <th>销售价格</th>
                                    <th>商品数量</th>
                                    <th>商品金额</th>
                                    <th>促销开始时间</th>
                                    <th>促销结束时间</th>
                                    <th>促销价格</th>
                                    <th>促销数量</th>
                                    <th>促销金额</th>
                                    <th>总金额小计</th>
                                </tr>
                                </thead>
                                <tbody id="append-sku">

                                @foreach($paymentReceiptOrderDetail  as $k=>$v)
                                    <tr>
                                        <td class="fb">
                                            <div style="width:100px;">
                                                <input type="text" name="sku_name[]" value="{{$v->sku_name}}" class="form-control operate-caigou-blur prices" id="sku_name" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" name="price[]" value="{{$v->price}}" class="form-control operate-caigou-blur price" id="price" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" name="quantity[]" value="{{$v->quantity}}" class="form-control operate-caigou-blur prices" id="quantity" readonly>
                                            </div>
                                        </td>

                                        <input type="hidden" name="sku_id[]" value="{{$v->sku_id}}">
                                        <input type="hidden" name="sku_number[]" value="{{$v->sku_number}}">
                                        <input type="hidden" name="length" value="{{$count}}">


                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" name="xiaoji[]" value="{{ $v->price * $v->quantity }}" class="form-control operate-caigou-blur xiaoji"  readonly>
                                            </div>
                                        </td>

                                        <td>
                                            <div style="width:300px;">
                                                <div class="col-sm-6"><input type="text" class="form-control datetimepicker" name="start_time[]" placeholder="促销开始时间 " id="time1" value="{{$v->start_time}}"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:300px;">
                                                <div class="col-sm-6"><input type="text" class="form-control datetimepicker" name="end_time[]" placeholder="促销结束时间 " id="time2" value="{{$v->end_time}}"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" name="prices[]" value="{{$v->prices}}" class="form-control operate-caigou-blur prices" id="prices" >
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" class="form-control integer operate-caigou-blur count" id="number" name="number[]" value="{{$v->number}}" placeholder="促销数量" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" class="form-control integer operate-caigou-blur" name="jine[]" value="{{$v->price * $v->number}}" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" class="form-control integer operate-caigou-blur" name="total[{{$v->id}}]" value="{{($v->price * $v->quantity) - ($v->prices * $v->number)}}" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr style="background:#dcdcdc;border:1px solid #dcdcdc;text-align: center">
                                    <td colspan="4" class="fb"></td>
                                    <td colspan="2" class="fb allquantity"><span class="red" id="skuTotalQuantity"></span></td>
                                    <td colspan="5" class="fb alltotal"><strong>所有订单总价：</strong><input type="text" name="skuTotalFee" value="{{$distributorPayment->price}}" id="skuTotalFee" readonly>元</td>
                                </tr>
                                </tfoot>

                            </table>

                            <div class="form-group mt-3r">
                                <div class="col-sm-6 mt-4r">
                                    <button type="submit" class="btn btn-magenta btn-lg save mr-2r" id="tijiao">确认提交</button>
                                    <button type="submit" class="btn btn-magenta btn-lg save mr-2r" id="save">保存</button>
                                    <button type="button" class="btn btn-white cancel btn-lg once" onclick="location.reload();">重新计算</button>
                                </div>
                            </div>
                            {!! csrf_field() !!}
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('customize_js')
    @parent
    var sku_data = '';
    var sku_id = [{{$sku_id}}];

@endsection

@section('load_private')


    $("#query-button").click(function () {
    var distributor_user_id = $("select[name='distributor_user_id']").val();
    var start_times = $("input[name='start_times']").val();
    var end_times = $("input[name='end_times']").val();
    if(distributor_user_id == 0){
    layer.msg('请选择分销商！');
    return false;
    }

    if(start_times =='' || end_times ==''){
    layer.msg('请选择时间！');
    return false;
    }

    var start = $(".start").val();
    var end = $(".end").val();
    if(start > end){
    layer.msg('时间选择有误！');
    return false;
    }
    $.get('/receive/ajaxChannel',{'distributor_user_id':distributor_user_id,'start_times':start_times,'end_times':end_times},function (e) {
    if (e.status){
    var template = ['<table class="table table-bordered table-striped">',
        '<thead>',
        '<tr class="gblack">',
            '<th class="text-center"><input type="checkbox" id="checkAll"></th>',
            '<th>商品名称</th>',
            '<th>销售价格</th>',
            '<th>商品数量</th>',
            '</tr>',
        '</thead>',
        '<tbody>',

        '@{{#data}}<tr>',
            '<td class="text-center"><input name="Order" class="sku-order" orderId="@{{ orderInfo.order_id }}" type="checkbox" active="0" value="@{{ orderInfo.id }}"></td>',
            '<td> @{{ orderInfo.sku_name }}</td>',
            '<input type="text" name="distributor_user_id" value="@{{user_id}}">',
            '<td class="fb"><input type="text" name="price" value="@{{orderInfo.price}}" style="border: none" readonly></td>',
            '<td class="fc"><input type="text" name="quantity" value="@{{orderInfo.quantity}}" style="border: none" readonly></td>',
            '</tr>@{{/data}}',
        '</tbody>',
        '</table>',
    ].join("");

    var views = Mustache.render(template, e);
    $("#sku-list").html(views);
    $("#addsku").modal('show');
    } else if(e.status == 0){
    layer.msg("暂无数据！");
    return false;
    }
    },'json');
    });


    $("#choose-sku").click(function () {
        var skus = [];
        var sku_tmp = [];
        var sku_orderId_tmp=[];
    $(".sku-order").each(function () {
        if($(this).is(':checked')){
            if($.inArray(parseInt($(this).attr('value')),sku_id) == -1){
            sku_id.push(parseInt($(this).attr('value')));
            sku_tmp.push(parseInt($(this).attr('value')));
            sku_orderId_tmp.push(parseInt($(this).attr('orderId')));
            }
        }
    });

    for (var i=0;i < sku_data.length;i++){
        if(jQuery.inArray(parseInt(sku_data[i].id),sku_orderId_tmp) != -1){
        skus.push(sku_data[i]);
    }
    }


    var template = ['@{{#skus}}<tr class="maindata">',

        '<td class="fb"><div style="width:100px;"><input type="text" name="sku_name[]" value="@{{ orderInfo.sku_name }}" class="form-control operate-caigou-blur prices" id="sku_name" readonly=""></div></td>',
        '<td class="fb"><div style="width:100px;"><input type="text" name="price[@{{ids}}]" value="@{{orderInfo.price}}" readonly class="form-control operate-caigou-blur"></div></td>',
        '<input type="hidden" name="sku_id[]" value="@{{orderInfo.sku_id}}">',
        '<input type="hidden" name="sku_name[]" value="@{{orderInfo.sku_name}}">',
        '<input type="hidden" name="sku_number[]" value="@{{orderInfo.sku_number}}">',
        '<td class="fc"><div style="width:100px;"><input type="text" name="quantity[]" value="@{{orderInfo.quantity}}" readonly class="form-control operate-caigou-blur"></div></td>',
        '<td><div style="width:100px;"><input type="text" class="form-control integer operate-caigou-blur xiaoji" name="xiaoji[]" value="@{{orderInfo.goods_money }}" style="border: none" readonly></div></td>',
        '<td><div style="width:300px;"><div class="col-sm-6"><input type="text" class="form-control datetimepickers" name="start_time[@{{ids}}]" placeholder="促销开始时间 " id="time1" value="" required></div></div></td>',
        '<td><div style="width:300px;"><div class="col-sm-6"><input type="text" class="form-control datetimepickers" name="end_time[@{{ids}}]" placeholder="促销结束时间 " id="time2" value="" required></div></div></td>',
        '<td><div style="width:100px;"><input type="text" name="prices[@{{ids}}]" value="" class="form-control operate-caigou-blur prices" id="prices" placeholder="" required></div></td>',
        '<td><div style="width:100px;"><input type="text" class="form-control integer operate-caigou-blur count" id="number" name="number[]" value="2" placeholder="促销数量" readonly></div></td>',
        '<td><div style="width:100px;"><input type="text" class="form-control integer operate-caigou-blur" name="jine[]" readonly></div></td>',
        '<td><div style="width:100px;"><input type="text" class="form-control integer operate-caigou-blur" name="total[@{{ids}}]"  readonly></div></td>',
        '</tr>@{{/skus}}'].join("");
    var data = {};
    data['skus'] = skus;
    var views = Mustache.render(template, data);
    $("#append-sku").before(views);
    $("#addsku").modal('hide');

    console.log(sku_id)
    console.log(sku_orderId_tmp)
    console.log(skus)
    });

    $('.datetimepicker').datetimepicker({
    language:  'zh',
    minView: "month",
    format : "yyyy-mm-dd",
    autoclose:true,
    todayBtn: true,
    todayHighlight: true,
    });

    $(".prices").livequery(function(){
    $(this)
    .css("ime-mode", "disabled")
    .keypress(function(){
        if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
         event.returnValue=false;
    }
    })

    .keyup(function(){
        var prices = $(this).val();
        var number = $(this).parent().parent().next().find($("input[name^='number']")).val();
        $(this).parent().parent().next().next().find($("input[name^='jine[]']")).val(prices * number);

        var xiaoji = $(this).parent().parent().parent().find("input[name^='xiaoji[]']").val();
       $(this).parent().parent().next().next().next().find("input[name^='total']").val(xiaoji-prices * number);

        var skuTotalFee=0;
        $("input[name^='total']").each(function(){
        {{--已取整 小于1无法正常计算--}}
            skuTotalFee=skuTotalFee + parseInt($(this).val());
    })
        $('#skuTotalFee').val(skuTotalFee + ' 元');

    })


    $('.datetimepickers').datetimepicker({
    language:  'zh',
    minView: "month",
    format : "yyyy-mm-dd",
    autoclose:true,
    todayBtn: true,
    todayHighlight: true,
    });
    });


    {{--提交之前判断价格有没有小于成本价--}}
    $("#tijiao").click(function(){
        var price={};
        var prices={};
        var time1={};
        var time2={};
        var start = $(".start").val();
        var end = $(".end").val();
        var length = $("input[name='length']").val();
    for(i =0;i< length;i++){
        price[i] = $("input[name='price["+i+"]']").val();
        prices[i]= $("input[name='prices["+i+"]']").val();
        time1[i] = $("input[name='start_time["+i+"]']").val();
        time2[i] = $("input[name='end_time["+i+"]']").val();

        time1 = $("input[name='start_time[]']").val();
        time2 = $("input[name='end_time[]']").val();
    if(prices[i] > price[i]){
        layer.msg("价格填写有误！");
        return false;
    }
    if(time2[i] > end || time2[i] < start){
        layer.msg("促销结束时间选择有误");
        return false;
    }
    if(time2[i] < time1[i]){
        layer.msg("时间区间选择有误");
        return false;
    }
    }
    });
@endsection