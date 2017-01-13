@extends('home.base')

@section('title', '新增退款单')

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
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error_message'))
            <div class="alert alert-danger">
                <ul>
                    <li>{{session('error_message')}}</li>
                </ul>
            </div>
        @endif
        <form id="add-purchase" role="form" method="post" action="{{ url('/refund/storeRefundMoney') }}">
            <div class="row ui white ptb-4r">
                <div class="col-md-12">
                    <div class="form-inline">

                        <div class="form-group">
                            <input type="text" id="number" class="form-control" placeholder="订单编号">
                        </div>
                        <button id="purchase-search" type="button" class="btn btn-magenta" data-toggle="modal" data-target="#addpurchase">＋添加订单</button>
                    </div>
                </div>
            </div>
            <div id="sku-list">

            </div>
            {{--<div class="row ui white ptb-4r">
                <div class="panel prl10auto mt15">
                    <h5 class="fb">原订单信息</h5>
                    <div class="row mt15 ">
                        <div class="col-md-2">
                            <form role="form" class="form-inline">
                                <div class="form-group lh30">订单编号：</div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form role="form" class="form-inline">
                                <div class="form-group lh30">昵称：<span class="iconfont icon-wangwang blue f20" style="font-size:20px;"></span></div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form role="form" class="form-inline">
                                <div class="form-group lh30">收货人:</div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form role="form" class="form-inline">
                                <div class="form-group lh30">实付/运费（元）：741.00 / 30.00</div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class=" table-bordered">
                        <tr>
                            <th>商品图</th>
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>属性</th>
                            <th>数量</th>
                            <th>单价</th>
                            <th>优惠</th>
                            <th>实际付款</th>
                        </tr>
                        </thead>
                            <tr>
                                <td><img src="@{{path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <h5>退货商品</h5>
                <input type="hidden" id="supplier_id" name="supplier_id" value="">
                <input type="hidden" id="purchase_id" name="purchase_id" value="">
                <table class="table table-striped table-hover">
                    <thead class=" table-bordered">
                    <tr>
                        <th>商品图</th>
                        <th>SKU编码</th>
                        <th>商品名称</th>
                        <th>属性</th>
                        <th>数量</th>
                        <th>退货数量</th>
                        <th>退货单价</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><img src="@{{path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger count" not_count="@{{count}}" placeholder="数量" name="count[]" value=""></div></td>
                        <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger" placeholder="金额" name="price[]" value=""></div></td>
                    </tr>
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
            </div>--}}
            {!! csrf_field() !!}
        </form>
    </div>
@endsection

@section('customize_js')
    @parent


@endsection

@section('load_private')
    @parent
    {{--<script>--}}
    {{--根据名称或编号搜索--}}
    $("#purchase-search").click(function () {
        var val = $("#number").val();
        if(val == ''){
            alert('订单号输入为空');
        }else{
        $.get('{{url('/refund/ajaxOrder')}}',{'number':val},function (e) {
            if (e.status){
                var template = ['<div class="row ui white ptb-4r">',
                    ' @{{ #purchase }}<div class="panel prl10auto mt15">',
                        '                    <h5 class="fb">原订单信息</h5>',
                        '                    <div class="row mt15 ">',
                            '                        <div class="col-md-3">',
                                '                            <form role="form" class="form-inline">',
                                    '                                <div class="form-group lh30">订单编号：@{{ number }}</div>',
                                    '                            </form>',
                                '                        </div>',
                            '                        <div class="col-md-2">',
                                '                            <form role="form" class="form-inline">',
                                    '                                <div class="form-group lh30">昵称：@{{ buyer_name }}<span class="iconfont icon-wangwang blue f20" style="font-size:20px;"></span></div>',
                                    '                            </form>',
                                '                        </div>',
                            '                        <div class="col-md-2">',
                                '                            <form role="form" class="form-inline">',
                                    '                                <div class="form-group lh30">收货人:@{{ buyer_name }}</div>',
                                    '                            </form>',
                                '                        </div>',
                            '                        <div class="col-md-3">',
                                '                            <form role="form" class="form-inline">',
                                    '                                <div class="form-group lh30">实付/运费（元）：@{{ pay_money }} / @{{ freight }}</div>',
                                    '                            </form>',
                                '                        </div>',
                            '                    </div>',
                        '                    <table class="table table-striped table-hover">',
                            '                        <thead class=" table-bordered">',
                            '                        <tr>',
                                '                            <th>商品图</th>',
                                '                            <th>SKU编码</th>',
                                '                            <th>商品名称</th>',
                                '                            <th>属性</th>',
                                '                            <th>数量</th>',
                                '                            <th>单价</th>',
                                '                            <th>优惠</th>',
                                '                        </tr>',
                            '                        </thead>',
                            '                            @{{ #purchase_sku }}<tr>',
                                '                                <td><img src="@{{path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>',
                                '                                <td>@{{ number }}</td>',
                                '                                <td>@{{ name }}</td>',
                                '                                <td>@{{ mode }}</td>',
                                '                                <td>@{{ quantity }}</td>',
                                '                                <td>@{{ price }}</td>',
                                '                                <td>@{{ discount }}</td>',
                                '                            </tr>@{{ /purchase_sku }}',
                            '                        <tbody>',
                            '                        </tbody>',
                            '                    </table>',
                        '                </div>',
                    '                <h5>退货商品</h5>',
                    '                <input type="hidden" id="order_id" name="order_id" value="@{{ id }}">',
                    '                <table class="table table-striped table-hover">',
                        '                    <thead class=" table-bordered">',
                        '                    <tr>',
                            '                        <th>商品图</th>',
                            '                        <th>SKU编码</th>',
                            '                        <th>商品名称</th>',
                            '                        <th>属性</th>',
                            '                        <th>订单数量</th>',
                            '                        <th>退货数量</th>',
                            '                        <th>退货单价</th>',
                            '                    </tr>',
                        '                    </thead>',
                        '                    <tbody>',
                        '                    @{{ #purchase_sku }}<tr>',
                            '                        <td><img src="@{{path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>',
                            '                        <td>@{{ number }}</td>',
                            '                        <td>@{{ name }}</td>',
                            '                        <td>@{{ mode }}</td>',
                            '                        <td>@{{ quantity }}</td>',
                            '<input type="hidden" name="sku_id[]" value="@{{sku_id}}">',
                            '                        <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger count" not_count="@{{quantity}}" placeholder="数量" name="quantity[]" value="@{{ quantity }}"></div></td>',
                            '                        <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger" placeholder="金额" name="price[]" value="@{{ price }}"></div></td>',
                            '                    </tr>@{{ /purchase_sku }}',
                        '                    </tbody>',
                        '                </table>',
                    '                <div><h4><span>共计退款金额<span>0</span>元</span></h4></div>',
                    '                <div class="form-horizontal">',
                        '                    <div class="form-group mlr-0">',
                            '                        <div class="lh-34 m-56 ml-3r fl">备注</div>',
                            '                        <div class="col-sm-5 pl-0">',
                                '                            <textarea rows="3" class="form-control" name="summary" id="memo"></textarea>',
                                '                        </div>',
                            '                    </div>',
                        '                </div>',
                    '            </div>',
                '            <div class="row mt-4r pt-2r">',
                    '                <button type="submit" class="btn btn-magenta mr-r save">保存</button>',
                    '                <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">取消</button>',
                    '            </div>@{{ /purchase }}'].join("");
                var views = Mustache.render(template, e.data);
                $("#purchase_id").val(e.data.purchase.id);
                $("#sku-list").html(views);
                }else{
                    alert(e.message);
                }
                $(".count").focusout(function () {
                    var max_value = $(this).attr("not_count");
                    var value = $(this).val();
                    if(parseInt(value) > parseInt(max_value)){
                        alert("退货数量不能大于" + max_value);
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
                        'quantity[]': {
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
                        },

                    }
                });
            },'json');
        }
    });


@endsection