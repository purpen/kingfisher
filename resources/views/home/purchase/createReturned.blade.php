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
                        新增退货单
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <form id="add-purchase" role="form" method="post" action="{{ url('/returned/store') }}">
            <div class="row ui white ptb-4r">
                <div class="col-md-12">
                    <div class="form-inline">

                        <div class="form-group">
                            <input type="text" id="number" class="form-control" placeholder="采购单编号">
                        </div>
                        <button id="purchase-search" type="button" class="btn btn-magenta" data-toggle="modal" data-target="#addpurchase">＋添加采购单</button>

                        {{--<div class="modal fade" id="addpurchase" tabindex="-1" role="dialog" aria-labelledby="addpurchaseLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="gridSystemModalLabel">添加采购单号</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <input id="search_val" type="text" placeholder="请输入采购单号" class="form-control">
											<span class="input-group-btn">
                  								<button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                  							</span>
                                        </div>
                                        <div class="mt-4r scrollt">
                                            --}}{{--<div id="sku-list"></div>--}}{{--

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
                        </div>--}}
                    </div>
                </div>
            </div>
            <div class="row ui white ptb-4r">
                <h4>退货商品<span>共<span>0</span>件</span>
                    <div class="form-group pr-4r mr-2r">
                        <select class="selectpicker" name="storage_id" style="display: none;">
                            <option value="">选择仓库</option>
                            @foreach($storages as $storage)
                                <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </h4>
                <input type="hidden" id="supplier_id" name="supplier_id" value="">
                <input type="hidden" id="purchase_id" name="purchase_id" value="">
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
                    {{--<tr>
                        <td><img src="" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                        <td class="fb">12121</td>
                        <td>自行车</td>
                        <td>自行车</td>
                        <td>3000.00元</td>
                        <td>30</td>
                        <td><div class="form-group" style="width:100px;"><input type="text" max="30" showname="退货数量" class="form-control interger" placeholder="输入数量" name="quantity" value="" min="0"></div></td>
                        <td>0</td>
                        <td><div class="form-group" style="width:100px;"><input type="text" max="3000" showname="退款金额" class="form-control interger" placeholder="输入金额" name="price" value=""></div></td>
                    </tr>--}}
                    </tbody>
                </table>
                <div><h4><span>共计退款金额<span>0</span>元</span></h4></div>
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
    {{--根据名称或编号搜索--}}
    $("#purchase-search").click(function () {
        var val = $("#number").val();
        if(val == ''){
            alert('采购单号输入为空');
        }else{
            $.get('/returned/ajaxPurchase',{'number':val},function (e) {
            if (e.status){
                var template = ['@{{#purchase_sku_relation}}<tr>',
                    '                        <td><img src="@{{path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>',
                    '                        <td class="fb">@{{number}}</td>',
                    '                        <td>@{{name}}</td>',
                    '                        <td>@{{mode}}</td>',
                    '                        <td>@{{total}}元</td>',
                    '                        <td>@{{count}}</td>',
                    '        <input type="hidden" name="sku_id[]" value="@{{sku_id}}">',
                    '                        <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger" placeholder="输入数量" name="count[]" value="" min="0"></div></td>',
                    '                        <td>0</td>',
                    '                        <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger" placeholder="输入金额" name="price[]" value=""></div></td>',
                    '                    </tr>@{{/purchase_sku_relation}}'].join("");
                var views = Mustache.render(template, e.data);
                $("#supplier_id").val(e.data.purchase.supplier_id);
                $("#purchase_id").val(e.data.purchase.id);
                $("#sku-list").html(views);
                }
            },'json');
        }
    });



@endsection
