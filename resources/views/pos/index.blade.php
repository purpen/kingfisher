@extends('layout.app')

@section('customize_css')
    @parent
    .goodsbox {
        min-height: 300px;
    }
    .total {
        line-height: 38px;
    }
@endsection

@section('header')
    @parent
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
        
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand logo" href="{{ url('/') }}">
                    <img id="logo" src="{{ url('images/logo.png') }}" class="img-responsive" alt="logo" title="logo">
                </a>
            </div>

            <div class="navbar-collapse collapse" id="app-navbar-collapse">


                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right mr-0">

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                       <li class="dropdown">
                            <a href="{{ url('/login') }}" class="transparent btn-magenta btn"> 登录</a>
                            <a href="{{ url('/register') }}" class="transparent btn-magenta btn"> 注册</a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-bell"></span>
                            </a>
                            <ul class="dropdown-menu mr-r" aria-labelledby="dropdownMenu7">
                                <li>
                                    <div class="ptb-4r plr-4r">
                                        暂时没有新的提醒哦 ...
                                    </div>
                                </li>
                            </ul>
                        </li>
                    
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="user img-circle" src="{{ Auth::user()->cover ?  Auth::user()->cover->file->small : url('images/default/headportrait.jpg') }}" align="absmiddle"> {{Auth::user()->account}}
                                <span class="glyphicon glyphicon-menu-down"></span>
                            </a>
                            <ul class="dropdown-menu mr-3r" aria-labelledby="dropdownMenu8">
                                <li><a href="{{ url('/user/edit') }}">个人资料</a></li>
                                <li><a href="{{url('/logout')}}">退出</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

            </div>
        </div>
    </nav>
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="console">
                        <h5>欢迎使用太火鸟POS系统</h5>
                        <hr>
                        
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">销售单号：</label> 自动生成
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">销售人员：</label> {{ Auth::user()->account }}
                                </div>
                                <div class="col-sm-6 text-right">
                                    <label class="control-label">销售日期：</label>
                                    
                                </div>
                            </div>
                            
                            
                            <div class="goodsbox">
                				<table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr class="gblack">
                                            <th class="text-center">序号</th>
                                            <th>
                                            	编码
                                            </th>
                                            <th>
                                            	商品名称
                                            </th>
                                            <th>
                                                单价
                                            </th>
                                            <th>
                                                数量
                                            </th>
                                            <th>折扣</th>
                                            <th>
                                                金额
                                            </th>
                                            <th>
                                                备注
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="goodslist">
                                
                                    </tbody>
                                </table>
                            </div>
                            
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" placeholder="输入或扫描编码">
                                        <span class="input-group-btn">
                                            <button class="btn btn-magenta" type="button">确认</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center text-danger total">
                                    <label class="control-label mr-3r">数量：<span id="total-count">3</span> 个</label> 
                                    <label class="control-label">共计：<span id="total-count">300</span> 元</label>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <button class="btn btn-magenta btn-lg" type="button">
                                        <i class="glyphicon glyphicon-check"></i> 结算
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
		</div>
    </div>
@endsection

@section('footer')
    @parent
    @include('block.footer')
@endsection