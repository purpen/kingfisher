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
                                    <input type="text" onkeyup="onlyNum(this)" maxlength="{{$out_sku->not_count}}" name="count[]" class="form-control input-operate integer count" value="{{$out_sku->not_count}}" data-toggle="popover" data-placement="top" readonly>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>

                   </table>

                    <hr>
                    <div class="form-group">
                        <h3 style="width:100%;text-align: center">历史记录</h3>
                    </div>

                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">操作人:</label>
                        <div class="col-sm-2">
                            <input type="text" id="number" name="number" class="form-control" readonly value="{{ $out_warehouse->num }}">
                        </div>
                        <label for="outWarehouse_sku" class="col-sm-2 control-label {{ $errors->has('outWarehouse_sku') ? ' has-error' : '' }}">操作时间:</label>
                        <div class="col-sm-2">
                            <input type="text" id="outWarehouse_sku" name="outWarehouse_sku" class="form-control" readonly value="{{ $out_warehouse->outWarehouse_sku }}">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">快递公司:</label>
                        <div class="col-sm-2">
                            <input type="text" id="number" name="number" class="form-control" readonly value="{{ $out_warehouse->num }}">
                        </div>
                        <label for="outWarehouse_sku" class="col-sm-2 control-label {{ $errors->has('outWarehouse_sku') ? ' has-error' : '' }}">快递单号:</label>
                        <div class="col-sm-2">
                            <input type="text" id="outWarehouse_sku" name="outWarehouse_sku" class="form-control" readonly value="{{ $out_warehouse->outWarehouse_sku }}">
                        </div>

                    </div>

                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="active">
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>出库数量</th>
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
                                <td>
                                    <input type="text" onkeyup="onlyNum(this)" maxlength="{{$out_sku->not_count}}" name="count[]" class="form-control input-operate integer count" value="{{$out_sku->not_count}}" data-toggle="popover" data-placement="top" readonly>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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