@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        新增退货单
                    </div>
                </div>
                @include('home.purchase.returned_subnav')
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        @include('block.form-errors')

        @if (session('error_message'))
            <div class="alert alert-danger">
                <ul>
                    <li>{{session('error_message')}}</li>
                </ul>
            </div>
        @endif
        <div class="row formwrapper">
            <div class="col-md-12">
                <form id="add-purchase" role="form" method="post" class="form-horizontal" action="{{ url('/returned/store') }}">
                    <input type="hidden" id="supplier_id" name="supplier_id" value="{{$purchase->supplier_id}}">
                    <input type="hidden" id="purchase_id" name="purchase_id" value="{{$purchase->id}}">
                    {!! csrf_field() !!}
                    <h5>退货单信息</h5>
                    <hr>

                    <div class="form-group">
                        <label for="number" class="col-sm-1 control-label">仓库:</label>
                        <div class="col-sm-2">
                            <select class="selectpicker" id="storage_id" name="storage_id">
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="number" class="col-sm-1 control-label">部门:</label>
                        <div class="col-sm-2">
                            <select class="selectpicker" id="department" name="department" style="display: none;">
                                <option value="">选择部门</option>
                                <option @if($purchase->department == 1) selected @endif value="1">fiu</option>
                                <option @if($purchase->department == 2) selected @endif value="2">D3IN</option>
                                <option @if($purchase->department == 3) selected @endif value="3">海外</option>
                                <option @if($purchase->department == 4) selected @endif value="4">电商</option>
                            </select>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th>商品图</th>
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>属性</th>
                            <th>采购金额</th>
                            <th>数量</th>
                            <th>退货数量</th>
                            <th>退货价格</th>
                            <th>金额小计</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($purchase_sku_relation as $v)
                        <tr class="maindata">
                            <td><img src="{{$v->path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                            <td class="fb">{{$v->number}}</td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->mode}}</td>
                            <td>{{$v->total}}元</td>
                            <td>{{$v->count}}</td>
                            <td>
                                <input type="hidden" name="sku_id[]" value="{{$v->sku_id}}">
                                <input type="hidden" name="purchase_count[]" value="{{$v->count}}">
                                <input type="text" class="form-control interger count" not_count="{{$v->count}}" placeholder="数量" id="count" name="count[]" value="" data-toggle="popover" data-placement="top" data-content="数量不能大于采购数量">
                            </td>
                            <td>
                                <input type="text" class="form-control interger price" placeholder="金额" id="price" name="price[]" purchase_price="{{$v->price}}" value="{{$v->price}}" data-toggle="popover" data-placement="top" data-content="价格不能大于采购价格">
                            </td>
                            <td class="total">0.00</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="active">
                            <td colspan="9">
                                <span>退款金额共计: <span id="TotalFee" class="magenta-color">0</span> 元</span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>

                    <div class="form-group">
                        <label for="summary" class="col-sm-1 control-label">备注说明</label>
                        <div class="col-sm-4">
                            <textarea rows="3" class="form-control" name="summary"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-magenta mr-r save">确认提交</button>
                            <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('load_private')
    {{--<script>--}}
    {{--1可提交 0:阻止提交--}}
    var submit_status = 1;

    $("#add-purchase").submit(function () {
        if(submit_status == 0){
            return false;
        }
    });

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

    $(".price").focusout(function () {
        var max_value = $(this).attr("purchase_price");
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
            department: {
                validators: {
                    notEmpty: {
                        message: '部门不能为空！'
                    }
                }
            },
            "count[]": {
                validators: {
                    notEmpty: {
                        message: '退货数量不能为空！'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '退货数量填写不正确！'
                    }
                }
            },
            "price[]": {
                validators: {
                    notEmpty: {
                        message: '退货价格不能为空！'
                    },
                    regexp: {
                        regexp: /^[0-9\.]+$/,
                        message: '退货价格填写不正确！'
                    }
                }
            }
        }
    });

    $("input[name='count[]']").livequery(function(){
        $(this)
                .css("ime-mode", "disabled")
                .keydown(function(){
                    if(event.keyCode==13){
                        event.keyCode=9;
                    }
                })
                .keypress(function(){
                    if ((event.keyCode<48 || event.keyCode>57)){
                        event.returnValue=false ;
                    }
                })
                .keyup(function(){
                    var quantity = $(this).val();
                    var price = $(this).parent().siblings().children("input[name='price[]']").val();
                    var total = quantity * price;
                    $(this).parent().siblings(".total").html(total.toFixed(2));
                    var alltotal = 0;
                    for(i=0;i<$('.maindata').length;i++){
                        alltotal = alltotal + Number($('.maindata').eq(i).find('.total').text());
                    }
                    $('#TotalFee').html(alltotal);
                })
    });
    $("input[name='price[]']").livequery(function(){
        $(this)
                .css("ime-mode", "disabled")
                .keypress(function(){
                    if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
                        event.returnValue=false;
                    }
                })
                .keyup(function(){
                    var quantity = $(this).parent().siblings().children("input[name='count[]']").val();
                    var price = $(this).val();
                    var total = quantity * price;
                    $(this).parent().siblings(".total").html(total.toFixed(2));
                    var alltotal = 0;
                    var allquantity = 0;
                    for(i=0;i<$('.maindata').length;i++){
                        alltotal = alltotal + Number($('.maindata').eq(i).find('.total').text());
                        allquantity = allquantity + Number($('.maindata').eq(i).find("input[name='count[]']").val())
                    }
                    $('#skuTotalFee').html(alltotal);
                    $('#skuTotalQuantity').html(allquantity);
                })
    });
@endsection
