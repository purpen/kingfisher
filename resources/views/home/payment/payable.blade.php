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

    $('#confirm-pay').click(function () {
        var arr_id = [];
        $("input[name='Order']").each(function () {
            if ($(this).is(':checked')) {
                arr_id.push($(this).val());
            }
        });
        $.post('/payment/ajaxConfirmPay', {'_token': _token, 'arr_id': arr_id}, function (e) {
            if (e.status) {
                location.reload();
            } else if (e.status == 0) {
                alert(e.message);
            }
        }, 'json');
    });

    $("#payment").click(function () {
        var arr_id = [];
        $("input[name='Order']").each(function () {
            if ($(this).is(':checked')) {
                arr_id.push($(this).val());
            }
        });

        $.post('/payment/ajaxConfirmPay', {'_token': _token, 'arr_id': arr_id}, function (e) {
            if (e.status) {
                location.reload();
            } else if (e.status == 0) {
                alert(e.message);
            }
        }, 'json');
    });

    $(".delete").click(function () {
        var id = $(this).val();
        $.post('{{url('/payment/ajaxDestroy')}}', {'_token': _token, 'id': id}, function (e) {
            if (e.status == 1) {
                location.reload();
            } else if (e.status == -1) {
                alert(e.msg);
            } else{
                alert(e.message);
            }
        }, 'json');
    });

    {{--导出execl--}}
    $("#payment-excel").click(function () {
        var id_array = [];
        $("input[name='Order']").each(function() {
            if($(this).is(':checked')){
                id_array.push($(this).attr('value'));
            }
        });
        post('{{url('/paymentExcel')}}',id_array);
    });

    {{--按时时间、类型导出--}}
    $("#payment-excel-1").click(function () {
        var payment_type = $("#payment_type").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var subnav = $("#subnav").val();
        if(start_date == '' || end_date == ''){
            alert('请选择时间');
        }else{
            post('{{url('/dateGetPaymentExcel')}}',{'payment_type':payment_type,'start_date':start_date,'end_date':end_date,'subnav':subnav});
        }

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
                    付款单列表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.payment.subnav')
            </div>
        </div>
    </div>
    
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/payment/create') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 创建付款单
                        </a>
                    </div>
                    <div class="form-group">
                        <button type="button" id="payment-excel" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-arrow-up"></i> 导出选中
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="button" id="payment-excel-1" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-arrow-up"></i> 条件导出
                        </button>
                    </div>
                    @if($subnav == 'waitpay')
                    <div class="form-group">
                        <button type="button" class="btn btn-success mr-2r" id="payment">
                            <i class="glyphicon glyphicon-check"></i>付款
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4 text-right">
                <span>付款金额：<span class="text-danger">{{ $money or 0 }}</span> 元</span>
            </div>
        </div>
        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>付款单号</th>
                        <th>收款人</th>
                        <th>应付金额</th>
                        <th>收支类型</th>
                        <th>相关单据</th>
                        <th>收款单号</th>
                        <th>备注</th>
                        <th>创建人</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payment as $v)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox" value="{{$v->id}}"></td>
                            <td class="magenta-color">{{$v->number}}</td>
                            <td>{{$v->receive_user}}</td>
                            <td>{{$v->amount}}</td>
                            <td>@if($v->type <= 2 && $v->purchase)【{{$v->purchase->supplier_type_val}}】@endif{{$v->type_val}}</td>
                            <td>{{$v->target_number}}</td>
                            <td>@if($v->receive_order) <a target="_blank" href="{{ url('/receive/search') }}?receive_number={{$v->receive_order->number}}">{{$v->receive_order->number}}</a> @endif</td>
                            <td>{{$v->summary}}</td>
                            <td>@if($v->user) {{$v->user->realname}} @endif</td>
                            <td>{{$v->created_at_val}}</td>
                            <td>
                                <a href="{{url('/payment/detailedPayment')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">查看</a>
                                @if($subnav == 'waitpay')
                                <a href="{{url('/payment/editPayable')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">编辑</a>
                                {{--<button type="button" id="" value="{{$v->id}}" class="btn btn-warning btn-sm mr-r">确认付款</button>--}}
                                    @if($v->type > 2)
                                        <button type="button" value="{{$v->id}}" class="btn btn-danger btn-sm mr-r delete">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    @endif
                                @endif
                                @if($subnav == 'finishpay')
                                @role(['admin'])
                                <a href="{{url('/payment/editPayable')}}?id={{$v->id}}" class="btn btn-danger btn-sm mr-r">编辑</a>
                                @if($v->type > 2)
                                    <button type="button" value="{{$v->id}}" class="btn btn-danger btn-sm mr-r delete">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                @endif
                                @endrole
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($payment)
        <div class="row">
            <div class="col-md-6 col-md-offset-6">{!! $payment->appends(['subnav' => $subnav, 'where' => $where, 'start_date' => $start_date, 'end_date' => $end_date, 'type' => $type])->render() !!}</div>
        </div>
        @endif
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection
