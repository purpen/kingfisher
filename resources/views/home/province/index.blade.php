@extends('home.base')

@section('title', '省份管理')

@section('customize_css')
    @parent

@endsection

@section('customize_js')

@endsection

@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						省份管理
					</div>
				</div>
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="{{url('/province')}}">省份列表</a></li>
                        <li class=""><a href="{{url('/city')}}">城市列表</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
	                    <li class="dropdown">
	                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/province/search') }}" method="POST">
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
			<a href="{{ url('/province/create') }}">
				<button type="button" class="btn btn-white mr-2r">新增省份</button>
			</a>
			<a href="{{ url('/city/create') }}">
				<button type="button" class="btn btn-white">新增城市</button>
			</a>

        </div>
		<div class="row">
			<div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                    	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>编号</th>
                        <th>名称</th>
                        <th>类型</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
					@foreach($provinces as $d)
						<tr>
							<td class="text-center"><input name="Order" type="checkbox"></td>
							<td class="magenta-color">{{$d->number}}</td>
							<td>{{$d->name}}</td>
							<td>{{$d->type}}</td>
							<td>{{$d->status}}</td>
                            <td>
								<a href="{{url('/province/edit')}}?id={{$d->id}}" class="magenta-color mr-r">编辑</a>
								<a href="javascript:void(0)" value="{{$d->id}}" class="magenta-color delete">删除</a>
							</td>
						</tr>
					@endforeach
                    </tbody>
                </table>
		</div>
            @if ($provinces)
                <div class="col-md-6 col-md-offset-6">{!! $provinces->render() !!}</div>
            @endif
	</div>
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection

