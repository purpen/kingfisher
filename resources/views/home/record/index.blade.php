@extends('home.base')

@section('title', '操作记录')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    @parent



@endsection

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
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class=""><a href="{{url('/record')}}">全部</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
	                    <li class="dropdown">
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
	</div>
	<div class="container mainwrap">
		<div class="row fz-0">
			<button type="button" class="btn btn-white" data-toggle="modal" data-target="#cityModal">+新增</button>

        </div>
		<div class="row">
			<div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                    	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>ID</th>
                        <th>用户</th>
                        <th>模型</th>
                        <th>事件</th>
                        <th>关联</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
					@foreach($records as $d)
						<tr id="item-{{$d->id}}">
							<td class="text-center"><input name="Order" type="checkbox"></td>
							<td class="magenta-color">{{$d->id}}</td>
							<td>{{$d->user->realname}}</td>
							<td>{{$d->type}}</td>
							<td>{{$d->evt}}</td>
							<td>{{ $d->target_id }}</td>
							<td>{{$d->remark}}</td>
                            <td>
                                --
							</td>
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


