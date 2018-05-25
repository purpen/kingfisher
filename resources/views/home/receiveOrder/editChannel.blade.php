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
                                        <select class="selectpicker" id="supplier_id" name="supplier_id" style="display: none;">
                                            <option value=''>选择分销商</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{($supplierReceipt->supplier_user_id == $supplier->id)?'selected':''}}>{{ $supplier->nam }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--<input type="hidden" name="supplier_user_id" value="{{$supplierReceipt->supplier_user_id}}">--}}
                                </div>

                                <label for="inputStartTime" class="col-sm-2 control-label">开始时间</label>
                                <div class="col-sm-3" style="width: 200px">
                                    <input type="text" class="form-control datetimepicker" name="start_time" value="{{$supplierReceipt->start_time}}" placeholder="开始时间 " id="start">
                                </div>
                                {{--@if ($errors->has('start_time'))--}}
                                {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('start_time') }}</strong>--}}
                                {{--</span>--}}
                                {{--@endif--}}
                                <label for="inputEndTime" class="col-sm-2 control-label">结束时间</label>
                                <div class="col-sm-3" style="width: 200px">
                                    <input type="text" class="form-control datetimepicker" name="end_time" value="{{$supplierReceipt->end_time}}" placeholder="结束时间" id="end">
                                </div>
                                {{--@if ($errors->has('end_time'))--}}
                                {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('end_time') }}</strong>--}}
                                {{--</span>--}}
                                {{--@endif--}}
                                <div class="col-sm-2" style="margin: 0 auto;position: absolute;margin-left: 1373px">
                                    <a href="#" class="btn btn-magenta" data-toggle="modal" id="query-button">
                                        <i class="glyphicon glyphicon-search"></i> 确认
                                    </a>
                                </div>
                            </div>

                            @include('modal.create_order_sku_relation_modal')


                            <h5>详细信息 <a id="appendsku" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>添加促销</a></h5>
                            <hr>

                            <input type="hidden" name="id" value="{{$supplierReceipt->id}}">

                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr class="gblack">
                                    <th>商品名称</th>
                                    <th>成本价格</th>
                                    <th>商品数量</th>
                                    <th>商品金额</th>

                                    <th>促销价格</th>
                                    <th>促销开始时间</th>
                                    <th>促销结束时间</th>
                                    {{--算促销时间段内的数量--}}
                                    <th>促销数量</th>
                                    <th>促销金额</th>
                                    <th>总金额小计</th>
                                </tr>
                                </thead>
                                <tbody id="append-sku">

                                {{--@foreach($paymentReceiptOrderDetail as $v)--}}
                                <tr>
                                    <td class="fb">
                                        <div style="width:100px;">
                                            <input type="text" name="sku_name" value="{{$paymentReceiptOrderDetail->sku_name}}" class="form-control operate-caigou-blur prices" id="sku_name" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:100px;">
                                            <input type="text" name="price" value="{{$paymentReceiptOrderDetail->price}}" class="form-control operate-caigou-blur price" id="price" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:100px;">
                                            <input type="text" name="quantity" value="{{$paymentReceiptOrderDetail->quantity}}" class="form-control operate-caigou-blur prices" id="quantity" readonly>
                                        </div>
                                    </td>

                                    <input type="hidden" name="sku_id[]" value="{{$paymentReceiptOrderDetail->sku_id}}">
                                    <input type="hidden" name="sku_number" value="{{$paymentReceiptOrderDetail->sku_number}}">

                                    <td>
                                        <div style="width:100px;">
                                            <input type="text" name="xiaoji" class="form-control operate-caigou-blur" value="{{$paymentReceiptOrderDetail->price * $paymentReceiptOrderDetail->quantity}}" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:100px;">
                                            <input type="text" name="prices" value="{{$favorable->price}}" class="form-control operate-caigou-blur prices" id="prices" >
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:300px;">
                                            <div class="col-sm-6"><input type="text" class="form-control datetimepicker" name="start_time" placeholder="促销开始时间 " id="time1" value="{{$favorable->start_time}}"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:300px;">
                                            <div class="col-sm-6"><input type="text" class="form-control datetimepicker" name="end_time" placeholder="促销结束时间 " id="time2" value="{{$favorable->end_time}}"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:100px;">
                                            <input type="text" class="form-control integer operate-caigou-blur count" id="number" name="number" value="{{$favorable->number}}" placeholder="促销数量" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:100px;">
                                            <input type="text" class="form-control integer operate-caigou-blur" name="jine" value="{{$favorable->price * $favorable->number}}" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="width:100px;">
                                            <input type="text" class="form-control integer operate-caigou-blur" name="total" value="{{($paymentReceiptOrderDetail->price * $paymentReceiptOrderDetail->quantity) - ($favorable->price * $favorable->number)}}" readonly>
                                        </div>
                                    </td>
                                </tr>
                                {{--@endforeach--}}




                                </tbody>
                                <tfoot>
                                <tr style="background:#dcdcdc;border:1px solid #dcdcdc;text-align: center">
                                    <td colspan="4" class="fb"></td>
                                    <td colspan="2" class="fb allquantity"><span class="red" id="skuTotalQuantity"></span></td>
                                    {{--<td colspan="5" class="fb alltotal"><strong>所有订单总价：</strong><span class="red" id="skuTotalFee">0.00</span></td>--}}
                                    <td colspan="5" class="fb alltotal"><strong>所有订单总价：</strong><input type="text" name="skuTotalFee" value="{{$supplierReceipt->total_price}}元" id="skuTotalFee" readonly></td>
                                </tr>
                                </tfoot>

                            </table>

                            <div class="form-group mt-3r">
                                <div class="col-sm-6 mt-4r">
                                    <button type="submit" class="btn btn-magenta btn-lg save mr-2r">确认提交</button>
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
    var supplier_id = $("#supplier_id").val();
    var start_time = $("input[name='start_time']").val();
    var end_time = $("input[name='end_time']").val();
    if(supplier_id == '' && start_time =='' && end_time ==''){
    alert('参数有误');
    }else{
    $.get('/payment/ajaxBrand',{'supplier_id':supplier_id,'start_time':start_time,'end_time':end_time},function (e) {
    if (e.status){
    var template = ['<table class="table table-bordered table-striped">',
        '<thead>',
        '<tr class="gblack">',
            '<th class="text-center"><input type="checkbox" id="checkAll"></th>',
            '<th>商品名称</th>',
            '<th>成本价格</th>',
            '<th>商品数量</th>',
            {{--'<th>商品金额</th>',--}}
            '</tr>',
        '</thead>',
        '<tbody>',

        '@{{#data}}<tr>',
            '<td class="text-center"><input name="Order" class="sku-order" orderId="@{{ orderInfo.order_id }}" type="checkbox" active="0" value="@{{ orderInfo.id }}"></td>',
            '<td> @{{ orderInfo.sku_name }}</td>',
            '<input type="hidden" name="supplier_id" value="@{{supplier_id}}">',
            '<td class="fb"><input type="text" name="price" value="@{{orderInfo.price}}" style="border: none" readonly></td>',
            '<td class="fc"><input type="text" name="quantity" value="@{{orderInfo.quantity}}" style="border: none" readonly></td>',
            {{--'<td><input type="text" class="form-control integer operate-caigou-blur" name="xiaoji[]" style="border: none"></td>',--}}
            '</tr>@{{/data}}',
        '</tbody>',
        '</table>',
    ].join("");

    var views = Mustache.render(template, e);
    $("#sku-list").html(views);
    $("#addsku").modal('show');
    }
    },'json');
    }
    });


    var price=$("input[name='price']").val();
    var quantity=$("input[name='quantity']").val();
    var xiaoji = price * quantity;
    $(this).parent().siblings(".xiaoji").html(xiaoji.toFixed(2));
    $("input[name='xiaoji']").val(xiaoji);
    {{--xiaoji=$(".xiaoji").val;--}}


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
    {{--console.log("sku i id "+ sku_data[i].id);--}}
    {{--console.log("sku tmp"+sku_tmp);--}}
    if(jQuery.inArray(parseInt(sku_data[i].id),sku_orderId_tmp) != -1){
    skus.push(sku_data[i]);
    }

    }


    var template = ['@{{#skus}}<tr class="maindata">',

        '<td>@{{ orderInfo.sku_name }}</td>',
        '<td class="fb"><input type="text" name="price" value="@{{orderInfo.price}}" style="border: none" readonly></td>',
        '<input type="hidden" name="sku_id" value="@{{orderInfo.sku_id}}">',
        '<input type="hidden" name="sku_name" value="@{{orderInfo.sku_name}}">',
        '<input type="hidden" name="sku_number" value="@{{orderInfo.sku_number}}">',
        '<td class="fc"><input type="text" name="quantity" value="@{{orderInfo.quantity}}" style="border: none" readonly></td>',
        '<td><input type="text" class="form-control integer operate-caigou-blur xiaoji" name="xiaoji" style="border: none" readonly></td>',
        '<td><input type="text" name="prices" value="" class="form-control operate-caigou-blur prices" id="prices" placeholder=""></td>',
        '<td><label for="inputStartTime" class="col-sm-2 control-label"></label><div class="col-sm-6"><input type="text" class="form-control datetimepicker" name="start_time" placeholder="促销开始时间 " id="time1"></div></td>',
        '<td><label for="inputEndTime" class="col-sm-2 control-label"></label><div class="col-sm-6"><input type="text" class="form-control datetimepicker" name="end_time" placeholder="促销结束时间" id="time2"></div></td>',
        '<td><input type="text" class="form-control integer operate-caigou-blur count" id="number" name="number" value="" placeholder="促销数量" readonly></td>',
        '<td><input type="text" class="form-control integer operate-caigou-blur" name="jine" readonly></td>',
        '<td class="total">0.00</td>',
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
@endsection