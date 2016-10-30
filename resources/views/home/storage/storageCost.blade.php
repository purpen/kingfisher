@extends('home.base')

@section('title', '库存成本')

@section('customize_css')
    @parent
    .operate-update-offlineEshop,.operate-update-offlineEshop:hover,.btn-default.operate-update-offlineEshop:focus{
    border: none;
    display: inline-block;
    background: none;
    box-shadow: none !important;
    }
@endsection

@section('content')
    @parent

    @include('block.errors')

    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        库存成本
                    </div>
                </div>
                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/storageSkuCount/search')}}" method="post">
                            <div class="form-group">
                                <input type="text" name="product_number" class="form-control" placeholder="请输入商品货号">
                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            </div>
                            <button id="search" type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        库存成本<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @foreach($storageCounts as $k =>$v)
                        <li><a href="#">{{'仓库：' . $k . ' 共 ' . $v . '元'}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
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
                        <th>金额</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($storageSkuCounts as $v)
                        <tr>
                            <th class="text-center"><input type="checkbox"></th>
                            <th>{{$v->product_number}}</th>
                            <th>{{$v->ProductsSku->number}}</th>
                            <th>{{$v->Products->title}}</th>
                            <th>{{$v->ProductsSku->mode}}</th>
                            <th>{{$v->count}}</th>
                            <th>{{$v->Storage->name}}</th>
                            <th>{{$v->count * $v->ProductsSku->cost_price}} 元</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('customize_js')
    {{--<script>--}}
        @parent

@endsection