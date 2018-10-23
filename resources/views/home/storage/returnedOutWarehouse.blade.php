@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    出库单管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.storage.outwarehouse_subnav')
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
        <div class="row fz-0">
            <div class="col-md-8">
                {{--<button type="button" class="btn btn-white mr-2r">--}}
                    {{--<i class="glyphicon glyphicon-arrow-up"></i> 导出--}}
                {{--</button>--}}
                @if($tab_menu == 'waiting')
                    <button type="button" class="btn btn-success mr-2r" id="verifyReturned">
                        <i class="glyphicon glyphicon-ok"></i> 审核
                    </button>
                @endif

                @if($tab_menu == 'saled')
                    <button type="button" class="btn btn-success mr-2r" id="verifyOrder">
                        <i class="glyphicon glyphicon-ok"></i> 审核
                    </button>
                @endif

                @if($tab_menu == 'exchanged')
                    <button type="button" class="btn btn-success mr-2r" id="verifyChange">
                        <i class="glyphicon glyphicon-ok"></i> 审核
                    </button>
                @endif
                @role(['admin'])
                <button type="button" class="btn btn-danger mr-2r" id="someDelete">
                    <i class="glyphicon glyphicon-trash"></i> 删除
                </button>
                @endrole
                @if($tab_menu == 'saled' || $tab_menu == 'exchanged')
                    <button type="button" class="btn btn-success mr-2r" id="printOrder">
                        打印出库单
                    </button>
                @endif

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>审核状态</th>
                        <th>出库状态</th>
                        <th>出库单编号</th>
                        <th>相关单</th>
                        <th>出库仓库</th>
                        <th>部门</th>
                        <th>出库数量</th>
                        <th>已出库数量</th>
                        <th>制单时间</th>
                        @if($tab_menu == 'finished')
                        <th>出库时间</th>
                        @endif
                        <th>制单人</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($out_warehouses as $out_warehouse)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox" value="{{ $out_warehouse->id }}"
                                                           target_id="{{ $out_warehouse->target_id }}"
                                                           out_type="{{ $out_warehouse->type }}"></td>
                            <td>
                                @if ($out_warehouse->status == 0)
                                    <span class="label label-danger">{{$out_warehouse->status_val}}</span>
                                @endif

                                @if ($out_warehouse->status == 1)
                                    <span class="label label-success">{{$out_warehouse->status_val}}</span>
                                @endif
                            </td>
                            <td>
                                @if ($out_warehouse->storage_status == 0)
                                    <span class="label label-danger">{{$out_warehouse->storage_status_val}}</span>
                                @endif

                                @if ($out_warehouse->storage_status == 1)
                                    <span class="label label-warning">{{$out_warehouse->storage_status_val}}</span>
                                @endif

                                @if ($out_warehouse->storage_status == 5)
                                    <span class="label label-success">{{$out_warehouse->storage_status_val}}</span>
                                @endif

                            </td>
                            <td class="magenta-color">{{$out_warehouse->number}}</td>
                            <td>{{$out_warehouse->returned_number}}</td>
                            <td>{{$out_warehouse->storage_name}}</td>
                            <td>{{ $out_warehouse->department_val }}</td>
                            <td>{{$out_warehouse->count}}</td>
                            <td>{{$out_warehouse->out_count}}</td>
                            <td>{{$out_warehouse->created_at_val}}</td>
                            @if(!empty($out_warehouse->order_send_time))
                            <td>{{$out_warehouse->order_send_time}}</td>
                            @endif
                            <td>{{$out_warehouse->user_name}}</td>
                            <td>

{{--                                @if($tab_menu == 'exchanged')--}}
                                    {{--<button type="button" id="edit-enter" value="{{$out_warehouse->id}}"--}}
                                            {{--class="btn btn-white btn-sm mr-r edit-enter">编辑出库--}}
                                    {{--</button>--}}
                                {{--@endif--}}

                                {{--@if($tab_menu == 'saled')--}}
                                    {{--<button type="button" class="btn btn-success btn-sm manual-send"--}}
                                            {{--value="{{$out_warehouse->target_id}}">--}}
                                        {{--<i class="glyphicon glyphicon-hand-right"></i> 手动发货--}}
                                    {{--</button>--}}
                                {{--@endif--}}

                                @if($tab_menu == 'saled' || $tab_menu == 'exchanged')
                                    <a href="{{ url('/outWarehouse/showOut/') }}/{{ $out_warehouse->id }}" class="btn btn-white btn-sm">编辑出库</a>

                                    <button type="button" id="print-enter" value="{{$out_warehouse->id}}"
                                            target_id="{{ $out_warehouse->target_id }}"
                                            out_type="{{ $out_warehouse->type }}"
                                            class="btn btn-white btn-sm mr-r print-enter">打印预览
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($out_warehouses)
            <div class="row">
                <div class="col-md-12 text-center">{!! $out_warehouses->appends(['where' => $where])->render() !!}</div>
            </div>
        @endif

        <div class="modal fade bs-example-modal-lg" id="in-warehouse" tabindex="-1" role="dialog"
             aria-labelledby="appendskuLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            编辑出库
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="addsku" method="post" action="{{ url('/outWarehouse/update') }}">
                            <div id="append-sku" class="container-fluid"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-magenta submit">确定</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bs-example-modal-lg" id="print-out-order" tabindex="-1" role="dialog"
         aria-labelledby="appendskuLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        打印出库单
                    </h4>
                </div>
                <div class="modal-body">
                    <div id="thn-out-order">
                        {{--填充的打印模板--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-magenta" out_warehouse_id="" target_id="" out_type=""
                            id="true-print">确定打印
                    </button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

    @include('home/storage.printOutOrder')
    @include('home/storage.printChangeOutWarehouse')

    {{--手动发货弹出框--}}
    @include('modal.add_manual_send_modal')

    <script language="javascript" src="{{url('assets/Lodop/LodopFuncs.js')}}"></script>
    <object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
        <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
    </object>
@endsection


@section('customize_js')
    {{--<script>--}}
    @parent

    var _token = $("#_token").val();
    {{--1可提交 0:阻止提交--}}
    var submit_status = 1;

    var LODOP; // 声明为全局变量
    var isConnect = 0;

@endsection

@section('load_private')
    @parent
    {{--<script>--}}

        {{--打印订单出库单--}}
        $("#printOrder").click(function () {
            {{--加载本地lodop打印控件--}}
                    {{--doConnectKdn();--}}
                    {{--if(isConnect == 0){--}}
                    {{--$('#down-print').show();--}}
                    {{--return false;--}}
                    {{--}--}}

            if (!$("input[name='Order']:checked").size()) {
                alert('请选择需要打印的出货单!');
                return false;
            }

            $("input[name='Order']").each(function () {
                if ($(this).is(':checked')) {
                    var out_warehouse_id = $(this).attr('value');
                    var target_id = $(this).attr('target_id');
                    var out_type = $(this).attr('out_type');
                    {{--采购退货--}}
                    if (out_type == 1) {

                    }
                            {{-- 订单 --}}
                    else if (out_type == 2) {
                        $.get('{{url('/order/ajaxEdit')}}', {'id': target_id}, function (e) {
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
                    }
                            {{--调拨--}}
                    else if (out_type == 3) {
                        $.get('{{url('/outWarehouse/ajaxEdit')}}', {'out_warehouse_id': out_warehouse_id}, function (e) {
                            if (e.status == 1) {
                                var n = 7;
                                var data = e.data;
                                var len = data.out_sku.length;
                                var out_sku = data.out_sku;
                                var count = Math.ceil(len / 7);
                                for (var i = 0; i < count; i++) {
                                    var newData = data;
                                    if (i + 1 == count) {
                                        newData.out_sku = out_sku.slice(i * n);
                                        newData.info = {"total": count, 'page': count}
                                    } else {
                                        newData.out_sku = out_sku.slice(i * n, n * (i + 1));
                                        newData.info = {"total": count, 'page': i + 1}
                                    }

                                    var template = $('#print-change-out-order-tmp').html();
                                    var views = Mustache.render(template, newData);
                                    lodopPrint("出库单", views);
                                }
                            } else if (e.status == 0) {
                                alert(e.message);
                            } else if (e.status == -1) {
                                alert(e.msg);
                            }
                        }, 'json');
                    }

                }

            });
        });


        {{--出货单预览--}}
        $(".print-enter").click(function () {
            var out_warehouse_id = $(this).attr('value');
            var target_id = $(this).attr('target_id');
            var out_type = $(this).attr('out_type');

            $("#true-print").attr('out_warehouse_id', out_warehouse_id);
            $("#true-print").attr('target_id', target_id);
            $("#true-print").attr('out_type', out_type);
            {{--采购退货--}}
            if (out_type == 1) {

            }
                    {{-- 订单 --}}
            else if (out_type == 2) {
                $.get('{{url('/order/ajaxEdit')}}', {'id': target_id}, function (e) {
                    if (e.status == 1) {

                        var template = $('#print-out-order-tmp').html();
                        var views = Mustache.render(template, e.data);
                        console.log(views);
                        $("#thn-out-order").html(views)
                    } else if (e.status == 0) {
                        alert(e.message);
                    } else if (e.status == -1) {
                        alert(e.msg);
                    }
                }, 'json');
            }
                    {{--调拨--}}
            else if (out_type == 3) {
                $.get('{{url('/outWarehouse/ajaxEdit')}}', {'out_warehouse_id': out_warehouse_id}, function (e) {
                    if (e.status == 1) {

                        var template = $('#print-change-out-order-tmp').html();
                        var views = Mustache.render(template, e.data);
                        console.log(views);
                        $("#thn-out-order").html(views)
                    } else if (e.status == 0) {
                        alert(e.message);
                    } else if (e.status == -1) {
                        alert(e.msg);
                    }
                }, 'json');
            }


            $("#print-out-order").modal('show');
        });

        {{--预览打印--}}
        $("#true-print").click(function () {
            {{--加载本地lodop打印控件--}}
            doConnectKdn();

            if (isConnect == 0) {
                $('#down-print').show();
                return false;
            }

            var out_warehouse_id = $(this).attr('out_warehouse_id');
            var target_id = $(this).attr('target_id');
            var out_type = $(this).attr('out_type');

            {{--采购退货--}}
            if (out_type == 1) {

            }
                    {{-- 订单 --}}
            else if (out_type == 2) {
                $.get('{{url('/order/ajaxEdit')}}', {'id': target_id}, function (e) {
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
            }
                    {{--调拨--}}
            else if (out_type == 3) {
                $.get('{{url('/outWarehouse/ajaxEdit')}}', {'out_warehouse_id': out_warehouse_id}, function (e) {
                    if (e.status == 1) {
                        var n = 7;
                        var data = e.data;
                        var len = data.out_sku.length;
                        var out_sku = data.out_sku;
                        var count = Math.ceil(len / 7);
                        for (var i = 0; i < count; i++) {
                            var newData = data;
                            if (i + 1 == count) {
                                newData.out_sku = out_sku.slice(i * n);
                                newData.info = {"total": count, 'page': count}
                            } else {
                                newData.out_sku = out_sku.slice(i * n, n * (i + 1));
                                newData.info = {"total": count, 'page': i + 1}
                            }

                            var template = $('#print-change-out-order-tmp').html();
                            var views = Mustache.render(template, newData);
                            lodopPrint("出库单", views);
                        }
                    } else if (e.status == 0) {
                        alert(e.message);
                    } else if (e.status == -1) {
                        alert(e.msg);
                    }
                }, 'json');
            }

            $("#print-out-order").modal('hide');
        });

        {{--lodop打印--}}
        function lodopPrint(name, template) {
            LODOP.PRINT_INIT(name);
            LODOP.ADD_PRINT_HTM(0, 0, "100%", "100%", template);
            LODOP.PRINT();
        };

        $("#addsku").submit(function () {
            if (submit_status == 0) {
                return false;
            }
        });


        $("#checkAll").click(function () {
            $("input[name='Order']:checkbox").prop("checked", this.checked);
        });

        $('#verifyReturned').click(function () {
            if (confirm('确认审核通过')) {
                $("input[name='Order']").each(function () {
                    if ($(this).is(':checked')) {
                        var id = $(this).attr('value');
                        $.post('{{url('/outWarehouse/verifyReturned')}}', {'_token': _token, 'id': id}, function (e) {
                            if (e.status == 0) {
                                alert(e.message);
                            } else if (e.status == -1) {
                                alert(e.msg);
                            }
                        }, 'json');
                    }
                });
                location.reload();
            }
        });


        $('#verifyOrder').click(function () {
            if (confirm('确认审核通过')) {
                $("input[name='Order']").each(function () {
                    if ($(this).is(':checked')) {
                        var id = $(this).attr('value');
                        $.post('{{url('/outWarehouse/verifyOrder')}}', {'_token': _token, 'id': id}, function (e) {
                            if (e.status == 0) {
                                alert(e.message);
                            } else if (e.status == -1) {
                                alert(e.msg);
                            } else {
                                alert(e.message);
                                location.reload();
                            }
                        }, 'json');
                    }
                });

            }
        });


        $('#verifyChange').click(function () {
            if (confirm('确认审核通过')) {
                $("input[name='Order']").each(function () {
                    if ($(this).is(':checked')) {
                        var id = $(this).attr('value');
                        $.post('{{url('/outWarehouse/verifyChange')}}', {'_token': _token, 'id': id}, function (e) {
                            if (e.status == 0) {
                                alert(e.message);
                            } else if (e.status == -1) {
                                alert(e.msg);
                            }
                        }, 'json');
                    }
                });
                location.reload();
            }
        });

        $('#someDelete').click(function () {
            if (confirm('确认删除')) {
                $("input[name='Order']").each(function () {
                    if ($(this).is(':checked')) {
                        var id = $(this).attr('value');
                        $.post('{{url('/outWarehouse/ajaxDelete')}}', {'_token': _token, 'id': id}, function (e) {
                            if (e.status == 0) {
                                alert(e.message);
                            } else if (e.status == -1) {
                                alert(e.msg);
                            }
                        }, 'json');
                    }
                });
                location.reload();
            }
        });


        $(".edit-enter").click(function () {
            var id = $(this).attr("value");
            $.get("{{url('/outWarehouse/ajaxEdit')}}", {'out_warehouse_id': id}, function (e) {
                if (e.status) {
                    var template = [
                        '                                {{ csrf_field() }}',
                        '                                <div class="row mb-2r">',
                        '                                    <div class="btn-group-block">',
                        '                                        <div class="form-group">商品扫描：</div>',
                        '                                        <div class="form-group mr20">',
                        '                                            <div class="input-group"><input id="goodsSku" type="text" class="form-control"></div>',
                        '                                        </div>',
                        '                                        @{{#out_warehouse}}<div class="form-group">出库仓库：@{{storage_name}}</div><input type="hidden" name="out_warehouse_id" value="@{{id}}">@{{/out_warehouse}}',
                        '                                    </div>',
                        '                                        @{{#out_warehouse}}<div class="form-group">部门：@{{department_val}}</div><input type="hidden" name="department" value="@{{department}}">@{{/out_warehouse}}',
                        '                                    </div>',
                        '                                    <div class="tl lh30 scrollspy-example" style="max-height:230px;overflow:auto;" >',
                        '                                        <table style="margin-bottom:0" class="table table-striped table-hover">',
                        '                                            <thead class=" table-bordered">',
                        '                                            <tr>',
                        '                                                <th>SKU编码</th>',
                        '                                                <th>商品名称</th>',
                        '                                                <th>商品属性</th>',
                        '                                                <th>需出库数量</th>',
                        '                                                <th>已出库数量</th>',
                        '                                                <th>本次出库数量</th>',
                        '                                            </tr>',
                        '                                            </thead>',
                        '                                            <tbody style="font-weight:normal">',
                        '                                            @{{#out_sku}}<tr>',
                        '<input type="hidden" name="out_sku_id[]" value="@{{id}}">',
                        '                                                <td class="fb">',
                        '@{{number}}',
                        '                                                    <input type="hidden" name="sku_id[]" value="@{{sku_id}}">',
                        '                                                </td>',
                        '                                                <td>@{{name}}</td>',
                        '                                                <td>@{{mode}}</td>',
                        '                                                <td>@{{count}}</td>',
                        '                                                <td>@{{out_count}}</td>',
                        '                                                <td>',
                        '                                                    <div class="form-group form-group-input">',
                        '                                                        <input type="text" not_count="@{{not_count}}" name="count[]" class="form-control input-operate integer count" value="@{{not_count}}" data-toggle="popover" data-placement="top" data-content="数量不能大于可出库数量" @{{ ^not_count }}readonly@{{ /not_count }}>',
                        '                                                    </div>',
                        '                                                </td>',
                        '                                            </tr>@{{/out_sku}}',
                        '                                            <tr style="background:#dcdcdc;border:1px solid #dcdcdc; ">',
                        '                                                <td colspan="3" class="fb">合计：</td>',
                        '                                                @{{#out_warehouse}}<td class="fb">需出库合计：<span id="total" class="red">@{{count}}</span></td>',
                        '                                                <td class="fb">已出库合计：<span id="changetotal" spantotal="0" class="red">@{{out_count}}</span></td>',
                        '                                                <td class="fb">未出库合计：<span id="changetotal" spantotal="0" class="red">@{{not_count}}</span></td>',
                        '                                            </tr>',
                        '                                            </tbody>',
                        '                                        </table>',
                        '                                    </div>',
                        '                                    <div class="tl lh30 pt10">',
                        '                                        <div class="row f14 fb mt20">',
                        '                                            <div class="col-sm-12">出库备注</div>',
                        '                                            <div class="col-sm-12">',
                        '                                                <textarea rows="3" class="form-control" name="summary" style="width: 100%;">@{{summary}}</textarea>@{{/out_warehouse}}',
                        '                                            </div>',
                        '                                        </div>',
                        '                                    </div>',
                        '                                </div>',
                        '                        </div>'].join("");
                                    var views = Mustache.render(template, e.data);
                                    $("#append-sku").html(views);
                                    $("#in-warehouse").modal('show');
                                    $(".count").focusout(function () {
                                        var max_value = $(this).attr("not_count");
                                        var value = $(this).val();
                                        if (parseInt(value) > parseInt(max_value)) {
                                            $(this).popover('show');
                                            $(this).focus();
                                            submit_status = 0;
                                        } else {
                                            $(this).popover('destroy');
                                            submit_status = 1;
                                        }
                                    });
                                    $("#addsku").formValidation({
                                        framework: 'bootstrap',
                                        icon: {
                                            valid: 'glyphicon glyphicon-ok',
                                            invalid: 'glyphicon glyphicon-remove',
                                            validating: 'glyphicon glyphicon-refresh'
                                        },
                                        fields: {
                                            'count[]': {
                                                validators: {
                                                    notEmpty: {
                                                        message: '出库数量不能为空！'
                                                    },
                                                    regexp: {
                                                        regexp: /^[0-9]+$/,
                                                        message: '出库数量填写不正确！'
                                                    }
                                                }
                                            },
                                        }
                                    });

                                }
                            else
                                {
                                    alert(e.message);
                                }
                            }
                            ,
                                'json'
                            );

        });

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

        {{--显示手动发货弹窗--}}
        $(".manual-send").click(function () {
            var order_id = $(this).attr('value');
            $("#manual-send-order-id").val(order_id);
            $("#add-manual-send").modal('show');
        });

        {{--提交手动发货--}}
        $("#manual-send-goods").click(function () {
            var order_id = $("#manual-send-order-id").val();
            var logistics_id = $("#logistics_id").val();
            var logistics_no = $("#logistics_no").val();
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
            $.post('{{url('/outWarehouse/ajaxSendOut')}}', {
                '_token': _token,
                'order_id': order_id,
                'logistics_id': logistics_id,
                'logistics_no': logistics_no,
                'logistics_type': 'true'
            }, function (e) {

                if (e.status) {
                    location.reload();
                } else {
                    alert(e.message);
                }
            }, 'json');
        });
@endsection