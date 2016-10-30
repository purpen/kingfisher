@extends('home.base')

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
                    @include('home.storage.exchange_subnav')
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row fz-0">
			<div class="form-inline">
				<div class="form-group mr-2r">
                    <a href="{{ url('/changeWarehouse/create') }}" class="btn btn-white">
                        <i class="glyphicon glyphicon-edit"></i> 创建调拨单
                    </a>
                    <button type="button" id="batch-verify" class="btn btn-white mlr-r">
                        <i class="glyphicon glyphicon-ok"></i> 批量审批
                    </button>
                    <button type="button" id="batch-remove" class="btn btn-danger mlr-r">
                        <i class="glyphicon glyphicon-trash"></i> 删除
                    </button>
				</div>
				<div class="form-group mr-2r">
					<button type="button" class="btn btn-gray">
						<i class="glyphicon glyphicon-arrow-up"></i> 导出
					</button>
					<button type="button" class="btn btn-gray ml-r">
						<i class="glyphicon glyphicon-arrow-down"></i> 导入
					</button>
				</div>
			</div>
        </div>
        
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th class="text-center"><input type="checkbox" id="checkAll"></th>
                    <th class="text-center">调拨状态</th>
                    <th>调拨单编号</th>
                    <th>创建时间</th>
                    <th>创建人</th>
                    <th>审核人</th>
                    <th>审核时间</th>
                    <th>调出仓库</th>
                    <th>调入仓库</th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($change_warehouse as $purchase)
                    <tr>
                        <td class="text-center"><input name="Order" type="checkbox"></td>
                        <td class="text-center">
                            <span class="label label-danger">{{$purchase->storage_status}}</span>
                        </td>
                        <td class="magenta-color">{{$purchase->number}}</td>
                        <td>{{$purchase->created_at_val}}</td>
                        <td>{{$purchase->user_name}}</td>
                        <td>{{$purchase->verify_name}}</td>
                        <td>{{$purchase->updated_at}}</td>
                        <td>{{$purchase->out_storage_name}}</td>
                        <td>{{$purchase->in_storage_name}}</td>
                        <td>{{$purchase->summary}}</td>
                        <td tdr="nochect">
                            <a href="{{url('/changeWarehouse/show')}}?id={{$purchase->id}}" class="btn btn-default btn-sm mr-r">查看</a>
                            @if (!$purchase->verified)
                            <button type="button" id="change-status" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r">
                                <i class="glyphicon glyphicon-ok"></i> 确认调拨
                            </button>
                            <a href="{{url('/changeWarehouse/edit')}}?id={{$purchase->id}}" class="btn btn-default btn-sm mr-r">编辑</a>
                            @endif
                            
                            @if ($purchase->verified == 1)
                            <button type="button" id="verify-status" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r">
                                <i class="glyphicon glyphicon-ok"></i> 主管审批
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($change_warehouse)
        <div class="row">
            <div class="col-md-6 col-md-offset-6">{!! $change_warehouse->render() !!}</div>
        </div>
        @endif
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection


@section('customize_js')
    @parent
    
    var _token = $("#_token").val();
    
    $(".delete").click(function () {
        if(confirm('确认删除该订单？')){
            var id = $(this).attr('value');
            var de = $(this);
            $.post('{{url('/changeWarehouse/ajaxDestroy')}}',{'_token':_token,'id':id},function (e) {
                if(e.status){
                    de.parent().parent().remove();
                }
            },'json');
        }
    });

    $('#change-status').click(function () {
        var id = $(this).attr('value');
        $.post('/changeWarehouse/ajaxVerified',{'_token':_token,'id':id},function (e) {
            if(e.status){
                location.reload();
            }else if(e.status == 0){
                alert(e.message);
            }
        },'json');
    });
    
    $('#verify-status').click(function () {
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
