@extends('home.base')

@section('title', '采购单详情')

@section('customize_css')
    @parent
    .scrollt {
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
                        采购单详情
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row formwrapper">
            <div class="col-md-12">
                <h5>基本信息</h5>
                <hr>
                <p><strong>采购类型：</strong> <span>{{$purchase->type_val}}</span></p>
                <p><strong>来源供应商：</strong> <span>{{$purchase->supplier}}</span></p>
                <p><strong>预计到货时间：</strong> <span>@if($purchase->predict_time != '0000-00-00') {{$purchase->predict_time}} @endif</span></p>
                <p><strong>入库仓库：</strong> <span>{{$purchase->storage}}</span></p>
                <p><strong>备注说明：</strong> {{$purchase->summary}}</p>
                {{--<p><strong>付款条件：</strong> {{$purchase->paymentcondition}}</p>--}}
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="active">
                            <th>商品图片</th>
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>已入库数量</th>
                            <th>采购价</th>
                            <th>采购数量</th>
                            <th>运费</th>
                            <th>商品税率</th>
                            <th>总价</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($purchase_sku_relation as $purchase_sku)
                        <tr>
                            <td><img src="{{$purchase_sku->path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                            <td class="fb">{{$purchase_sku->number}}</td>
                            <td>{{$purchase_sku->name}}</td>
                            <td>{{$purchase_sku->mode}}</td>
                            <td id="warehouseQuantity0" >{{$purchase_sku->in_count}}</td>
                            <td>{{$purchase_sku->price}}</td>
                            <td>{{$purchase_sku->count}}</td>
                            <td>{{$purchase_sku->freight}}</td>
                            <td>{{$purchase_sku->tax_rate}}</td>
                            <td id="totalTD0">{{$purchase_sku->count * $purchase_sku->price}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="active" id="append-sku">
                            <td colspan="4" class="fb">合计</td>
                            <td colspan="1" class="fb">附加费用：<span class="red">{{$purchase->surcharge}}</span></td>
                            <td colspan="2" class="fb">采购数量总计：<span class="red" id="skuTotalQuantity">{{$purchase->count}}</span></td>
                            <td colspan="3" class="fb">采购总价：<span class="red" id="skuTotalFee">{{$purchase->price}}</span>元</td>
                        </tr>
                    </tfoot>
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
