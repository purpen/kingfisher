@extends('home.base')

@section('title', '编辑出库')
@section('partial_css')
    @parent
    <link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
    @parent
    #picForm .form-control {
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    width: 100px;
    height: 100px;
    z-index: 3;
    cursor: pointer;
    }
    #appendsku {
    margin-left:40px;
    font-size:14px;
    }
    .qq-upload-button {
    width: 100px;
    height: 100px;
    position: absolute !important;
    }
@endsection
@section('customize_js')
    @parent
    $(".count").livequery(function(){
    $(this)
    .css("ime-mode", "disabled")
    .keypress(function(){
    if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
    event.returnValue=false;
    }
    })
    .keyup(function(){
    var count = $(this).val();
    var count_one = $(this).parent().parent().find(".counts").text();
    var count_two = $(this).parent().parent().find(".incounts").text();
    if(eval(count) > eval(count_one - count_two)){
    layer.msg("数量不能大于可入库数量！");
    $(".count").val("");
    return false;
    }
    })
    });

    function onlyNum(that){//限定只能输入数字
    that.value=that.value.replace(/\D/g,"");
    }


@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    编辑出库
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <h3 style="color: #9c0033">{{ $error }}</h3>
            @endforeach
        @endif
        <div class="modal-body">
            <form id="addsku" class="form-horizontal" method="post" action="{{ url('/outWarehouse/ajaxSendOut') }}">

                <input type="hidden" name="out_warehouse_id" value="{{$out_warehouse->id}}">
                <input type="hidden" name="storage_id" value="{{$out_warehouse->storage_id}}">
                <div id="append-sku" style="margin-left: 200px">
                    {{ csrf_field() }}

                            <div class="form-group">
                                <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">订单编号:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="number" name="number" class="form-control" readonly value="{{ $out_warehouse->num }}">
                                </div>
                                <label for="outWarehouse_sku" class="col-sm-2 control-label {{ $errors->has('outWarehouse_sku') ? ' has-error' : '' }}">制单日期:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="outWarehouse_sku" name="outWarehouse_sku" class="form-control" readonly value="{{ $out_warehouse->outWarehouse_sku }}">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="buyer_name" class="col-sm-2 control-label {{ $errors->has('buyer_name') ? ' has-error' : '' }}">收货人姓名:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="buyer_name" name="buyer_name" class="form-control" readonly value="{{ $out_warehouse->buyer_name }}">
                                </div>
                                <label for="buyer_phone" class="col-sm-2 control-label {{ $errors->has('buyer_phone') ? ' has-error' : '' }}">收货人电话:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="buyer_phone" name="buyer_phone" class="form-control" readonly value="{{ $out_warehouse->buyer_phone }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="full_address" class="col-sm-2 control-label">收货地址:</label>
                                <div class="col-sm-6">
                                    <input type="text" id="full_address" name="full_address" class="form-control" readonly value="{{ $out_warehouse->full_address }}">
                                </div>
                            </div>


                    {{--<table class="table table-hover table-bordered" style="margin-left:112px;width: 890px">--}}
                    <table class="table table-hover table-bordered" style="margin-left:112px;width: 935px">
                        <thead>
                        <tr class="active">
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>需出库数量</th>
                            <th>已出库数量</th>
                            <th style="width: 120px">本次出库数量</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($out_skus as $out_sku)
                            <tr>
                                <td class="magenta-color">
                                    {{ $out_sku->number }}
                                </td>
                                <td>{{ $out_sku->name }}</td>
                                <td>{{ $out_sku->mode }}</td>
                                <td class="counts">{{ $out_sku->count }}</td>
                                <td class="incounts">{{ $out_sku->out_count }}</td>
                                <td style="width: 50px">
                                    <input type="hidden" name="out_sku_id[]" value="{{$out_sku->id}}">
                                    <input type="hidden" name="sku_id[]" value="{{$out_sku->sku_id}}">
                                    <input type="text" onkeyup="onlyNum(this)" maxlength="{{$out_sku->not_count}}" name="count[]" class="form-control input-operate integer count" value="{{$out_sku->not_count}}" data-toggle="popover" data-placement="top" data-content="数量不能大于可入库数量" required>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>

                        <input type="hidden" name="order_department" value="{{$out_warehouse->order_department}}">
                        <input type="hidden" name="order_id" id="order_id" value="{{$out_warehouse->order_id}}">
                        <tfoot>
                        <tr class="active">
                            <td colspan="3">合计</td>
{{--                            @{{#enter_warehouse}}--}}
                            <td><span id="total" class="magenta-color">{{ $out_warehouse->count }}</span></td>
                            <td><span id="changetotal" spantotal="0" class="magenta-color">{{ $out_warehouse->out_count }}</span></td>
                            <td>未出库：<span id="changetotal" spantotal="0" class="magenta-color">{{$out_warehouse->not_count}}</span></td>
                            {{--@{{/enter_warehouse}}--}}
                        </tr>
                        </tfoot>
                    </table>

                    {{--<div class="row" style="width: 1606px;margin-left: -52px">--}}
                    <div class="row" style="width: 1466px;margin-left: -29px">
                        <label for="summary" class="col-sm-2 control-label">出库备注</label>
                        <div class="col-sm-6">
                            <textarea rows="2" class="form-control" id="summary" name="summary">{{ $out_warehouse->summary }}</textarea>
                        </div>
                    </div>
                    <input type="hidden" name="num" value="{{$out_warehouse->num}}">
                    <input type="hidden" name="buyer_name" value="{{$out_warehouse->buyer_name}}">
                    <input type="hidden" name="buyer_phone" value="{{$out_warehouse->buyer_phone}}">
                        <hr>
                            <div class="row" style="width: 1635px;margin-left: -72px">
                                <label for="title" class="col-sm-2 control-label p-0 lh-34 m-56">快递公司</label>
                                <div class="col-sm-6">
                                    <select class="selectpicker" id="logistics_id" name="logistics_id" style="display: none;">
                                        @foreach($logistics_list as $logistics)
                                            <option value='{{$logistics->id}}'>{{$logistics->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="width: 1132px;margin-left: 10px">
                                <label for="order" class="col-sm-2 control-label p-0 lh-34 m-56">快递单号<em>*</em></label>
                                <div class="col-sm-8">
                                    <input type="text" name="logistics_no" class="form-control float" id="logistics_no" placeholder="快递单号" required >
                                </div>
                            </div>
                </div>

                <div class="modal-footer" style="margin-left: -58px;text-align: center">
                    <button type="submit" class="btn btn-magenta makesure">确认提交</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.history.back()">取消</button>
                </div>
            </form>
        </div>

            </div>
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            @endsection

            @section('partial_js')
                @parent
                <script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
            @endsection

            @section('customize_js')
                @parent
                $(".makesure").click(function () {
                var order_id = $("#order_id").val();
                var logistics_id = $("select[name='logistics_id']").val();
                var logistics_no = $("input[name='logistics_no']").val();
                if (order_id == '') {
                alert('订单ID获取异常');
                return false;
                }
                if (logistics_id == '') {
                alert('请选择物流');
                return false;
                }
                var regobj = new RegExp("^[0-9]*$");
                if (logistics_no == '' || !regobj.test(logistics_no)) {
                alert('物流单号格式不正确');
                return false;
                }
                })

            @endsection