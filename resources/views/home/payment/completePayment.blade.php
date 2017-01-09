@extends('home.base')

@section('title', '已付款')

@section('customize_js')
    @parent
    var _token = $("#_token").val();
    $("#checkAll").click(function () {
        $("input[name='Order']:checkbox").prop("checked", this.checked);
    });
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
                            <td>@if($v->purchase)【{{$v->purchase->supplier_type_val}}】@endif{{$v->type_val}}</td>
                            <td>{{$v->target_number}}</td>
                            <td>@if($v->receive_order) <a target="_blank" href="{{ url('/receive/search') }}?receive_number={{$v->receive_order->number}}&subnav=finishReceive">{{$v->receive_order->number}}</a> @endif</td>
                            <td>{{$v->summary}}</td>
                            <td>@if($v->user){{$v->user->realname}} @else 自动同步 @endif</td>
                            <td>{{ $v->created_at_val }}</td>
                            <td>
                                <a href="{{url('/payment/detailedPayment')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">查看</a>
                                @role(['admin'])
                                <a href="{{url('/payment/editPayable')}}?id={{$v->id}}" class="magenta-color mr-r">编辑</a>
                                @endrole
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row"> 
            @if ($payment)
            <div class="col-md-6 col-md-offset-6">{!! $payment->appends(['subnav' => $subnav, 'where' => $where, 'start_date' => $start_date, 'end_date' => $end_date, 'type' => $type])->render() !!}</div>
            @endif
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection
