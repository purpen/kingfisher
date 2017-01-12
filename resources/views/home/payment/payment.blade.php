@extends('home.base')

@section('title', '待财务审核')

@section('customize_js')
    @parent
    var _token = $("#_token").val();

@endsection

@section('load_private')
    @parent
    $("#checkAll").click(function () {
        $("input[name='Order']:checkbox").prop("checked", this.checked);
    });

    $('.charge').click(function () {
        var id = $(this).attr('value');
        $.post('/payment/ajaxCharge',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });

    $('.reject').click(function () {
        var id = $(this).attr('value');
        $.post('/payment/ajaxReject',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
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
                            <th>采购单编号</th>
                            <th>类型</th>
                            <th>供应商</th>
                            <th>仓库</th>
                            <th>采购数量</th>
                            <th>已入库数量</th>
                            <th>采购总额</th>
                            <th>创建时间</th>
                            <th>制单人</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox"></td>
                            <td class="magenta-color">{{$purchase->number}}</td>
                            <td>{{$purchase->supplier_type_val}}</td>
                            <td>{{$purchase->supplier_name}}</td>
                            <td>{{$purchase->storage}}</td>
                            <td>{{$purchase->count}}</td>
                            <td>{{$purchase->in_count}}</td>
                            <td>{{$purchase->price}}元</td>
                            <td>{{$purchase->created_at_val}}</td>
                            <td>{{$purchase->user}}</td>
                            <td>{{$purchase->summary}}</td>
                            <td>
                                <a href="{{url('/purchase/show')}}?id={{$purchase->id}}" class="btn btn-white btn-sm mr-r">查看详情</a>
                                <button type="button" id="charge" value="{{$purchase->id}}" class="btn btn-success btn-sm mr-r charge">记账</button>
                                <button type="button" id="reject" value="{{$purchase->id}}" class="btn btn-warning btn-sm mr-r reject">驳回</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            @if ($purchases)
                <div class="col-md-12 text-center">{!! $purchases->render() !!}</div>
            @endif
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection
