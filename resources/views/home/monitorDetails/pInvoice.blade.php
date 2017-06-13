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
                <p><strong>供应商名称：</strong> <span>{{$pInvoice->supplier_name}}</span></p>
                <p><strong>商品名称：</strong> <span>{{$pInvoice->product_name}}</span></p>
                <p><strong>规格模型：</strong> <span>{{$pInvoice->mode}}</span></p>
                <p><strong>单位：</strong> <span>{{$pInvoice->weight}}</span></p>
                <p><strong>单价：</strong> <span>{{$pInvoice->unit_price}}</span></p>
                <p><strong>数量：</strong> <span>{{$pInvoice->count}}</span></p>
                <p><strong>总价：</strong> <span>{{$pInvoice->price}}</span></p>
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