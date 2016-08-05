@extends('home.base')

@section('title', '库存监控')

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
                        库存监控
                    </div>
                </div>
                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/storageSkuCount/list')}}" method="POST">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="请输入商品货号">
                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            </div>
                            <button id="search" type="submit" class="btn btn-default">搜索</button>
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
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>商品货号</th>
                        <th>SKU编码</th>
                        <th>商品名称</th>
                        <th>商品属性</th>
                        <th>库存数量</th>
                        <th>仓库</th>
                        <th>库存上限</th>
                        <th>库存下限</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($storageSkuCounts as $k=>$v)
                            <tr>
                                <th class="text-center"><input type="checkbox"></th>
                                <th>{{$v->snumber}}</th>
                                <th>{{$v->number}}</th>
                                <th>{{$v->title}}</th>
                                <th>{{$v->mode}}</th>
                                <th>{{$v->quantity}}</th>
                                <th>{{$v->sname}}</th>
                                <th>{{$v->max_count}}</th>
                                <th>{{$v->min_count}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

@endsection