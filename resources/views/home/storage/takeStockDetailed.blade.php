@extends('home.base')

@section('title', '库存盘点明细')

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
                    库存盘点明细
                </div>
                <div class="col-md-2" style="margin-top: 10px;margin-left: 30px;">
                    <button id="stockAll"  class="btn btn-default">全部导出</button>
                </div>
            </div>

        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>部门</th>
                            <th>商品货号</th>
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>erp库存</th>
                            <th>库存变化</th>
                            <th style="width:80px">实际库存</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($take_stock_detailed as $v)
                            <tr>
                                <th class="text-center"><input name="Order" class="sku-order" type="checkbox" active="0" value="{{ $v->id }}"></th>
                                <th>{{ $v->department }}</th>
                                <th>{{$v->product_number}}</th>
                                <th>{{$v->sku_number}}</th>
                                <th>{{$v->name}}</th>
                                <th>{{$v->mode}}</th>
                                <th>{{$v->number}}</th>
                                <th
                                        @if($v->number - $v->storage_number == 0)
                                        class=""
                                        @elseif($v->number - $v->storage_number > 0)
                                        class="success"
                                        @elseif($v->number - $v->storage_number < 0)
                                        class="danger"
                                        @endif>{{$v->storage_number - $v->number}}
                                </th>
                                <th>
                                    <span class="proname">{{ $v->storage_number }}</span>
                                    <button name="btnTitle" class="btn btn-default operate-update-offlineEshop" title=""
                                            type="button"
                                            style="border: none; display: inline-block; background: none;"><i class="glyphicon glyphicon-pencil"></i></button>
                                    <input name="max_count" value="{{ $v->storage_number }}" action="{{$v->id}}"
                                           class="form-control" type="text" style="display: none;">
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                @if ($take_stock_detailed)
                    <div class="col-md-12 text-center">{!! $take_stock_detailed->appends(['id' => $id])->render() !!}</div>
                @endif
            </div>
        </div>
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection

@section('customize_js')
    @parent

@endsection

@section('load_private')
    @parent
    {{--<script>--}}

    {{--post请求--}}
    var _token = $("#_token").val();
    function post(URL, PARAMS) {

    var temp = document.createElement("form");
    temp.action = URL;
    temp.method = "post";
    temp.style.display = "none";
    var opt = document.createElement("textarea");
    opt.name = '_token';
    opt.value = _token;
    {{--alert(opt.value);return false;--}}
    temp.appendChild(opt);
    for (var x in PARAMS) {
    var opt = document.createElement("textarea");
    opt.name = x;
    opt.value = PARAMS[x];
    temp.appendChild(opt);
    }
    {{--alert(opt.name);return false;--}}
    document.body.appendChild(temp);
    temp.submit();
    return temp;
    };
    {{--打印订单excel--}}
    $('#stockAll').click(function () {
    var id_array = [];
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    id_array.push($(this).attr('value'));
    }
    });

    post('{{url('/stockDetail')}}',id_array);
    });


        $('.operate-update-offlineEshop').click(function () {
            $(this).siblings().css('display', 'none');
            $(this).css('display', 'none');
            $(this).siblings('input[name=max_count]').css('display', 'block');
            $(this).siblings('input[name=max_count]').focus();

        });

        $('input[name=max_count]').bind('blur', function () {
            $(this).css('display', 'none');
            $(this).siblings().removeAttr("style");
            var target = $(this).parent().prev();
            var input_val = 0;
            if ($(this).val() !== '') {
                input_val = $(this).val();
            }
            $(this).siblings('.proname').html(input_val);
            var _token = $('input[name=_token]').val();
            var id = $(this).attr('action');
            var max_count = $(this).siblings('.proname').text();
            $.post('{{ url('/ajaxSetSkuNumber') }}', {
                _token: _token,
                id: id,
                storage_number: max_count
            }, function (data) {
                var date_obj = data;
                if (date_obj.status == 1) {
                    var number = target.prev().text();
                    if(max_count - number > 0){
                        target.removeClass()
                        target.addClass('danger')
                    }else if(max_count - number < 0){
                        target.removeClass()
                        target.addClass('success')
                    }else{
                        target.removeClass()
                    }
                    target.text(max_count - number);
                    return false;
                } else if (date_obj.status == 0) {
                    alert(date_obj.message);
                    location.reload();
                } else {
                    alert(date_obj.message);
                }
            }, 'json');

        });

@endsection