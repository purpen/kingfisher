@extends('home.base')

@section('title', '采购单详细')

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
                        采购单详情
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <form id="add-purchase" role="form" method="post" action="{{ url('/purchase/update') }}">
            <div class="row ui white ptb-4r">
                <div class="col-md-12">
                    <div class="form-inline">
                        <div class="form-group vt-34">选择供应商：</div>
                        <div class="form-group pr-4r mr-2r">
                            <span>{{$purchase->supplier}}</span>
                        </div>
                        <div class="form-group vt-34">入库仓库：</div>
                        <div class="form-group pr-4r mr-2r">
                            <span>{{$purchase->storage}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ui white ptb-4r">
                <div class="well-lg textc mlr-3r mt-r">
                    <table class="table" style="margin-bottom:20px;">
                        <thead class=" table-bordered">
                        <tr>
                            <th>商品图片</th>
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>采购数量</th>
                            <th>已入库数量</th>
                            <th>采购价</th>
                            <th>总价</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!---->
                        @foreach($purchase_sku_relation as $purchase_sku)
                            <tr>
                                <td><img src="" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                                <td class="fb">{{$purchase_sku->number}}</td>
                                <td>{{$purchase_sku->name}}</td>
                                <td>{{$purchase_sku->mode}}</td>
                                <td>{{$purchase_sku->count}}</td>
                                <td id="warehouseQuantity0">{{$purchase_sku->in_count}}</td>
                                <td>{{$purchase_sku->price}}</div></td>
                                <td id="totalTD0">{{$purchase_sku->count * $purchase_sku->price}}</td>
                            </tr>
                        @endforeach
                        <tr style="background:#dcdcdc;border:1px solid #dcdcdc; " id="append-sku">
                            <td colspan="4" class="fb">合计：</td>
                            <td colspan="2" class="fb">采购数量总计：<span class="red" id="skuTotalQuantity">{{$purchase->count}}</span></td>
                            <td colspan="3" class="fb">采购总价：<span class="red" id="skuTotalFee">{{$purchase->price}}</span></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="form-horizontal">
                    <div class="form-group mlr-0">
                        <div class="lh-34 m-56 ml-3r fl">备注</div>
                        <div class="col-sm-5 pl-0">
                            {{$purchase->summary}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4r pt-2r">
                <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">返回</button>
            </div>
        </form>
    </div>
@endsection

@section('customize_js')
    @parent

@endsection
