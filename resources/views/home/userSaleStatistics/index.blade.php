@extends('home.base')

@section('customize_css')
    @parent
    .check-btn{
    padding: 10px 0;
    height: 30px;
    position: relative;
    margin-bottom: 10px !important;
    margin-left: 10px !important;
    }
    .check-btn input{
    z-index: 2;
    width: 100%;
    height: 100%;
    top: 6px !important;
    opacity: 0;
    left: 0;
    margin-left: 0 !important;
    color: transparent;
    background: transparent;
    cursor: pointer;
    }
    .check-btn button{
    position: relative;
    top: -11px;
    left: 0;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    销售排行
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/userSaleStatistics/index')}}" method="POST">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group mr-2r">
                                <a href="{{url('userSaleStatistics/index')}}?time=7" class="btn btn-link">最近7天</a>
                                <a href="{{url('userSaleStatistics/index')}}?time=30" class="btn btn-link">最近30天</a>
                            </div>
                            <div class="form-group mr-2r">
                                <label class="control-label">日期：</label>
                                <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期">
                                至
                                <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="where" class="form-control">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default">搜索</button>
                                    </div><!-- /btn-group -->
                                </div><!-- /input-group -->
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-12">
                    <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong id="showtext"></strong>
                    </div>
                
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th>用户ID</th>
                            <th>账号 / 姓名</th>
                            <th>手机号</th>
                            <th>销售金额</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($user_list as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="magenta-color">{{ $user->account }} @if ($user->realname) / {{ $user->realname }} @endif</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->money_sum }}</td>
                                <td>
                                    <a href="{{url('/order/userSaleList')}}?user_id_sales={{$user->id}}">
                                        <button class="btn btn-default btn-sm" >详细</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customize_js')
    @parent

@endsection