@extends('home.base')

@section('title', '入库完成')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    {{--<script>--}}
    @parent
    var _token = $("#_token").val();
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
    });

    $(".edit-enter").click(function () {
    var id = $(this).attr("value");
    $.get("{{url('/enterWarehouse/ajaxEdit')}}",{'enter_warehouse_id':id},function (e) {
    if(e.status){
    var template = [
    '                                {{ csrf_field() }}',
    '                                <div class="row mb-2r">',
        '                                    <div class="btn-group-block">',
            '                                        @{{#enter_warehouse}}<div class="form-group">选择仓库：@{{storage_name}}</div><input type="hidden" name="enter_warehouse_id" value="@{{id}}">@{{/enter_warehouse}}',
            '                                    </div>',
        '                                    <div class="tl lh30 scrollspy-example" style="max-height:230px;overflow:auto;" >',
            '                                        <table style="margin-bottom:0" class="table table-striped table-hover">',
                '                                            <thead class=" table-bordered">',
                '                                            <tr>',
                    '                                                <th>SKU编码</th>',
                    '                                                <th>商品名称</th>',
                    '                                                <th>商品属性</th>',
                    '                                                <th>需入库数量</th>',
                    '                                                <th>已入库数量</th>',
                    '                                            </tr>',
                '                                            </thead>',
                '                                            <tbody style="font-weight:normal">',
                '                                            @{{#enter_sku}}<tr>',
                    '<input type="hidden" name="enter_sku_id[]" value="@{{id}}">',
                    '                                                <td class="fb">',
                        '@{{number}}',
                        '                                                    <input type="hidden" name="sku_id[]" value="@{{sku_id}}">',
                        '                                                </td>',
                    '                                                <td>@{{name}}</td>',
                    '                                                <td>@{{mode}}</td>',
                    '                                                <td>@{{count}}</td>',
                    '                                                <td>@{{in_count}}</td>',
                    '                                            </tr>@{{/enter_sku}}',
                '                                            <tr style="background:#dcdcdc;border:1px solid #dcdcdc; ">',
                    '                                                <td colspan="3" class="fb">合计：</td>',
                    '                                                @{{#enter_warehouse}}<td class="fb">需入库合计：<span id="total" class="red">@{{count}}</span></td>',
                    '                                                <td class="fb">已入库合计：<span id="changetotal" spantotal="0" class="red">@{{in_count}}</span></td>',
                    '                                                <td class="fb">未入库合计：<span id="changetotal" spantotal="0" class="red">@{{not_count}}</span></td>',
                    '                                            </tr>',
                '                                            </tbody>',
                '                                        </table>',
            '                                    </div>',
        '                                    <div class="tl lh30 pt10">',
            '                                        <div class="row f14 fb mt20">',
                '                                            <div class="col-sm-12">入库备注</div>',
                '                                            <div class="col-sm-12">',
                    '                                                @{{summary}}@{{/enter_warehouse}}',
                    '                                            </div>',
                '                                        </div>',
            '                                    </div>',
        '                                </div>',
    '                        </div>'].join("");
    var views = Mustache.render(template, e.data);
    $("#append-sku").html(views);
    $("#in-warehouse").modal('show');
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
                        入库单
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li><a href="{{url('/enterWarehouse')}}">采购入库()</a></li>
                        <li><a href="">销售退货入库</a></li>
                        <li><a href="{{url('/enterWarehouse/changeEnter')}}">调拨入库</a></li>
                        <li class="active"><a href="{{url('/enterWarehouse/complete')}}">完成入库</a></li>
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
                        <th>入库单编号</th>
                        <th>相关采购单</th>
                        <th>入库仓库</th>
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
                            <td class="text-center"><input name="Order" active="0" type="checkbox"></td>
                            <td class="magenta-color">{{$enter_warehouse->number}}</td>
                            <td>{{$enter_warehouse->purchase_number}}</td>
                            <td>{{$enter_warehouse->storage_name}}</td>
                            <td>{{$enter_warehouse->count}}</td>
                            <td>{{$enter_warehouse->in_count}}</td>
                            <td>{{$enter_warehouse->created_at}}</td>
                            <td>{{$enter_warehouse->user_name}}</td>
                            <td>
                                <button type="button" id="edit-enter" value="{{$enter_warehouse->id}}" class="btn btn-white btn-sm mr-r edit-enter">详细</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($enter_warehouses)
                <div class="col-md-6 col-md-offset-6">{!! $enter_warehouses->render() !!}</div>
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
                            编辑入库
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="addsku">
                            <div id="append-sku" class="container-fluid">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
