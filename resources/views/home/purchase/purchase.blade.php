@extends('home.base')

@section('title', '采购单')

@section('customize_css')
    @parent

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
                        <li class="active"><a href="#">待采购审核 (1)</a></li>
                        <li><a href="#">待财务审核 (1)</a></li>
                        <li><a href="#">审核已完成</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
	                    <li class="dropdown">
	                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/purchase/search') }}" method="POST">
	                            <div class="form-group">
	                                <input type="text" name="name" class="form-control" placeholder="采购单编号/制单人/供应商/仓库">
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
						<tr>
							<td class="text-center"><input name="Order" type="checkbox"></td>
							<td class="magenta-color">CG201605230001</td>
							<td>sony</td>
							<td>sony</td>
							<td>10</td>
							<td>0</td>
							<td>1000</td>
							<td>2016-07-07 11:11:11</td>
							<td>sony</td>
							<td></td>
							<td><button type="button" class="btn btn-white btn-sm mr-r">审核通过</button>
								<a href="#" class="magenta-color mr-r">详情</a>
								<a href="#" class="magenta-color">删除</a>
							</td>
						</tr>
                    </tbody>
                </table>
		</div>
	</div>
@endsection

@section('customize_js')
    @parent
	$("#checkAll").click(function () {
        $("input[name='Order']:checkbox").prop("checked", this.checked);
    });
@endsection