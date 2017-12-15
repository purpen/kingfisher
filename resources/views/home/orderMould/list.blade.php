@extends('home.base')

@section('customize_js')
    @parent
    {{--<script>--}}

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
    };

@endsection


@section('load_private')
    @parent

    $(".delete").click(function () {
        if(confirm('确认删除该订单？')){
            var id = $(this).attr('value');
            var de = $(this);
            $.post('{{url('/orderMould/deleted')}}',{'_token':_token,'id':id},function (e) {
                if(e.status){
                    de.parent().parent().remove();
                }
            },'json');
        }
    });

@endsection
@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					订单模版列表
				</div>
			</div>
			<div class="navbar-collapse collapse">
                @include('home.orderMould.subnav')
            </div>
		</div>
	</div>
	<div class="container mainwrap">
		<div class="row fz-0">
            <div class="col-md-12">
    			<a href="{{ url('/orderMould/create') }}" class="btn btn-white mr-2r">
    				<i class="glyphicon glyphicon-edit"></i> 新增订单模版
    			</a>
            </div>
        </div>
		<div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                        	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>ID</th>
                            <th>名称</th>
                            <th>类型</th>
                            <th>创建人</th>
                            <th>创建时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
    				@foreach($orderMoulds as $d)
    					<tr>
    						<td class="text-center"><input name="Order" type="checkbox" id="item-{{$d->id}}"></td>
    						<td class="magenta-color">{{$d->id}}</td>
    						<td>{{$d->name}}</td>
                <td>
                  @if($d->type == 1)
                    <span>渠道</span>
                  @else
                    <span>品牌</span>
                  @endif
                </td>
    						<td>{{$d->user->account}}</td>
                <td>{{ $d->created_at_val }}</td>
                <td>
                    @if($d->status == 1)
                        <span class="label label-success">启用</span>
                    @else
                        <span class="label label-warning">禁用</span>
                    @endif
                </td>
    						<td tdr="nochect">
    							<a href="{{url('/orderMould/edit')}}/{{$d->id}}" class="magenta-color mr-r">编辑</a>
    							<a href="javascript:void(0)" value="{{$d->id}}" class="magenta-color delete">删除</a>

    						</td>
    					</tr>
    				@endforeach
                    </tbody>
                </table>
            </div>
	   </div>

    </div>

@endsection
