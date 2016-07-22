@extends('home.base')

@section('title', '采购退货单')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    {{--<script>--}}
    @parent
    var _token = $("#_token").val();
    $(".delete").click(function () {
        if(confirm('确认删除该订单？')){
            var id = $(this).attr('value');
            var de = $(this);
            $.post('{{url('/returned/ajaxDestroy')}}',{'_token':_token,'id':id},function (e) {
                if(e.status){
                    de.parent().parent().remove();
                }
            },'json');
        }
    });
    $('#change-status').click(function () {
        var id = $(this).attr('value');
        $.post('/returned/ajaxVerified',{'_token':_token,'id':id},function (e) {
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
                        采购退货单
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="{{url('/returned')}}">待审核 ({{$count['count_0']}})</a></li>
                        <li><a href="{{url('/returned/returnedStatus')}}?verified=1">业管主管审核 ({{$count['count_1']}})</a></li>
                        <li><a href="{{url('/returned/returnedStatus')}}?verified=9">审核已完成</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="" method="POST">
                                <div class="form-group">
                                    <input type="text" name="where" class="form-control" placeholder="采购退货单编号">
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
            <a href="{{ url('/returned/create') }}">
                <button type="button" class="btn btn-white">新增退货单</button>
            </a>
            <button type="button" class="btn btn-white mlr-2r">导出</button>
            <button type="button" class="btn btn-white">导入</button>
        </div>
        <div class="row">
            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>采购单退货编号</th>
                        <th>供应商</th>
                        <th>仓库</th>
                        <th>退货数量</th>
                        <th>已出库数量</th>
                        <th>退货总额</th>
                        <th>创建时间</th>
                        <th>制单人</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($returneds as $returned)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox"></td>
                            <td class="magenta-color">{{$returned->number}}</td>
                            <td>{{$returned->supplier}}</td>
                            <td>{{$returned->storage}}</td>
                            <td>{{$returned->count}}</td>
                            <td>{{$returned->out_count}}</td>
                            <td>{{$returned->price}}</td>
                            <td>{{$returned->created_at}}</td>
                            <td>{{$returned->user}}</td>
                            <td>{{$returned->summary}}</td>
                            <td><button type="button" id="change-status" value="{{$returned->id}}" class="btn btn-white btn-sm mr-r">审核通过</button>
                                <a href="{{url('/returned/show')}}?id={{$returned->id}}" class="magenta-color mr-r">详情</a>
                                <a href="{{url('/returned/edit')}}?id={{$returned->id}}" class="magenta-color mr-r">编辑</a>

                                <a href="javascript:void(0)" value="{{$returned->id}}" class="magenta-color delete">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($returneds)
                <div class="col-md-6 col-md-offset-6">{!! $returneds->render() !!}</div>
            @endif
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
