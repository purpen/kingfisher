@extends('home.base')

@section('customize_css')
    @parent
    .bnonef {
    	padding:0;
    	box-shadow:none !important; 
    	background:none;
    	color:#fff !important;
    }
    #form-user,#form-product,#form-jyi,#form-beiz {
        height: 225px;
        overflow: scroll;
    }
    .scrollspy{
        height:180px;
        overflow: scroll;
        margin-top: 10px;
    }
    .table{
        width: 100%;
        border-collapse:collapse;
        border-spacing:0;
    }
    .fixedThead{
        display: block;
        width: 100%;
    }
    .scrollTbody{
        display: block;
        height: 300px;
        overflow: auto;
        width: 100%;
    }
    .table td,.table th {
        width: 200px;
        border-bottom: none;
        border-left: none;
        border-right: 1px solid #CCC;
        border-top: 1px solid #DDD;
        padding: 2px 3px 3px 4px
    }
    .table tr{
        border-left: 1px solid #EB8;
        border-bottom: 1px solid #B74;
    }
    tr.bone > td{
    border:none !important;
    border-bottom: 1px solid #ddd !important;
    }
@endsection

@section('content')
    @parent
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						会员管理
					</div>
				</div>
                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/orderUser/search')}}" method="POST">
                            <div class="form-group">
                                <input type="text" name="usernamePhone" class="form-control" placeholder="收件人/手机号">
                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            </div>
                            <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
			</div>

		</div>
		<div class="container mainwrap">
            @include('block.form-errors')
            <div class="row">
                <div class="form-inline">
                    <div class="form-group mr-2r">
                        <a class="btn btn-white" href="{{url('/orderUser/create')}}">
                            <i class="glyphicon glyphicon-edit"></i> 创建会员
                        </a>
                    </div>
                </div>
            </div>
			<div class="row scroll">
				<table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th>名称</th>
                            <th>类型</th>
                            <th>手机号</th>
                            <th colspan="3">详细地址</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orderUsers as $orderUser)
                        <tr>
                            <td>{{$orderUser->username}}</td>
                            <td>{{$orderUser->type_val}}</td>
                            <td>{{$orderUser->phone}}</td>
                            <td colspan="3">{{$orderUser->buyer_address}}</td>
                            <td tdr="nochect">
                                <a href="{{url('/orderUser/edit/')}}?id={{$orderUser->id}}" class="btn btn-gray btn-sm show-order" type="button" >详细</a>
                                <a href="{{url('/orderUser/destroy/')}}?id={{$orderUser->id}}" class="btn btn-default btn-sm delete-order">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                                @if($orderUser->type == 2)
                                    <a href="{{url('/salesStatistics/user')}}?id={{$orderUser->id}}" class="btn btn-gray btn-sm show-order" type="button" >销售记录</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
			</div>
            @if ($orderUsers)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">{!! $orderUsers->render() !!}</div>
            </div>
            @endif
		</div>
	</div>
    
@endsection
