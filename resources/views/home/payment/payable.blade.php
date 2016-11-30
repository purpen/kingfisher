@extends('home.base')

@section('title', '应付款列表')

@section('customize_js')
    @parent
    var _token = $("#_token").val();
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
    
    $(".payment").click(function () {
        var arr_id = [];
        arr_id.push($(this).val());
        $.post('/payment/ajaxConfirmPay', {'_token': _token, 'arr_id': arr_id}, function (e) {
            if (e.status) {
                location.reload();
            } else if (e.status == 0) {
                alert(e.message);
            }
        }, 'json');
    });
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
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
    </div>
    
    <div class="container mainwrap">
        <div class="row fz-0">
            <button type="button" id="confirm-pay" class="btn btn-white mlr-2r">
                审核
            </button>
        </div>
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th class="text-center"><input type="checkbox" id="checkAll"></th>
                    <th>付款单号</th>
                    <th>收款人</th>
                    <th>应付金额</th>
                    <th>收支类型</th>
                    <th>相关单据</th>
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
                        <td>{{$v->type}}</td>
                        <td>{{$v->target_number}}</td>
                        <td>{{$v->summary}}</td>
                        <td>{{$v->user->realname}}</td>
                        <td>{{$v->created_at_val}}</td>
                        <td>
                            <button type="button" id="" value="{{$v->id}}" class="btn btn-white btn-sm mr-r payment">确认付款</button>
                            <a href="{{url('/payment/editPayable')}}?id={{$v->id}}" class="magenta-color mr-r">查看详情</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($payment)
                <div class="col-md-6 col-md-offset-6">{!! $payment->render() !!}</div>
            @endif
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
