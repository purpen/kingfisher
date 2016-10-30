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
                    <input type="hidden" id="supplier_id" name="supplier_id">
                    <input type="hidden" id="purchase_id" name="purchase_id">
                    {!! csrf_field() !!}
                    <h5>退货单信息</h5>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-4 form-inline">
                            <input type="text" id="number" class="form-control" placeholder="采购单编号"> 
                            <a id="purchase-add" class="btn btn-magenta">
                                <i class="glyphicon glyphicon-edit"></i> 添加采购单
                            </a>
                        </div>
                    </div>
                    
                    <h5 class="return-space">
                        退货商品 
                        <small>共<span>0</span>件</small>
                    </h5>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <select class="selectpicker" id="storage_id" name="storage_id">
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
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
                                <th>实付</th>
                                <th>数量</th>
                                <th>已出库数量</th>
                                <th>退货数量</th>
                                <th>退货价格</th>
                            </tr>
                        </thead>
                        <tbody id="sku-list">
                        </tbody>
                        <tfoot>
                            <tr class="active">
                                <td colspan="9">
                                    <span>退款金额共计: <span class="magenta-color">0</span> 元</span>
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
    @include('mustache.return_product_item')
@endsection

@section('load_private')
    {{--根据名称或编号搜索--}}
    $('#purchase-add').bind('click', function(){
        var val = $("#number").val();
        if (val == '') {
            alert('采购单号输入为空');
            return;
        }
        
        $.get('/returned/ajaxPurchase', {'number':val}, function(e){
            if (e.status) {
                var template = $('#returned-product-form').html();
                var views = Mustache.render(template, e.data);
                
                $("#supplier_id").val(e.data.purchase.supplier_id);
                $("#purchase_id").val(e.data.purchase.id);
                
                $("#sku-list").html(views);
            } else {
                alert(e.message);
            }
        
            $(".count").focusout(function () {
                var max_value = $(this).attr("not_count");
                var value = $(this).val();
                if(parseInt(value) > parseInt(max_value)){
                    alert("出库数量不能大于" + max_value);
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
                    storage_id: {
                        validators: {
                            notEmpty: {
                                message: '请选择入库仓库！'
                            }
                        }
                    },
                    'count[]': {
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
                    'price[]': {
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
        },'json');
    });
@endsection
