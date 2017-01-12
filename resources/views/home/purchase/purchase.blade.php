@extends('home.base')

@section('customize_js')
    @parent
    {{--删除订单--}}
    var _token = $("#_token").val();

    {{--获取选中input框的id属性值--}}
    var getOnInput = function () {
        var id = [];
        $("input[name='Order']").each(function () {
            if($(this).is(':checked')){
                id.push($(this).attr('id'));
            }
        });
        return id;
    }

@endsection


@section('load_private')
    @parent
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

    {{--创建者审核--}}
    $("#verified").click(function () {
        var id = getOnInput();
        $.post('/purchase/ajaxVerified',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });

    {{--主管领导驳回审核--}}
    $('#rejected').click(function () {
        var id = getOnInput();
        $.post('{{url('/purchase/ajaxDirectorReject')}}',{'_token': _token,'id': id}, function (e) {
            if(e.status){
                location.reload();
            }else{
                alert(e.message);
            }
        },'json');
    });

    {{--主管领导通过审核--}}
    $('#approved').click(function () {
        var id = getOnInput();
        $.post('{{url('/purchase/ajaxDirectorVerified')}}',{'_token': _token,'id': id}, function (e) {
            if(e.status){
                location.reload();
            }else{
                alert(e.message);
            }
        },'json');
    });


    $("#returned").click(function () {
        var id = getOnInput();
        $.post('{{url('/purchase/ajaxReturned')}}',{'_token': _token,'id': id}, function (e) {
            if(e.status){
                location.href = e.data;
            }else{
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
					采购单列表
				</div>
			</div>
			<div class="navbar-collapse collapse">
                @include('home.purchase.subnav')
            </div>
		</div>
	</div>
	<div class="container mainwrap">
		<div class="row fz-0">
            <div class="col-md-12">
    			<a href="{{ url('/purchase/create') }}" class="btn btn-white mr-2r">
    				<i class="glyphicon glyphicon-edit"></i> 新增采购单
    			</a>
                @if (!$verified)
                <button type="button" class="btn btn-success mr-2r" id="verified">
                    <i class="glyphicon glyphicon-check"></i> 审核
                </button>
                @endif
            
                @if ($verified == 1)
                <button type="button" class="btn btn-success mr-2r" id="approved">
                    <i class="glyphicon glyphicon-ok"></i> 通过审批
                </button>
                <button type="button" class="btn btn-warning mr-2r" id="rejected">
                    <i class="glyphicon glyphicon-remove"></i> 驳回审批
                </button>
                @endif
                @if ($verified == 9)
                <button type="button" class="btn btn-danger mr-2r" id="returned">
                    <i class="glyphicon glyphicon-share"></i> 采购退货
                </button>
                @endif
                <button type="button" class="btn btn-white mr-2r">
                    <i class="glyphicon glyphicon-arrow-up"></i> 导出
                </button>
                <button type="button" class="btn btn-white mr-2r">
                    <i class="glyphicon glyphicon-arrow-down"></i> 导入
                </button>
            </div>
        </div>
		<div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                        	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                            @if($verified != 9)
                            <th>审核状态</th>
                            @endif
                            @if($verified == 9)
                            <th>入库状态</th>
                            @endif
                            <th>单据编号</th>
                            <th>类型</th>
                            <th>供应商</th>
                            <th>仓库</th>
                            <th>采购数量</th>

                            @if($verified == 9)
                                <th>已入库数量</th>
                            @endif
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
                            @if($verified != 9)
                            <th>
                                @if($purchase->verified == 0)
                                    <span class="label label-default">未审核</span>
                                @endif
                                @if($purchase->verified == 1)
                                    <span class="label label-danger">待审核</span>
                                @endif
                                @if($purchase->verified == 9)
                                    <span class="label label-success">通过审核</span>
                                @endif
                            </th>
                            @endif
                            @if($verified == 9)
                            <th>
                                @if($purchase->storage_status == 0)
                                    <span class="label label-default">未入库</span>
                                @endif
                                @if($purchase->storage_status == 1)
                                    <span class="label label-warning">入库中</span>
                                @endif
                                @if($purchase->storage_status == 5)
                                    <span class="label label-success">已入库</span>
                                @endif
                            </th>
                            @endif
    						<td class="magenta-color">{{$purchase->number}}</td>
                            <td>{{$purchase->supplier_type_val}}</td>
    						<td>{{$purchase->supplier_name}}</td>
    						<td>{{$purchase->storage}}</td>
    						<td>{{$purchase->count}}</td>
                            @if($verified == 9)
                                <td>{{$purchase->in_count}}</td>
                            @endif

    						<td>{{$purchase->price}}元</td>
    						<td>{{$purchase->created_at_val}}</td>
    						<td>{{$purchase->user}}</td>
    						<td>{{$purchase->summary}}</td>
    						<td tdr="nochect">
                                <a href="{{url('/purchase/show')}}?id={{$purchase->id}}" class="magenta-color mr-r">查看详情</a>
                                @if($verified != 9)
    							<a href="{{url('/purchase/edit')}}?id={{$purchase->id}}" class="magenta-color mr-r">编辑</a>
    							<a href="javascript:void(0)" value="{{$purchase->id}}" class="magenta-color delete">删除</a>
                                @endif
                                @if($verified == 9)
                                    @role(['admin'])
                                    <a href="javascript:void(0)" value="{{$purchase->id}}" class="magenta-color delete">删除</a>
                                    @endrole
                                @endif
    						</td>
    					</tr>
    				@endforeach
                    </tbody>
                </table>
            </div>
	   </div>
        @if ($purchases)
        <div class="row">
            <div class="col-md-12 text-center">{!! $purchases->appends(['where' => $where])->render() !!}</div>
        </div>
        @endif
    </div>
@endsection
