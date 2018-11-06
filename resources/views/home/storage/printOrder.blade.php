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
    <div id="down-print" class="container row" style="background-color: wheat;" hidden>
        <div class="col-md-12">
            <h4> 未连接打印客户组件，请启动打印组件，刷新重试。
                <a style="color: red;"
                   href="http://219.238.4.227/files/7139000005499324/113.10.155.131/CLodopPrint_Setup_for_Win32NT.zip">点击下载打印组件</a>
            </h4>
        </div>
    </div>
    <div class="container mainwrap">

        <div class="modal-body">
            <form id="addsku" class="form-horizontal" method="post" action="" onsubmit="return false;">

                <input type="hidden" name="out_warehouse_id" value="{{$order_warehouse['out_warehouse_id']}}">
                <div id="append-sku">
                    {{ csrf_field() }}

                            <div class="form-group">
                                <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">订单编号:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="number" name="number" class="form-control" readonly value="{{ $order_warehouse['num'] }}">
                                </div>
                                <label for="outWarehouse_sku" class="col-sm-2 control-label {{ $errors->has('outWarehouse_sku') ? ' has-error' : '' }}">制单日期:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="outWarehouse_sku" name="outWarehouse_sku" class="form-control" readonly value="{{ $order_warehouse['outWarehouse_sku'] }}">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="buyer_name" class="col-sm-2 control-label {{ $errors->has('buyer_name') ? ' has-error' : '' }}">收货人姓名:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="buyer_name" name="buyer_name" class="form-control" readonly value="{{ $order_warehouse['buyer_name'] }}">
                                </div>
                                <label for="buyer_phone" class="col-sm-2 control-label {{ $errors->has('buyer_phone') ? ' has-error' : '' }}">收货人电话:</label>
                                <div class="col-sm-2">
                                    <input type="text" id="buyer_phone" name="buyer_phone" class="form-control" readonly value="{{ $order_warehouse['buyer_phone'] }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="full_address" class="col-sm-2 control-label">收货地址:</label>
                                <div class="col-sm-6">
                                    <input type="text" id="full_address" name="full_address" class="form-control" readonly value="{{ $order_warehouse['full_address'] }}">
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
                        @foreach ($out_skus as $out_sku)
                            <tr>
                                <td class="magenta-color">{{ $out_sku->product_number }}</td>
                                <td>
                                    {{ $out_sku->number }}
                                </td>
                                <td>{{ $out_sku->name }}</td>
                                <td>{{ $out_sku->mode }}</td>
                                <td class="counts">{{ $out_sku->counts }}</td>
                            </tr>
                            <input type="hidden" name="new_count" id="new_count" value="{{$out_skus->new_count}}">
                        @endforeach

                        </tbody>

                        <input type="hidden" name="order_department" value="{{$order_warehouse['order_department']}}">
                        <input type="hidden" name="order_id" id="order_id" value="{{$order_warehouse['order_id']}}">
                    </table>

                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="submit" class="btn btn-white btn-sm mr-r print-enter" id="true-print" style="font-size: 14px">确认打印</button>
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.history.back()">取消</button>--}}
                    <a href="{{ url('/outWarehouse/orderOut') }}" class="btn btn-default">取消</a>
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
                var LODOP; // 声明为全局变量
                var isConnect = 0;
            @endsection
            @section('load_private')
                @parent

                {{--预览打印--}}
                $("#true-print").click(function () {
                {{--加载本地lodop打印控件--}}
                doConnectKdn();

                    if (isConnect == 0) {
                    $('#down-print').show();
                    return false;
                    }
                var out_warehouse_id = $("input[name='out_warehouse_id']").val();
                var target_id = $("input[name='order_id']").val();
                var new_count = $("input[name='new_count']").val();
                var out_warehouse_id = $("input[name='out_warehouse_id']").val();
                var out_type = 2;

                    $.get('{{url('/outWarehouse/ajaxPrint')}}', {'id': target_id,'new_count':new_count,'out_warehouse_id':out_warehouse_id}, function (e) {
                        if (e.status == 1) {
                            var n = 7;
                            var data = e.data;
                            var len = data.order_sku.length;
                            var order_sku = data.order_sku;
                            var count = Math.ceil(len / 7);
                        for (var i = 0; i < count; i++) {
                            var newData = data;
                            if (i + 1 == count) {
                            newData.order_sku = order_sku.slice(i * n);
                            newData.info = {"total": count, 'page': count}
                            } else {
                            newData.order_sku = order_sku.slice(i * n, n * (i + 1));
                            newData.info = {"total": count, 'page': i + 1}
                            }
                            var template = $('#print-out-order-tmp').html();
                            var views = Mustache.render(template, newData);
                            lodopPrint("出库单", views);
                        }
                        } else if (e.status == 0) {
                        alert(e.message);
                        } else if (e.status == -1) {
                        alert(e.msg);
                        }
                    }, 'json');

                })
                {{--lodop打印--}}
                function lodopPrint(name, template) {
                    LODOP.PRINT_INIT(name);
                    LODOP.ADD_PRINT_HTM(0, 0, "100%", "100%", template);
                    LODOP.PRINT();
                };

                {{--快递鸟打印--}}
                function doConnectKdn() {
                    try {
                    var LODOP = getLodop();
                        if (LODOP.VERSION) {
                        isConnect = 1;
                        console.log('快递鸟打印控件已安装');
                        }
                        ;
                    } catch (err) {
                         console.log('快递鸟打印控件连接失败' + err);
                    }
                };
            @endsection