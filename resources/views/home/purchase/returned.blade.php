@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    采购退货单
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li @if ($tab_menu == 'waiting')class="active"@endif>
                        <a href="{{url('/returned')}}">待审核 @if($count['waiting']>0)<span class="badge">{{$count['waiting']}}</span>@endif</a>
                    </li>
                    <li @if ($tab_menu == 'approved')class="active"@endif>
                        <a href="{{url('/returned/returnedStatus')}}?verified=1">业管主管审核 @if($count['approved']>0)<span class="badge">{{$count['approved']}}</span>@endif</a>
                    </li>
                    <li @if ($tab_menu == 'finished')class="active"@endif>
                        <a href="{{url('/returned/returnedStatus')}}?verified=9">审核已完成</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/returned/search')}}" method="POST">
                            <div class="form-group">
                                <input type="text" name="q" value="{{$q}}" class="form-control" placeholder="采购退货单编号">
                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            </div>
                            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                @if (!$verified)
                <button type="button" class="btn btn-white ml-2r" id="verified">
                    <i class="glyphicon glyphicon-check"></i> 审核
                </button>
                @endif
            
                @if ($verified == 1)
                <button type="button" class="btn btn-white ml-2r" id="approved">
                    <i class="glyphicon glyphicon-ok"></i> 通过审批
                </button>
                <button type="button" class="btn btn-white ml-2r" id="rejected">
                    <i class="glyphicon glyphicon-remove"></i> 驳回审批
                </button>
                @endif
            
                <button type="button" class="btn btn-danger ml-2r">
                    <i class="glyphicon glyphicon-trash"></i> 删除
                </button>
                <button type="button" class="btn btn-white mlr-2r">
                    <i class="glyphicon glyphicon-arrow-up"></i> 导出
                </button>
                <button type="button" class="btn btn-white">
                    <i class="glyphicon glyphicon-arrow-down"></i> 导入
                </button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
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
                            <td class="text-center"><input name="Order" type="checkbox" value="{{ $returned->id }}"></td>
                            <td class="magenta-color">{{$returned->number}}</td>
                            <td>{{$returned->supplier_name}}</td>
                            <td>{{$returned->storage}}</td>
                            <td>{{$returned->count}}</td>
                            <td>{{$returned->out_count}}</td>
                            <td>{{$returned->price}}</td>
                            <td>{{$returned->created_at_val}}</td>
                            <td>{{$returned->user}}</td>
                            <td>{{$returned->summary}}</td>
                            <td>
                                <a href="{{url('/returned/show')}}?id={{$returned->id}}" class="btn btn-default btn-sm mr-r">详情</a>
                                {{--<a href="{{url('/returned/edit')}}?id={{$returned->id}}" class="btn btn-default btn-sm">编辑</a>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            @if ($returneds)
                <div class="col-md-12 text-center">{!! $returneds->render() !!}</div>
            @endif
        </div>
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();

@endsection

@section('load_private')
    @parent

    $(".delete").click(function() {
        if(confirm('确认删除订单？')){
            var id = [];
            $("input[name='Order']").each(function () {
                if ($(this).is(':checked')) {
                    id.push($(this).val());
                }
            });
            $.post('{{url('/returned/ajaxDestroy')}}',{'_token':_token,'id':id},function (e) {
                if (e.status) {
                    location.reload();
                } else if(e.status == 0){
                    alert(e.message);
                }
            },'json');
        }
    });

    $('#verified').click(function () {
        var id = [];
        $("input[name='Order']").each(function () {
            if ($(this).is(':checked')) {
                id.push($(this).val());
            }
        });
        $.post('/returned/ajaxVerified',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });

    $('#approved').click(function () {
        var id = [];
        $("input[name='Order']").each(function () {
            if ($(this).is(':checked')) {
                id.push($(this).val());
            }
        });
        $.post('/returned/ajaxDirectorVerified',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });

    $('#reject').click(function () {
        var id = [];
        $("input[name='Order']").each(function () {
            if ($(this).is(':checked')) {
                id.push($(this).val());
            }
        });
        $.post('/returned/ajaxDirectorReject',{'_token':_token, 'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });
@endsection