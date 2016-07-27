@extends('home.base')

@section('title', '采购单')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    {{--<script>--}}
    @parent
    var _token = $("#_token").val();
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
    });

    $('#charge').click(function () {
        var id = $(this).attr('value');
        $.post('/payment/ajaxCharge',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });

    $('#reject').click(function () {
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
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        付款单
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="">待财务审核 ({{$count}})</a></li>
                        <li><a href="">应付款</a></li>
                        <li><a href="">已付款</a></li>
                        <li><a href="">坏账</a></li>
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
        <div class="row">
            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>采购单编号</th>
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
                            <td>{{$purchase->supplier}}</td>
                            <td>{{$purchase->storage}}</td>
                            <td>{{$purchase->count}}</td>
                            <td>{{$purchase->in_count}}</td>
                            <td>{{$purchase->price}}</td>
                            <td>{{$purchase->created_at}}</td>
                            <td>{{$purchase->user}}</td>
                            <td>{{$purchase->summary}}</td>
                            <td>
                                <button type="button" id="charge" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r">记账</button>
                                <button type="button" id="reject" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r">驳回</button>
                                <a href="{{url('/purchase/show')}}?id={{$purchase->id}}" class="magenta-color mr-r">详细</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($purchases)
                <div class="col-md-6 col-md-offset-6">{!! $purchases->render() !!}</div>
            @endif
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
