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
    .modal-header-back{
    background: rgba(255,51,102,.8);
    padding-top: 5px;
    padding-bottom: 5px;
    }
    .modal-header-back:hover, .modal-header-back:focus, .modal-header-back:active{
    background: rgba(255,51,102,.8) !important;
    border-color: rgba(255,51,102,.8) !important;
    }
    .modal-header-back h4{
    margin: 0;
    height: 36px;
    line-height:36px;
    }
    .close-back{
    color: #fff;
    text-decoration: none;
    cursor: pointer;
    opacity: .5;
    font-size: 33px;
    margin-top: 1px;
    }
    .close-back:focus, .close-back:hover{
    color: #fff;
    text-decoration: none;
    cursor: pointer;
    opacity: .5;
    }
    .modal-header .close{
    margin-top: 0;
    }
    .modal.in .modal-dialog{
    width: 500px;
    margin: 0;
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    transition: transform 0s ease-out;
    }
    .modal-content{
    border-radius: 8px;
    overflow: hidden;
    }
    .fade{
    transition: opacity 0s linear;
    }
    .modal.in .modal-dialog{
    transition: transform 0s ease-out;
    }
    .form-group-back{
    margin: 0 auto;
    width: 450px;
    margin-left: 10px !important;
    }
    .form-group-back textarea{
    width: 446px;
    border: 1px solid #666;
    }
    .btn-info{
    color: #fff;
    background-color: rgba(255,51,102,.8);
    border-color: rgba(255,51,102,.8);
    }
    .btn-info:hover, .btn-info: active, .btn-info:focus{
    color: #fff !important;
    background-color: #ff0040 !important;
    border-color: #db0037 !important;
    }
@endsection

@section('customize_js')
    @parent
    {{--主管领导通过审核--}}
    $('#approved').click(function () {
    var id = $("input[name='ids']").val();
    var _token = $("input[name='_token']").val();
    layer.confirm('确认要通过审核吗？',function(index){

    $.post('{{url('/purchase/ajaxDirectorVerified')}}',{'_token': _token,'id': id}, function (data) {
    layer.msg(data.message);
    if(data.status == 1){
    layer.msg('操作成功！');
    location.href = '{{url('/purchase')}}';
    }else{
    location.reload();
    }
    },'json');
    });

    });

    $('#charges').click(function () {
    layer.confirm('确认要通过审核吗？',function(index){
    var arr_id = $("input[name='ids']").val();
    var _token = $("input[name='_token']").val();
    {{--var arr_id = [];--}}
    {{--$("input[name='Order']").each(function () {--}}
    {{--if ($(this).is(':checked')) {--}}
    {{--arr_id.push($(this).val());--}}
    {{--}--}}
    {{--});--}}
    $.post('/payment/ajaxCharge',{'_token':_token,'id':arr_id},function (e) {
    if(e.status){
    layer.msg('操作成功！');
    location.href = '{{url('/purchase')}}';
    {{--location.reload();--}}
    }else if(e.status == 0){
    alert(e.message);
    }
    },'json');
    });
    });

    {{--主管领导驳回审核--}}
    {{--$('#rejected').click(function () {--}}

    {{--layer.open({--}}
    {{--type: 1,--}}
    {{--skin: 'layui-layer-rim',--}}
    {{--area: ['420px', '240px'],--}}
    {{--content: '<h5 style="text-align: center">请填写驳回原因：</h5><textarea name="msg" id="msg" cols="50" rows="5" style="margin-left: 10px;"></textarea><button type="button" style="margin-left: 153px;text-align: center;border: none" class="btn btn-white btn-sm" id="sure">确定</button><a href="javascript:location.reload();" onclick="layer.close()" style="margin-left: 15px;font-size: 12px;color: black">取消</a>'--}}
    {{--});--}}

    $(document).on("click","#sure",function(obj){
    var msg=$("#invoiceTextarea").val();
    var _token = $("input[name='_token']").val();
    var id =  $("input[name='ids']").val();
    $.post('{{url('/purchase/ajaxDirectorReject')}}',{'_token': _token,'id': id,'msg':msg}, function (e) {
    if(e.status){
    layer.msg('操作成功！');
    location.href = '{{url('/purchase')}}';
    }else{
    alert(e.message);
    }
    },'json');
    });
    {{--});--}}
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
                <p><strong>单据编号：</strong> <span>{{$purchase->number}}</span></p>
                <p><strong>采购类型：</strong> <span>{{$purchase->type_val}}</span></p>
                <p><strong>来源供应商：</strong> <span>{{$purchase->supplier}}</span></p>
                <p><strong>预计到货时间：</strong> <span>@if($purchase->predict_time != '0000-00-00') {{$purchase->predict_time}} @endif</span></p>
                <p><strong>入库仓库：</strong> <span>{{$purchase->storage}}</span></p>
                <p><strong>备注说明：</strong> {{$purchase->summary}}</p>
                <p><strong>发票信息：</strong> {{$purchase->invoice_info}}</p>
                <p><strong>供应商税号：</strong> {{$purchase->ein}}</p>
                <p><strong>供应商开票税率：</strong> {{$purchase->tax_rate}}</p>
                <p><strong>供应商开户行号：</strong> {{$purchase->bank_number}}</p>
                <p><strong>供应商开户行地址：</strong> {{$purchase->bank_address}}</p>

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

                <h5>审核状态</h5>
                <hr>
                <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                    <li for="status" class="mb-0r control-label col-md-6"><b>状态:</b>
                        @if($purchase->verified == 1)
                            <td>待主管审核</td>
                        @elseif($purchase->verified == 2)
                            <td>待财务审核</td>
                        @elseif($purchase->verified == 9)
                            <td>已通过</td>
                        @endif
                    </li>
                    @if($purchase->verified !=9)
                    <li for="msg" class="mb-0r control-label col-md-6"><b>原因:</b>{{ $purchase->msg}}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div style="text-align: center">
{{--        @if(in_array($purchase->verified,[1,2]))--}}
        @if ($purchase->verified == 1)
            <input type="hidden" name="ids" id="ids" value="{{$purchase->id}}">
        <button type="button" class="btn btn-success mr-2r" id="approved">
            <i class="glyphicon glyphicon-ok"></i> 通过审批
        </button>
        <button type="button" class="btn btn-magenta mr-2r" id="rejected" data-toggle="modal" data-target="#myModal">
            <i class="glyphicon glyphicon-remove"></i> 驳回审批
        </button>

            @elseif($purchase->verified == 2)
                <input type="hidden" name="ids" id="ids" value="{{$purchase->id}}">
                <button type="button" class="btn btn-success mr-2r" id="charges">
                    <i class="glyphicon glyphicon-ok"></i> 通过审批
                </button>

            @endif

            <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">
                <i class="glyphicon glyphicon-arrow-left"></i> 返回列表
            </button>
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
    <form method="post"  class="form-ho rizontal" role="form" id="myForm" onsubmit="return ">
        <div class="modal fade" id="myModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="btn-info modal-header modal-header-back ">
                        <button type="button" class="close close-back" data-dismiss="modal">&times;</button>
                        <h4>请填写驳回原因：</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group form-group-back" >
                            <textarea id='invoiceTextarea' rows='8' cols='60' name='msg'></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  id="sure" class="btn btn-info btn_style">确定</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@section('customize_js')
    @parent

@endsection
