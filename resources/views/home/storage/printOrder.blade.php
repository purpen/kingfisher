@extends('home.base')

@section('title', '打印订单出库')
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
                    打印订单出库
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">

        <div class="modal-body">
            <form id="addsku" class="form-horizontal" method="post" action="{{ url('/outWarehouse/update') }}">

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
                            <th>商品编号</th>
                            <th>sku编号</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>数量</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@foreach ($out_skus as $out_sku)--}}
                            {{--<tr>--}}
                                {{--<td class="magenta-color">--}}
                                    {{--{{ $out_sku->number }}--}}
                                {{--</td>--}}
                                {{--<td>{{ $out_sku->name }}</td>--}}
                                {{--<td>{{ $out_sku->mode }}</td>--}}
                                {{--<td class="counts">{{ $out_sku->count }}</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}

                        </tbody>

                        <input type="hidden" name="order_department" value="{{$out_warehouse->order_department}}">
                        <input type="hidden" name="order_id" id="order_id" value="{{$out_warehouse->order_id}}">

                    </table>

                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="submit" class="btn btn-magenta printOrder">确认打印</button>
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

                var out_warehouse_id = $(this).attr('value');
                var target_id = $(this).attr('target_id');
                var out_type = $(this).attr('out_type');

                $("#true-print").attr('out_warehouse_id', out_warehouse_id);
                $("#true-print").attr('target_id', target_id);
                $("#true-print").attr('out_type', out_type);

            @endsection