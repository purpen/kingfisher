@extends('home.base')

@section('title', '渠道收款单详情')

@section('customize_css')
    @parent
    .scrollt {
    height:400px;
    overflow:hidden;
    }
    .sublock{
    display: block !important;
    margin-left: -15px;
    margin-right: -15px;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        渠道收款单详情
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row formwrapper">
            <div class="col-md-12">
                <h5>收款单信息</h5>
                <hr>
                <p><strong>分销商：</strong>
                    <span>
                        {{$userId->realname}}
                    </span>
                </p>
                <p><strong>开始时间：</strong> <span>@if($distributorPayment->start_time != '0000-00-00') {{$distributorPayment->start_time}} @endif</span></p>
                <p><strong>结束时间：</strong> <span>@if($distributorPayment->end_time != '0000-00-00') {{$distributorPayment->end_time}} @endif</span></p>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="active">
                        <th>渠道订单号</th>
                        <th>商品名称</th>
                        <th>销售价格</th>
                        <th>商品总数量</th>
                        <th>商品金额</th>
                        <th>促销开始时间</th>
                        <th>促销结束时间</th>
                        <th>促销价格</th>
                        <th>促销数量</th>
                        <th>促销金额</th>
                        <th>总金额小计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <input type="hidden" name="id" value="{{$distributorPayment->id}}">
                    <input type="hidden" name="status" value="{{$distributorPayment->status}}">
                    @foreach($paymentReceiptOrderDetail as $v)
                        <tr>
                            <td class="fb">{{$distributorPayment['number']}}</td>
                            <td class="fb">{{$v['sku_name']}}</td>
                            <td>{{$v['price']}}</td>
                            <td>{{$v['quantity']}}</td>
                            <td id="warehouseQuantity0" >{{$v['price'] * $v['quantity']}}</td>
                            <td>{{$v['start_time']}}</td>
                            <td>{{$v['end_time']}}</td>
                            <td>{{$v['prices']}}</td>
                            <td>{{$v['numbers']}}</td>
                            <td>{{($v['price'] - $v['prices']) * $v['number']}}</td>
                            <td id="totalTD0">{{($v['price'] * $v['quantity']) - (($v['price'] - $v['prices']) * $v['number'])}}</td>
                        </tr>

                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="active" id="append-sku">
                        <td colspan="4" class="fb"></td>
                        <td colspan="1" class="fb"></td>
                        <td colspan="2" class="fb"></td>
                        <td colspan="2" class="fb"></td>

                        <td colspan="3" class="fb">
                            @if(count($paymentReceiptOrderDetail)>0)
                                所有订单总价：
                                <span class="red" id="skuTotalFee">{{$distributorPayment->price}}</span>元
                            @endif
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>



            <div class="col-md-12"><hr><hr>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="active">
                        <th>订单号</th>
                        <th>站外订单号</th>
                        <th>分销商</th>
                        <th>商品名</th>
                        <th>商品总金额</th>
                        <th>数量</th>
                        <th>单价</th>
                        <th>sku编号</th>
                        <th>分销商促销价</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $v)
<tr>
                            <td>{{$v['number']}}</td>
                            <td>{{$v['outside_target_id']}}</td>
                            <td class="fb">{{$userId->realname}}</td>
                            <td>{{$v['sku_name']}}</td>
                            <td id="warehouseQuantity0" >{{$v['price'] * $v['quantity']}}</td>
                            <td>{{$v['quantity']}}</td>
                            <td>{{$v['price']}}</td>
                            <td>{{$v['sku_number']}}</td>
                            <td>{{$v['distributor_price']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(!in_array($distributorPayment->status,[2,4]))
            <button type="button" id="batch-verify" class="btn btn-success mr-2r">
                <i class="glyphicon glyphicon-ok"></i> 通过审核
            </button>
        @endif
        <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">
            <i class="glyphicon glyphicon-arrow-left"></i> 返回列表
        </button>

        <input type="text" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection

@section('customize_js')
    @parent


    {{--供应商审核--}}
    $('#batch-verify').click(function () {
    var id = $("input[name='id']").val();
    var _token = $("input[name='_token']").val();
    var status = $("input[name='status']").val();

    layer.confirm('确认要通过审核吗？',function(index){

    $.post('{{url('/receive/ajaxVerify')}}',{'_token': _token,'id': id,'status':status}, function (data) {
    layer.msg(data.message);
    if(data.status == 1){
    location.href = '{{url('/receive/receiveIndex')}}';
    }else{
    location.reload();
    }
    },'json');
    });

    });

@endsection
