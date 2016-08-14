@extends('home.base')

@section('title', '库存监控')

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
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/storageSkuCount/search')}}" method="post">
                            <div class="form-group">
                                <input type="text" name="product_number" class="form-control" placeholder="请输入商品货号">
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
                        <th style="width:80px">库存上限</th>
                        <th style="width:80px">库存下限</th>
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
                                <th>
                                    <span class="proname">{{ $v->max_count }}</span>
                                    <button name="btnTitle" class="btn btn-default operate-update-offlineEshop" title="" type="button" style="border: none; display: inline-block; background: none;"><i class="glyphicon glyphicon-pencil"></i></button>
                                    <input name="max_count" action="{{$v->id}}" class="form-control" type="text" style="display: none;">
                                </th>
                                <th>
                                    <span class="proname">{{ $v->min_count }}</span>
                                    <button name="btnTitle" class="btn btn-default operate-update-offlineEshop" title="" type="button" style="border: none; display: inline-block; background: none;"><i class="glyphicon glyphicon-pencil"></i></button>
                                    <input name="min_count" action="{{$v->id}}" class="form-control" type="text" style="display: none;">
                                </th>
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
    $('.operate-update-offlineEshop').click(function(){
        $(this).siblings().css('display','none');
        $(this).css('display','none');
        $(this).siblings('input[name=max_count]').css('display','block');
        $(this).siblings('input[name=max_count]').focus();
        $(this).siblings('input[name=min_count]').css('display','block');
        $(this).siblings('input[name=min_count]').focus();

    });

    $('input[name=max_count]').bind('blur',function(){
        $(this).css('display','none');
        $(this).siblings().removeAttr("style");
        $(this).siblings('.proname').html($(this).val());
        var _token = $('input[name=_token]').val();
        var id = $(this).attr('action');
        var max_count = $(this).siblings('.proname').text();
        $.post('/storageSkuCount/updateMax',{_token:_token,id:id,max_count:max_count}, function(data){
            var date_obj = data;
            if (date_obj.status == 1){
                return false;
            }
        },'json');

    });

    $('input[name=min_count]').bind('blur',function(){
        $(this).css('display','none');
        $(this).siblings().removeAttr("style");
        $(this).siblings('.proname').html($(this).val());
        var _token = $('input[name=_token]').val();
        var id = $(this).attr('action');
        var min_count = $(this).siblings('.proname').text();
        $.post('/storageSkuCount/updateMin',{_token:_token,id:id,min_count:min_count}, function(data){

