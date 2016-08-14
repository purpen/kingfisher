@extends('home.base')

@section('title', '新增调拨单')

@section('customize_css')
    @parent
    .scrollt{
    height:400px;
    overflow:hidden;
    }
    .sublock{
    display: block !important;
    margin-left: -15px;
    margin-right: -15px;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        新增调拨单
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="add-purchase" role="form" method="post" action="{{ url('/changeWarehouse/store') }}">
            <div class="row ui white ptb-4r">
                <div class="col-md-12">
                    <div class="form-inline">
                        <div class="form-group vt-34">出库仓库：</div>
                        <div class="form-group pr-4r mr-2r">
                            <select class="selectpicker" id="out_storage_id" name="out_storage_id" style="display: none;">
                                <option value=''>选择出库仓库</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group vt-34">入库仓库：</div>
                        <div class="form-group pr-4r mr-2r">
                            <select class="selectpicker" id="in_storage_id" name="in_storage_id" style="display: none;">
                                <option value="">选择入库仓库</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-magenta" data-toggle="modal" id="addpurchase-button">
                            ＋添加调拨商品
                        </button>
                        <div class="modal fade" id="addpurchase" tabindex="-1" role="dialog" aria-labelledby="addpurchaseLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="gridSystemModalLabel">添加商品</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <input id="search_val" type="text" placeholder="请输入SKU编码/商品名称" class="form-control">
											<span class="input-group-btn">
                  								<button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                  							</span>
                                        </div>
                                        <div class="mt-4r scrollt">
                                            <div id="sku-list"></div>
                                        </div>
                                        <div class="form-group mb-0 sublock">
                                            <div class="modal-footer pb-r">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                <button type="button" id="choose-sku" class="btn btn-magenta">确定</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ui white ptb-4r">
                <div class="well-lg textc mlr-3r mt-r">
                    <table class="table table-striped table-hover" style="margin-bottom:20px;">
                        <thead class=" table-bordered">
                        <tr>
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>库存数量</th>
                            <th>调出数量</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="append-sku">

                        </tbody>
                    </table>
                </div>
                <div class="form-horizontal">
                    <div class="form-group mlr-0">
                        <div class="lh-34 m-56 ml-3r fl">备注</div>
                        <div class="col-sm-5 pl-0">
                            <textarea rows="3" class="form-control" name="summary" id="memo"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4r pt-2r">
                <button type="submit" class="btn btn-magenta mr-r save">保存</button>
                <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">取消</button>
            </div>
            {!! csrf_field() !!}
        </form>
    </div>
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
        var sku_data = '';
        var sku_id = [];

        {{--根据仓库显示商品列表--}}
        $("#addpurchase-button").click(function () {
            var out_storage_id = $("#out_storage_id").val();
            if(out_storage_id == ''){
                alert('请选择出库仓库');
            }else{
                $.get('/changeWarehouse/ajaxSkuList',{'storage_id':out_storage_id},function (e) {
                    if (e.status){
                        var template = ['<table class="table table-bordered table-striped">',
                            '<thead>',
                            '<tr class="gblack">',
                            '<th class="text-center"><input type="checkbox" id="checkAll"></th>',
                            '<th>商品图</th>',
                            '<th>SKU编码</th>',
                            '<th>商品名称</th>',
                            '<th>属性</th>',
                            '<th>库存</th>',
                            '</tr>',
                            '</thead>',
                            '<tbody>',
                            '@{{#data}}<tr>',
                            '<td class="text-center"><input class="sku-order" type="checkbox" active="0" value="@{{id}}"></td>',
                            '<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
                            '<td>@{{ number }}</td>',
                            '<td>@{{ name }}</td>',
                            '<td>@{{ mode }}</td>',
                            '<td>@{{ count }}</td>',
                            '</tr>@{{/data}}',
                            '</tbody>',
                            '</table>',
                        ].join("");
                        var views = Mustache.render(template, e);
                        sku_data = e.data;
                        $("#sku-list").html(views);
                        $("#addpurchase").modal('show');
                    }
                },'json');
            }
        });

        {{--根据名称或编号搜索--}}
        $("#sku_search").click(function () {
            var val = $("#search_val").val();
            var out_storage_id = $("#out_storage_id").val();
            if(val == ''){
                alert('输入为空');
            }else{
                $.get('/changeWarehouse/ajaxSearch',{'storage_id':out_storage_id,'where':val},function (e) {
                    if (e.status){
                        var template = ['<table class="table table-bordered table-striped">',
                            '<thead>',
                            '<tr class="gblack">',
                            '<th class="text-center"><input type="checkbox" id="checkAll"></th>',
                            '<th>商品图</th>',
                            '<th>SKU编码</th>',
                            '<th>商品名称</th>',
                            '<th>属性</th>',
                            '<th>库存</th>',
                            '</tr>',
                            '</thead>',
                            '<tbody>',
                            '@{{#data}}<tr>',
                            '<td class="text-center"><input name="Order" class="sku-order" type="checkbox" active="0" value="@{{id}}"></td>',
                            '<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
                            '<td>@{{ number }}</td>',
                            '<td>@{{ name }}</td>',
                            '<td>@{{ mode }}</td>',
                            '<td>@{{ count }}</td>',
                            '</tr>@{{/data}}',
                            '</tbody>',
                            '</table>',
                        ].join("");
                        var views = Mustache.render(template, e);
                        $("#sku-list").html(views);
                        sku_data = e.data;
                    }
                },'json');
            }
        });

        $("#choose-sku").click(function () {
            var skus = [];
            var sku_tmp = [];
            $(".sku-order").each(function () {
                if($(this).is(':checked')){
                    if($.inArray(parseInt($(this).attr('value')),sku_id) == -1){
                        sku_id.push(parseInt($(this).attr('value')));
                        sku_tmp.push(parseInt($(this).attr('value')));
                    }
                }
            });
            for (var i=0;i < sku_data.length;i++){
                if(jQuery.inArray(parseInt(sku_data[i].id),sku_tmp) != -1){
                    skus.push(sku_data[i]);
                }
            }
            var template = ['@{{#skus}}<tr><input type="hidden" name="sku_id[]" value="@{{ sku_id }}">',
                '                            <td>@{{ number }}</td>',
                '                            <td>@{{ name }}</td>',
                '                            <td>@{{ mode }}</td>',
                '                            <td>@{{ count }}</td>',
                '                            <td><div class="form-group"><input type="text" class="form-control integer count" placeholder="输入数量" max_value="@{{ count }}" name="count[]"></div></td>',
                '                            <td><a href="javascript:void(0);" class="delete">删除</a></td>',
                '                        </tr>@{{/skus}}'].join("");
            var data = {};
            data['skus'] = skus;
            console.log(data);
            var views = Mustache.render(template, data);
            $("#append-sku").append(views);
            $("#addpurchase").modal('hide');
            $(".delete").click(function () {
                $(this).parent().parent().remove();
            });
            $(".count").focusout(function () {
                var max_value = $(this).attr("max_value");
                var value = $(this).val();
                if(parseInt(value) > parseInt(max_value)){
                    alert("调拨数量不能大于" + max_value);
                    $(this).focus();
                }
            });


            $("#add-purchase").formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    out_storage_id: {
                        validators: {
                            notEmpty: {
                                message: '请选择出库仓库！'
                            }
                        }
                    },
                    in_storage_id: {
                        validators: {
                            notEmpty: {
                                message: '请选择入库仓库！'
                            }
                        }
                    },
                    'count[]': {
                        validators: {
                            notEmpty: {
                                message: '调拨数量不能为空！'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: '调拨数量格式不正确！'
                            }
                        }
                    },
                }
            });
        });
@endsection
