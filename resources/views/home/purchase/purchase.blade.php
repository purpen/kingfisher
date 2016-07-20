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
    $(".delete").click(function () {
        if(confirm('确认删除该订单？')){
            var id = $(this).attr('value');
            var de = $(this);
            $.post('{{url('/purchase/ajaxDestroy')}}',{'_token':_token,'id':id},function (e) {
                if(e.status){
                    de.parent().parent().remove();
                }
            },'json');
        }
    });

    $('#change-status').click(function () {
        var id = $(this).attr('value');
        $.post('/purchase/ajaxVerified',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();location.reload();
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
						采购单
					</div>
				</div>
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="{{url('/purchase')}}">待审核 ({{$count['count_0']}})</a></li>
                        <li><a href="{{url('/purchase/purchaseStatus')}}?verified=1">业管主管审核 ({{$count['count_1']}})</a></li>
                        <li><a href="{{url('/purchase/purchaseStatus')}}?verified=2">待财务审核 ({{$count['count_2']}})</a></li>
                        <li><a href="{{url('/purchase/purchaseStatus')}}?verified=9">审核已完成</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
	                    <li class="dropdown">
	                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/purchase/search') }}" method="POST">
	                            <div class="form-group">
	                                <input type="text" name="where" class="form-control" placeholder="采购单编号/制单人/供应商/仓库">
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
			<a href="{{ url('/purchase/create') }}">
				<button type="button" class="btn btn-white">新增采购单</button>
			</a>
            <button type="button" class="btn btn-white mlr-2r">导出</button>
            <button type="button" class="btn btn-white">导入</button>
        </div>
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
							<td><button type="button" id="change-status" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r">审核通过</button>
                                <a href="{{url('/purchase/show')}}?id={{$purchase->id}}" class="magenta-color mr-r">详细</a>
								<a href="{{url('/purchase/edit')}}?id={{$purchase->id}}" class="magenta-color mr-r">编辑</a>
								<a href="javascript:void(0)" value="{{$purchase->id}}" class="magenta-color delete">删除</a>
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
