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
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        销售统计
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li ><a href="{{url('/userSaleStatistics/index')}}">销售人员</a></li>
                        <li class="active"><a href="{{url('/userSaleStatistics/department')}}">部门</a></li>
                    </ul>
                </div>

                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/userSaleStatistics/department')}}" method="POST">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group mr-2r">
                                <label class="control-label">快速查看：</label>
                                <a href="{{url('userSaleStatistics/department')}}?time=7" class="btn btn-link">最近7天</a>
                                <a href="{{url('userSaleStatistics/department')}}?time=30" class="btn btn-link">最近30天</a>
                            </div>
                            <div class="form-group mr-2r">
                                <label class="control-label">筛选日期：</label>
                                <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期">
                                至
                                <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default">查询</button>
                                    </div><!-- /btn-group -->
                                </div><!-- /input-group -->
                            </div>
                        </form>
                    </li>
                </ul>
                <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="showtext"></strong>
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th>部门</th>
                        <th>销售金额</th>
                        <th>已收金额</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($department_list as $department)
                        <tr>
                            <td>
                                @if($department->department == 0)
                                    默认
                                @elseif($department->department == 1)
                                    fiu
                                @elseif($department->department == 2)
                                    D3IN
                                @elseif($department->department == 3)
                                    海外
                                @endif
                            </td>
                            <td>{{ $department->money_sum }}</td>
                            <td>{{ $department->received_sum }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('customize_js')
    @parent

@endsection