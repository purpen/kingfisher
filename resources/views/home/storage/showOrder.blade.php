@extends('home.base')

@section('title', '订单出库单明细')
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


@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    订单出库单明细
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">

        <div class="modal-body">
            <form id="addsku" class="form-horizontal" method="post" action="">

                <input type="hidden" name="out_warehouse_id" value="{{$out_warehouse->id}}">
                <input type="hidden" name="storage_id" value="{{$out_warehouse->storage_id}}">
                <div id="append-sku">
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


                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="active">
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>需出库数量</th>
                            <th>已出库数量</th>
                            <th>本次出库数量</th>
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
                                <td>
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
                            <td><span id="total" class="magenta-color">{{ $out_warehouse->count }}</span></td>
                            <td><span id="changetotal" spantotal="0" class="magenta-color">{{ $out_warehouse->out_count }}</span></td>
                            <td>未出库：<span id="changetotal" spantotal="0" class="magenta-color">{{$out_warehouse->not_count}}</span></td>
                        </tr>
                        </tfoot>
                    </table>

                    <input type="hidden" name="changeWarehouse_department" value="{{$out_warehouse->changeWarehouse_department}}">
                    <input type="hidden" name="changeWarehouse_id" value="{{$out_warehouse->changeWarehouse_id}}">
                    <div class="form-group">
                        <label for="summary" class="col-sm-2 control-label">出库备注</label>
                        <div class="col-sm-8">
                            <textarea rows="2" class="form-control" id="summary" name="summary">{{ $out_warehouse->summary }}</textarea>
                        </div>
                    </div>
                    <input type="hidden" name="num" value="{{$out_warehouse->num}}">
                    <input type="hidden" name="buyer_name" value="{{$out_warehouse->buyer_name}}">
                    <input type="hidden" name="buyer_phone" value="{{$out_warehouse->buyer_phone}}">

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

            @endsection