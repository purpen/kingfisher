@extends('home.base')

@section('title', '订单出库')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    {{--<script>--}}
    @parent
    var _token = $("#_token").val();

    $(".edit-enter").click(function () {
    var id = $(this).attr("value");
    $.get("{{url('/outWarehouse/ajaxEdit')}}",{'out_warehouse_id':id},function (e) {
    if(e.status){
    var template = [
    '                                {{ csrf_field() }}',
    '                                <div class="row mb-2r">',
        '                                    <div class="btn-group-block">',
            '                                        <div class="form-group">商品扫描：</div>',
            '                                        <div class="form-group mr20">',
                '                                            <div class="input-group"><input id="goodsSku" type="text" class="form-control"></div>',
                '                                        </div>',
            '                                        @{{#out_warehouse}}<div class="form-group">选择仓库：@{{storage_name}}</div><input type="hidden" name="out_warehouse_id" value="@{{id}}">@{{/out_warehouse}}',
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
                            '                                                        <input type="text" not_count="@{{not_count}}" name="count[]" class="form-control input-operate integer count" value="@{{not_count}}">',
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
    if(parseInt(value) > parseInt(max_value)){
    alert("出库数量不能大于" + max_value);
    $(this).focus();
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
    },'json');

    });

@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        订单出库
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li><a href="{{url('/outWarehouse')}}">采购退货出库()</a></li>
                        <li class="active"><a href="{{url('/outWarehouse/orderOut')}}">订单出库</a></li>
                        <li><a href="{{url('/outWarehouse/changeOut')}}">调拨出库</a></li>
                        <li><a href="{{url('/outWarehouse/complete')}}">完成出库</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="" method="POST">
                                <div class="form-group">
                                    <input type="text" name="where" class="form-control" placeholder="">
                                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                                </div>
                                <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row fz-0">
            <button type="button" class="btn btn-white mlr-2r">导出</button>
        </div>
        <div class="row">
            <div class="row scroll">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>出库库单编号</th>
                        <th>相关采购单</th>
                        <th>出库仓库</th>
                        <th>出库数量</th>
                        <th>已出库数量</th>
                        <th>制单时间</th>
                        <th>制单人</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($out_warehouses as $out_warehouse)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox"></td>
                            <td class="magenta-color">{{$out_warehouse->number}}</td>
                            <td>{{$out_warehouse->returned_number}}</td>
                            <td>{{$out_warehouse->storage_name}}</td>
                            <td>{{$out_warehouse->count}}</td>
                            <td>{{$out_warehouse->out_count}}</td>
                            <td>{{$out_warehouse->created_at_val}}</td>
                            <td>{{$out_warehouse->user_name}}</td>
                            <td tdr="nochect">
                                <button type="button" id="edit-enter" value="{{$out_warehouse->id}}" class="btn btn-white btn-sm mr-r edit-enter">编辑出库</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($out_warehouses)
                <div class="col-md-6 col-md-offset-6">{!! $out_warehouses->render() !!}</div>
            @endif
        </div>

        <div class="modal fade bs-example-modal-lg" id="in-warehouse" tabindex="-1" role="dialog"
             aria-labelledby="appendskuLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            编辑出库
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="addsku" method="post" action="{{ url('/outWarehouse/update') }}">
                            <div id="append-sku" class="container-fluid">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-magenta">确定</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
