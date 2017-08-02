@extends('home.base')

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
            <div class="navbar-header">
                <div class="navbar-brand">
                    库存成本
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li @if($storage_id == '')class="active"@endif><a href="{{url('/storageSkuCount/storageCost')}}">全部库存</a></li>
                    @foreach($storages as $storage)
                    <li @if($storage_id == $storage->id)class="active"@endif><a href="{{url('/storageSkuCount/storageCost')}}?id={{$storage->id}}">{{$storage->name}}</a></li>
                    @endforeach
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/storageSkuCount/storageCostSearch')}}" method="post">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="product_number" value="{{$number}}" class="form-control" placeholder="商品货号">
                                    <div class="input-group-btn">
                                        <button id="search" type="submit" class="btn btn-default">搜索</button>
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
                <div class="col-sm-12">
                    <p>总库存成本：<span class="text-danger">{{$moneyCount}}</span> 元</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
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
                            <th>部门</th>
                            <th>金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($storageSkuCounts as $v)
                            <tr>
                                <th class="text-center"><input type="checkbox"></th>
                                <th>{{$v->product_number}}</th>
                                <th>{{$v->ProductsSku? $v->ProductsSku->number : ''}}</th>
                                <th>{{$v->Products ? $v->Products->title : ''}}</th>
                                <th>{{$v->ProductsSku ? $v->ProductsSku->mode : ''}}</th>
                                <th>{{$v->count}}</th>
                                <th>{{$v->Storage ? $v->Storage->name : ''}}</th>
                                <th>{{ $v->department_val }}</th>
                                <th>{{$v->count * $v->ProductsSku ? $v->ProductsSku->cost_price : 0}} 元</th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                @if ($storageSkuCounts)
                <div class="col-md-12 text-center">{!! $storageSkuCounts->appends(['number' => $number])->render() !!}</div>
                @endif
            </div>
        </div>
    </div>

@endsection