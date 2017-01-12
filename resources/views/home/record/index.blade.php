@extends('home.base')

@section('title', '操作记录')

@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						操作记录
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		<div class="row">
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
        @if ($records)
            <div class="col-md-6 col-md-offset-6">{!! $records->render() !!}</div>
        @endif
	</div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection