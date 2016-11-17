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
                        @foreach($purchase_sku_relation as $v)
                        <tr>
                            <td><img src="{{$v->path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                            <td class="fb">{{$v->number}}</td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->mode}}</td>
                            <td>{{$v->total}}元</td>
                            <td>{{$v->count}}</td>
                            <td>0</td>
                            <td>
                                <input type="hidden" name="sku_id[]" value="{{$v->sku_id}}">
                                <input type="hidden" name="purchase_count[]" value="{{$v->count}}">
                                <input type="text" class="form-control interger count" not_count="{{$v->count}}" placeholder="数量" name="count[]" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control interger" placeholder="金额" name="price[]" value="">
                            </td>
                        </tr>
                        @endforeach
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
@endsection
