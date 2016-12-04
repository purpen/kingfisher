@extends('home.base')

@section('title', '调拨入库')

@section('customize_js')
    @parent
    var _token = $("#_token").val();

    {{--1可提交 0:阻止提交--}}
    var submit_status = 1;

    $("#addsku").submit(function () {
        if(submit_status == 0){
            return false;
        }
    });

    $(".edit-enter").click(function () {
    var id = $(this).attr("value");
    $.get("{{url('/enterWarehouse/ajaxEdit')}}",{'enter_warehouse_id':id},function (e) {
        if(e.status){
        var template = [
        '                                {{ csrf_field() }}',
        '                                <div class="row mb-2r">',
            '                                    <div class="btn-group-block">',
                '                                        <div class="form-group">商品扫描：</div>',
                '                                        <div class="form-group mr20">',
                    '                                            <div class="input-group"><input id="goodsSku" type="text" class="form-control"></div>',
                    '                                        </div>',
                '                                        @{{#enter_warehouse}}<div class="form-group">入库仓库：@{{storage_name}}</div><input type="hidden" name="enter_warehouse_id" value="@{{id}}">@{{/enter_warehouse}}',
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
                        '                                                <th>本次入库数量</th>',
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
                        '                                                <td>',
                            '                                                    <div class="form-group form-group-input">',
                                '                                                        <input type="text" not_count="@{{not_count}}" name="count[]" class="form-control input-operate integer count" value="@{{not_count}}" data-toggle="popover" data-placement="top" data-content="数量不能大于库存数量">',
                                '                                                    </div>',
                            '                                                </td>',
                        '                                            </tr>@{{/enter_sku}}',
                    '                                            <tr style="background:#dcdcdc;border:1px solid #dcdcdc; ">',
                        '                                                <td colspan="3" class="fb">合计：</td>',
                        '                                                @{{#enter_warehouse}}<td class="fb"><span id="total" class="red">@{{count}}</span></td>',
                        '                                                <td class="fb"><span id="changetotal" spantotal="0" class="red">@{{in_count}}</span></td>',
                        '                                                <td class="fb">未入库合计：<span id="changetotal" spantotal="0" class="red">@{{not_count}}</span></td>',
                        '                                            </tr>',
                    '                                            </tbody>',
                    '                                        </table>',
                '                                    </div>',
            '                                    <div class="tl lh30 pt10">',
                '                                        <div class="row f14 fb mt20">',
                    '                                            <div class="col-sm-12">入库备注</div>',
                    '                                            <div class="col-sm-12">',
                        '                                                <textarea rows="3" class="form-control" name="summary" style="width: 100%;">@{{summary}}</textarea>@{{/enter_warehouse}}',
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
                    $(this).popover('show');
                    $(this).focus();
                    submit_status = 0;
                }else{
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
        }else{
            alert(e.message);
        }
    }, 'json');

    });

@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
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
    </div>
    
    <div class="container mainwrap">
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th class="text-center"><input type="checkbox" id="checkAll"></th>
                    <th>编号</th>
                    <th>相关单据</th>
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
                        <td class="text-center"><input name="Order" type="checkbox"></td>
                        <td class="magenta-color">{{$enter_warehouse->number}}</td>
                        <td>{{$enter_warehouse->purchase_number}}</td>
                        <td>{{$enter_warehouse->storage->name}}</td>
                        <td>{{$enter_warehouse->count}}</td>
                        <td>{{$enter_warehouse->in_count}}</td>
                        <td>{{$enter_warehouse->created_at_val}}</td>
                        <td>{{$enter_warehouse->user->realname}}</td>
                        <td tdr="nochect">
                            <button type="button" id="edit-enter" value="{{$enter_warehouse->id}}" class="btn btn-white btn-sm mr-r edit-enter">编辑入库</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($enter_warehouses)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">{!! $enter_warehouses->render() !!}</div>
        </div>
        @endif
        
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
                        <form id="addsku" method="post" action="{{ url('/enterWarehouse/update') }}">
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
        </div>
    </div>
    
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
