@extends('home.base')

@section('title', '采购入库')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    @parent
    var LODOP; // 声明为全局变量
    var isConnect = 0;

    var _token = $("#_token").val();

    {{--1可提交 0:阻止提交--}}
    var submit_status = 1;


    var validate_form = function() {
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
                            message: '入库数量不能为空！'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: '采购数量填写不正确！'
                        }
                    }
                },
            }
        });
    }


@endsection

@section('load_private')
    @parent
    {{--<script>--}}

    $("#addsku").submit(function () {
        if(submit_status == 0){
            return false;
        }
    });

    $(".edit-enter").click(function() {
        var id = $(this).attr("value");

        $.get("{{url('/enterWarehouse/ajaxEdit')}}", {'enter_warehouse_id':id}, function(e) {
            if(e.status == 1){
                var template = $('#enterhouse-form').html();
                var views = Mustache.render(template, e.data);
                $("#append-sku").html(views);

                $("#in-warehouse").modal('show');

                // 验证输入入库数量
                $(".count").focusout(function() {
                    var max_value = $(this).attr("not_count");
                    var value = $(this).val();
                    if(parseInt(value) > parseInt(max_value)){
                        $(this).popover('show');
                        $(this).focus();
                        submit_status = 0;
                    }else{
                        $(this).popover('destroy');
                        submit_status = 1;
                    }
                });
            }else if(e.status == 0){
                alert(e.message);
            }else if(e.status == -1){
                alert(e.msg);
            }

        }, 'json');
    });

    {{--入库单预览--}}
    $(".print-enter").click(function () {
        var enter_warehouse_id = $(this).attr('value');
        var in_type = $(this).attr('in_type');

        // 采购
        if(in_type == 1){
            var template = $('#print-purchase-in-order-tmp').html();
        }
        // 订单退货
        else if(in_type == 2)
        {

        }
        // 调拨
        else if(in_type == 3)
        {
            var template = $('#print-change-in-order-tmp').html();

        }

        $.get('{{ url('/enterWarehouse/ajaxPrintInfo') }}', {'enter_warehouse_id':enter_warehouse_id}, function (e) {
            if(e.status == 1){
                var views = Mustache.render(template, e.data);
                console.log(views);
                $("#thn-in-order").html(views)
            }else if(e.status == 0){
                alert(e.message);
            }else if(e.status == -1){
                alert(e.msg);
            }
        },'json');

        $("#print-in-order").modal('show');
    });

    {{--预览打印--}}
    $("#true-print").click(function () {
        {{--加载本地lodop打印控件--}}
        doConnectKdn();

        if(isConnect == 0){
            $('#down-print').show();
            return false;
        }
        var template = $('#thn-in-order').html();
        LODOP.PRINT_INIT("出库单");
        LODOP.ADD_PRINT_HTM(0,0,"100%","100%",template);
        LODOP.PRINT();

        $("#print-out-order").modal('hide');
    })

    {{--快递鸟打印--}}
    function doConnectKdn() {
        try{
            var LODOP=getLodop();
            if (LODOP.VERSION) {
                isConnect = 1;
                console.log('快递鸟打印控件已安装');
            };
        }catch(err){
            console.log('快递鸟打印控件连接失败' + err);
        }
    };
@endsection


@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    入库单列表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.storage.warehouse-subnav')
            </div>
        </div>
    </div>
    <div id="down-print" class="container row" style="background-color: wheat;" hidden>
        <div class="col-md-12">
            <h4> 未连接打印客户组件，请启动打印组件，刷新重试。
                <a  style="color: red;" href="http://219.238.4.227/files/7139000005499324/113.10.155.131/CLodopPrint_Setup_for_Win32NT.zip">点击下载打印组件</a>
            </h4>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>入库单编号</th>
                        <th>相关单号</th>
                        <th>入库仓库</th>
                        <th>部门</th>
                        <th>入库数量</th>
                        <th>已入库数量</th>
                        <th>制单时间</th>
                        <th>制单人</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enter_warehouses as $enter_warehouse)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox"></td>
                            <td class="magenta-color">{{ $enter_warehouse->number }}</td>
                            <td>{{ $enter_warehouse->purchase_number }}</td>
                            <td>{{ $enter_warehouse->storage->name }}</td>
                            <td>{{ $enter_warehouse->department_val }}</td>
                            <td>{{ $enter_warehouse->count }}</td>
                            <td>{{ $enter_warehouse->in_count }}</td>
                            <td>{{ $enter_warehouse->created_at_val }}</td>
                            <td>{{ $enter_warehouse->user->realname }}</td>
                            <td tdr="nochect">
                                @if($tab_menu !== 'completed')
                                <button type="button" value="{{$enter_warehouse->id}}" class="btn btn-white btn-sm edit-enter">编辑入库</button>
                                @endif
                                <a href="{{ url('/enterWarehouse/show/') }}/{{ $enter_warehouse->id }}" class="btn btn-white btn-sm">查看详细</a>
                                @if($tab_menu !== 'completed')
                                <button type="button" value="{{$enter_warehouse->id}}" in_type="{{ $enter_warehouse->type }}" class="btn btn-white btn-sm print-enter">打印预览</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
        </div>
        @if ($enter_warehouses)
        <div class="row">
            <div class="col-md-12 text-center">{!! $enter_warehouses->render() !!}</div>
        </div>
        @endif
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

        <div class="modal fade bs-example-modal-lg" id="print-in-order" tabindex="-1" role="dialog"
             aria-labelledby="appendskuLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            打印入库单
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="thn-in-order">
                            {{--填充的打印模板--}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-magenta" id="true-print">确定打印</button>
                    </div>
                </div>
            </div>
        </div>

    @include('modal.editwarehouse')

    @include('mustache.enter-warehouse-form')
    @include('home/storage.printPurchaseInOrder')
    @include('home/storage.printChangeInOrder')

    <script language="javascript" src="{{url('assets/Lodop/LodopFuncs.js')}}"></script>
    <object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
        <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
    </object>
@endsection
