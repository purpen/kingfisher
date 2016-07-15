@extends('home.base')

@section('title', '新增退货单')

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
                        修改退货单
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <form id="add-purchase" role="form" method="post" action="{{ url('/returned/update') }}">
            <div class="row ui white ptb-4r">
                <div class="col-md-3">采购退货单号：<span></span>{{$returned->number}}</div>
                <div class="col-md-3">采购单号：<span></span>{{$returned->purchase_number}}</div>
                <div class="col-md-3">供货商：<span>{{$returned->supplier}}</span></div>
                <div class="col-md-3">采购入库仓库：<span>{{$returned->storage}}</span></div>
            </div>
            <div class="row ui white ptb-4r">
                <h4>退货商品<span>共<span>{{$returned->count}}</span>件</span>
                    <div class="form-group pr-4r mr-2r">
                        <select class="selectpicker" name="storage_id" style="display: none;">
                            <option value="">选择仓库</option>
                            @foreach($storages as $storage)
                                <option value="{{ $storage->id }}" {{($returned->storage_id == $storage->id)?'selected':''}}>{{ $storage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </h4>
                <input type="hidden" id="returned_id" name="returned_id" value="{{$returned->id}}">
                <table class="table table-striped table-hover">
                    <thead class=" table-bordered">
                    <tr>
                        <th>商品图</th>
                        <th>SKU编码</th>
                        <th>商品名称</th>
                        <th>属性</th>
                        <th>实付</th>
                        <th>数量</th>
                        <th>退货数量</th>
                        <th>已出库数量</th>
                        <th>退货价格</th>
                    </tr>
                    </thead>
                    <tbody id="sku-list">
                    @foreach($returnedSkus as $returnedSku)
                        <tr>
                            <input type="hidden" name="returned_sku_id[]" value="{{$returnedSku->id}}">
                            <td><img src="" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                            <td class="fb">{{$returnedSku->number}}</td>
                            <td>{{$returnedSku->name}}</td>
                            <td>{{$returnedSku->mode}}</td>
                            <td>{{$returnedSku->total}}元</td>
                            <td>{{$returnedSku->count}}</td>
                            <td><div class="form-group" style="width:100px;"><input type="text"  class="form-control interger" placeholder="输入数量" name="count[]" value="{{$returnedSku->count}}"></div></td>
                            <td>{{$returnedSku->out_count}}</td>
                            <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger" placeholder="输入金额" name="price[]" value="{{$returnedSku
                            ->price}}"></div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div><h4><span>共计退款金额<span>{{$returned->price}}</span>元</span></h4></div>
                <div class="form-horizontal">
                    <div class="form-group mlr-0">
                        <div class="lh-34 m-56 ml-3r fl">备注</div>
                        <div class="col-sm-5 pl-0">
                            <textarea rows="3" class="form-control" name="summary" id="memo">{{$returned->summary}}</textarea>
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




@endsection
