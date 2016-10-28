@extends('home.base')

@section('title', '修改采购单')

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
                        修改采购单
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mainwrap">
        <div class="row formwrapper">
            <div class="col-md-12">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form id="add-purchase" role="form" method="post" class="form-horizontal" action="{{ url('/purchase/update') }}">
                    <h5>基本信息</h5>
                    <hr>
                    <div class="form-group">
                        <label for="weight" class="col-sm-1 control-label">采购类型</label>
                        <div class="col-sm-2">
                            <select class="selectpicker" id="supplier_type" name="type" style="display: none;">
                                <option value='1' @if($purchase->type == 1) selected @endif>老款补货</option>
                                <option value='2' @if($purchase->type == 2) selected @endif>新品到货</option>
                            </select>
                        </div>

                        <label for="weight" class="col-sm-1 control-label">选择供应商</label>
                        <div class="col-sm-2">
                            <select class="selectpicker" id="supplier_id" name="supplier_id" style="display: none;">
                                <option value=''>选择供应商</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{($purchase->supplier_id == $supplier->id)?'selected':''}}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <label for="weight" class="col-sm-1 control-label">入库仓库</label>
                        <div class="col-sm-2">
                            <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
                                <option value="">选择仓库</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}" {{($purchase->storage_id == $storage->id)?'selected':''}}>{{ $storage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-magenta" data-toggle="modal" id="addpurchase-button">
    							＋ 添加采购商品
    						</button>
                        </div>
                    </div>
                    <hr>
                    
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
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="hidden" name="purchase_id" value="{{$purchase->id}}">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="active">
                                        <th>商品图片</th>
                                        <th>SKU编码</th>
                                        <th>商品名称</th>
                                        <th>商品属性</th>
                                        <th>采购数量</th>
                                        <th>已入库数量</th>
                                        <th>采购价</th>
                                        <th>总价</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase_sku_relation as $purchase_sku)
                                    <tr>
                                        <td><img src="" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                                        <td class="fb">{{$purchase_sku->number}}</td>
                                        <td>{{$purchase_sku->name}}</td>
                                        <td>{{$purchase_sku->mode}}</td>
                                        <input type="hidden" name="sku_id[]" value="{{$purchase_sku->sku_id}}">
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" class="form-control integer operate-caigou-blur" name="count[]" placeholder="" value="{{$purchase_sku->count}}">
                                            </div>
                                        </td>
                                        <td id="warehouseQuantity0">{{$purchase_sku->in_count}}</td>
                                        <td>
                                            <div style="width:100px;">
                                                <input type="text" name="price[]" class="form-control operate-caigou-blur" value="{{$purchase_sku->price}}" placeholder="0.00">
                                            </div>
                                        </td>
                                        <td id="totalTD0">{{$purchase_sku->count * $purchase_sku->price}}</td>
                                        <td><a class="delete" href="javascript:void(0)">删除</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr id="append-sku" class="active">
                                        <td colspan="4" class="fb">合计</td>
                                        <td colspan="2" class="fb">采购数量总计：<span class="red" id="skuTotalQuantity">{{$purchase->count}}</span></td>
                                        <td colspan="3" class="fb">采购总价：<span class="red" id="skuTotalFee">{{$purchase->price}}</span>元</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">预计到货</label>
                        <div class="col-sm-11">
                            <input type="date" name="predict_time" value="{{$purchase->predict_time}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">备注信息</label>
                        <div class="col-sm-11">
                            <textarea rows="2" class="form-control" name="summary" id="memo">{{$purchase->summary}}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-1">
            				<button type="submit" class="btn btn-magenta btn-lg save">确认保存</button>
            				<button type="button" class="btn btn-white btn-lg cancel once"  onclick="window.history.back()">取消</button>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customize_js')
    @parent
    var sku_data = '';
    var sku_id = [];
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
    });
    $('.scrollt tbody tr').click(function(){
    if( $(this).find("input[name='Order']").attr('active') == 0 ){
    $(this).find("input[name='Order']").prop("checked", "checked").attr('active','1');
    }else{
    $(this).find("input[name='Order']").prop("checked", "").attr('active','0');
    }
    });

    {{--根据供应商显示商品列表--}}
    $("#addpurchase-button").click(function () {
    var supplier_id = $("#supplier_id").val();
    if(supplier_id == ''){
    alert('请选择供应商');
    }else{
    $.get('/productsSku/ajaxSkus',{'supplier_id':supplier_id},function (e) {
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
            '<td>@{{ quantity }}</td>',
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
    if(val == ''){
    alert('输入为空');
    }else{
    $.get('/productsSku/ajaxSearch',{'where':val},function (e) {
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
            '<td class="text-center"><input type="checkbox" active="0" value="@{{id}}"></td>',
            '<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
            '<td>@{{ number }}</td>',
            '<td>@{{ name }}</td>',
            '<td>@{{ mode }}</td>',
            '<td>@{{ quantity }}</td>',
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
    $(".sku-order").each(function () {
        if($(this).is(':checked')){
            if($.inArray(parseInt($(this).attr('value')),sku_id) == -1){
                sku_id.push(parseInt($(this).attr('value')));
            }
        }
    });
    for (var i=0;i < sku_data.length;i++){
        if(jQuery.inArray(sku_data[i].id,sku_id) != -1){
            skus.push(sku_data[i]);
        }
    }
    var template = [
        '					@{{#skus}}<tr>',
            '								<td><img src="" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>',
            '								<td class="fb">@{{number}}</td>',
            '<input type="hidden" name="sku_id[]" value="@{{id}}">',
            '								<td>@{{name}}</td>',
            '								<td>@{{mode}}</td>',
            '								<td><div class="form-group" style="width:100px;"><input type="text" class="form-control integer operate-caigou-blur" name="count[]" placeholder="采购数量"></div></td>',
            '								<td id="warehouseQuantity0">@{{quantity}}</td>',
            '								<td><div class="form-group" style="width:100px;"><input type="text" name="price[]" class="form-control operate-caigou-blur" placeholder="0.00"></div></td>',
            '								<td id="totalTD0">0.00</td>',
            '								<td class="delete"><a href="javascript:void(0)">删除</a></td>',
            '							</tr>@{{/skus}}',].join("");;
        var data = {};
        data['skus'] = skus;
        var views = Mustache.render(template, data);
        $("#append-sku").before(views);
        $("#addpurchase").modal('hide');
        $(".delete").click(function () {
            $(this).parent().remove();
        });

    });
    $(".delete").click(function () {
        $(this).parent().parent().remove();
    });

    $("#add-purchase").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            storage_id: {
                validators: {
                    notEmpty: {
                        message: '请选择入库仓库！'
                    }
                }
            },
            supplier_id: {
                validators: {
                    notEmpty: {
                        message: '请选择供应商！'
                    }
                }
            },
            'count[]': {
                validators: {
                    notEmpty: {
                        message: '采购数量不能为空！'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '采购数量填写不正确！'
                    }
                }
            },
            'price[]': {
                validators: {
                    notEmpty: {
                        message: '采购价格不能为空！'
                    },
                    regexp: {
                        regexp: /^[0-9\.]+$/,
                        message: '采购价格填写不正确！'
                    }
                }
            },

        }
    });

@endsection
