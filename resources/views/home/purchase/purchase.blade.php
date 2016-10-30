@extends('home.base')

@section('customize_js')
    @parent
    var _token = $("#_token").val();
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

    $("#verified").click(function () {
        var id = [];
        $("input[name='Order']").each(function () {
            if ($(this).is(':checked')) {
                id.push($(this).attr('id'));
            }
        });
        $.post('/purchase/ajaxVerified',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });
    
    $('#rejected').click(function () {
        var id = [];
        $("input[name='Order']").each(function () {
            if($(this).is(':checked')){
                id.push($(this).attr('id'));
            }
            $.post('{{url('/purchase/ajaxDirectorReject')}}',{'_token': _token,'id': id}, function (e) {
                if(e.status){
                    location.reload();
                }else{
                    alert(e.message);
                }
            },'json');
        });
    });
    
    $('#change-status').click(function () {
        var id = $(this).attr('value');
        $.post('/purchase/ajaxDirectorVerified',{'_token':_token,'id':[id]},function (e) {
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
						采购单列表
					</div>
				</div>
				<div class="navbar-collapse collapse">
                    @include('home.purchase.subnav')
                </div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		<div class="row fz-0">
			<a href="{{ url('/purchase/create') }}" class="btn btn-white">
				<i class="glyphicon glyphicon-edit"></i> 新增采购单
			</a>
            @if (!$verified)
            <button type="button" class="btn btn-white ml-2r" id="verified">
                <i class="glyphicon glyphicon-check"></i> 批量审核
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
            
            <button type="button" class="btn btn-warning ml-2r">
                <i class="glyphicon glyphicon-share"></i> 采购退货
            </button>
            
            <button type="button" class="btn btn-white ml-2r">
                <i class="glyphicon glyphicon-arrow-up"></i> 导出
            </button>
            <button type="button" class="btn btn-white ml-r">
                <i class="glyphicon glyphicon-arrow-down"></i> 导入
            </button>
        </div>
		<div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="gblack">
                    	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>审核状态</th>
                        <th>入库状态</th>
                        <th>单据编号</th>
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
						<td class="text-center"><input name="Order" type="checkbox" id="{{$purchase->id}}"></td>
                        <th>{{$purchase->verified_val}}</th>
                        <th>{{$purchase->storage_status_val}}</th>
						<td class="magenta-color">{{$purchase->number}}</td>
						<td>{{$purchase->supplier}}</td>
						<td>{{$purchase->storage}}</td>
						<td>{{$purchase->count}}</td>
						<td>{{$purchase->in_count}}</td>
						<td>{{$purchase->price}}元</td>
						<td>{{$purchase->created_at_val}}</td>
						<td>{{$purchase->user}}</td>
						<td>{{$purchase->summary}}</td>
						<td tdr="nochect">
                            
                            <button type="button" id="change-status" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r">
                                审核通过
                            </button>
                            
                            <a href="{{url('/purchase/show')}}?id={{$purchase->id}}" class="magenta-color mr-r">查看详情</a>
							<a href="{{url('/purchase/edit')}}?id={{$purchase->id}}" class="magenta-color mr-r">编辑</a>
							<a href="javascript:void(0)" value="{{$purchase->id}}" class="magenta-color delete">删除</a>
						</td>
					</tr>
				@endforeach
                </tbody>
            </table>
	   </div>
        @if ($purchases)
        <div class="row">
            <div class="col-md-6 col-md-offset-6">{!! $purchases->render() !!}</div>
        </div>
        @endif
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
