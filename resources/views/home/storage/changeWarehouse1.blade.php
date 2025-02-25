@extends('home.base')

@section('title', '主管审核')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    {{--<script>--}}
    @parent
    var _token = $("#_token").val();

@endsection

@section('load_private')
    @parent
    $('#change-status').click(function () {
        var id = $(this).attr('value');
        $.post("{{url('/changeWarehouse/ajaxDirectorVerified')}}",{'_token':_token,'id':id},function (e) {
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
                        仓库调拨单
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li><a href="{{url('/changeWarehouse')}}">待审核 ({{$count_arr['count_0']}})</a></li>
                        <li class="active"><a href="{{url('/changeWarehouse/verify')}}">主管审核 ({{$count_arr['count_1']}})</a></li>
                        <li><a href="{{url('/changeWarehouse/completeVerify')}}">审核已完成</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="#" method="POST">
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
        <div class="row fz-0">
            <button type="button" class="btn btn-white mlr-2r">导出</button>
        </div>
        <div class="row">
            <div class="row scroll">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>调拨单编号</th>
                        <th>创建时间</th>
                        <th>创建人</th>
                        <th>审核人</th>
                        <th>审核时间</th>
                        <th>调出仓库</th>
                        <th>调入仓库</th>
                        <th>调拨状态</th>
                        <th>备注</th>
                        <th>操作</th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($change_warehouse as $purchase)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox"></td>
                            <td class="magenta-color">{{$purchase->number}}</td>
                            <td>{{$purchase->created_at_val}}</td>
                            <td>{{$purchase->user_name}}</td>
                            <td>{{$purchase->verify_name}}</td>
                            <td>{{$purchase->updated_at}}</td>
                            <td>{{$purchase->out_storage_name}}</td>
                            <td>{{$purchase->in_storage_name}}</td>
                            <td>{{$purchase->storage_status}}</td>
                            <td>{{$purchase->summary}}</td>
                            <td tdr="nochect"><button type="button" id="change-status" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r">审核通过</button>
                                <a href="{{url('/changeWarehouse/show')}}?id={{$purchase->id}}" class="magenta-color mr-r">详细</a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($change_warehouse)
                <div class="col-md-6 col-md-offset-6">{!! $change_warehouse->render() !!}</div>
            @endif
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
