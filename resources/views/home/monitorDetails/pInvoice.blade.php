@extends('home.base')

@section('customize_css')
    @parent
    .check-btn{
    padding: 10px 0;
    height: 30px;
    position: relative;
    margin-bottom: 10px !important;
    margin-left: 10px !important;
    }
    .check-btn input{
    z-index: 2;
    width: 100%;
    height: 100%;
    top: 6px !important;
    opacity: 0;
    left: 0;
    margin-left: 0 !important;
    color: transparent;
    background: transparent;
    cursor: pointer;
    }
    .check-btn button{
    position: relative;
    top: -11px;
    left: 0;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        采购发票详情
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row formwrapper">
            <div class="col-md-12">
                <p><strong>发票信息：</strong> <span>{{$pInvoice->invoice_info}}</span></p>
                <p><strong>开票日期：</strong> <span>{{ $pInvoice->invoice_info ? $pInvoice->created_at : ''}}</span></p>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="active">
                        <th>供应商名称</th>
                        <th>供应商编号</th>
                        <th>商品名称</th>
                        <th>商品规格</th>
                        <th>商品单位</th>
                        <th>单价</th>
                        <th>数量</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($purchase_sku_relations as $purchase_sku_relation)
                        <tr>
                            <td>{{$purchase_sku_relation->productsSku->product->supplier ? $purchase_sku_relation->productsSku->product->supplier->name : ''}}</td>
                            <td>{{$purchase_sku_relation->productsSku->product->supplier ? $purchase_sku_relation->productsSku->product->supplier->random_id : ''}}</td>
                            <td>{{$purchase_sku_relation->productsSku->product->title}}</td>
                            <td>{{$purchase_sku_relation->productsSku->mode}}</td>
                            <td>{{$purchase_sku_relation->productsSku->weight}}</td>
                            <td>{{$purchase_sku_relation->price}}</td>
                            <td>{{$purchase_sku_relation->count}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">
            <i class="glyphicon glyphicon-arrow-left"></i> 返回列表
        </button>
    </div>
@endsection
@section('customize_js')
    @parent

@endsection