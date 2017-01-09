@extends('home.base')

@section('title', '操作记录')

@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					操作记录
				</div>
			</div>
			<div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/record/search') }}" method="POST">
                            <div class="form-group">
                                <input type="text" name="where" class="form-control" placeholder="名称">
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
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                    	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>操作用户</th>
                        <th>模型</th>
                        <th>行为事件</th>
                        <th>关联对象</th>
    					<th>操作时间</th>
                        <th>备注</th>
                    </tr>
                    </thead>
                    <tbody>
    				@foreach($records as $d)
    					<tr id="item-{{$d->id}}">
    						<td class="text-center"><input name="Order" type="checkbox" value="{{$d->id}}"></td>
    						<td class="magenta-color">
    							@if ($d->user_id == 0)
    								自动下载
    							@else
    								{{ $d->user->realname }}
    							@endif
    						</td>
    						<td>{{$d->type_val}}</td>
    						<td>{{$d->evt_val}}</td>
    						<td>{{ $d->target_id_val }}</td>
    						<td>{{$d->created_at_val}}</td>
    						<td>{{$d->remark}}</td>
    					</tr>
    				@endforeach
                    </tbody>
                </table>
            </div>
		</div>
        <div class="row">
            @if ($records)
                <div class="col-md-12 text-center">{!! $records->render() !!}</div>
            @endif
        </div>
	</div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection