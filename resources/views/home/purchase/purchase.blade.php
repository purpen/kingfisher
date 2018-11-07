@extends('home.base')

@section('customize_css')
    @parent
    .loading{
    width:160px;
    height:56px;
    position: absolute;
    top:50%;
    left:50%;
    line-height:56px;
    color:#fff;
    padding-left:60px;
    font-size:15px;
    background: #000 url(images/loader.gif) no-repeat 10px 50%;
    opacity: 0.7;
    z-index:9999;
    -moz-border-radius:20px;
    -webkit-border-radius:20px;
    border-radius:20px;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
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
    {{--<script>--}}
    var LODOP; // 声明为全局变量
    var isConnect = 0;
    {{--删除订单--}}
    var _token = $("#_token").val();

    {{--获取选中input框的id属性值--}}
    var getOnInput = function () {
    var id = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    id.push($(this).attr('id'));
    }
    });
    return id;
    };

    {{--快递鸟打印--}}
    function doConnectKdn() {
    try{
    var LODOP=getLodop();
    if (LODOP.VERSION) {
    isConnect = 1;
    console.log('快递鸟打印控件已安装');
    };
    }catch(err){
    console.log('快递鸟打印控件连接失败' + err);
    }
    };

@endsection


@section('load_private')
    @parent
    {{--<script>--}}
    $(".delete").click(function () {
    if(confirm('确认删除该订单？')){
    var id = $(this).attr('value');
    var de = $(this);
    $.post('{{url('/purchase/ajaxDestroy')}}',{'_token':_token,'id':id},function (e) {
    if(e.status){
    de.parent().parent().remove();
    }
    },'json');
    }
    });


    {{--创建者审核--}}
    $("#verified").click(function () {
    layer.confirm('确认要通过审核吗？',function(index){

    var id = getOnInput();
    $.post('/purchase/ajaxVerified',{'_token':_token,'id':id},function (e) {
    if(e.status){
    layer.msg('操作成功！');
    location.reload();

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
    {{--content: '<h5 style="text-align: center">请填写驳回原因：</h5><textarea name="msg" id="msg" cols="50" rows="5" style="margin-left: 10px;"></textarea><button type="button" style="margin-left: 153px;text-align: center;border: none" class="btn btn-white btn-sm" id="sure">确定</button><a href="" onclick="layer.close()" style="margin-left: 15px;font-size: 12px;color: black">取消</a>'--}}
    {{--});--}}

    $('#pruchaseBohui').click(function(){
    var id_array = [];
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    id_array.push($(this).attr('id'));
    }
    });
    if(id_array == ''){
    layer.msg('请先勾选！');
    return false;
    }
    })

    $(document).on("click","#sure",function(obj){
    var id = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    id.push($(this).attr('id'));
    }
    });

    var msg=$("#purchaseStatusTextarea").val();
    var id = getOnInput();
    $.post('{{url('/purchase/ajaxDirectorReject')}}',{'_token': _token,'id': id,'msg':msg}, function (e) {
    if(e.status){
    layer.msg('操作成功！');
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    });

    {{--主管领导通过审核--}}
    $('#approved').click(function () {
    layer.confirm('确认要通过审核吗？',function(index){
    var id = getOnInput();
    $.post('{{url('/purchase/ajaxDirectorVerified')}}',{'_token': _token,'id': id}, function (e) {
    if(e.status){
    layer.msg('操作成功！');
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    });
    });

    $("#returned").click(function () {
    var id = getOnInput();
    $.post('{{url('/purchase/ajaxReturned')}}',{'_token': _token,'id': id}, function (e) {
    if(e.status){
    location.href = e.data;
    }else{
    alert(e.message);
    }
    },'json');
    });

    {{--订单出货单预览--}}
    $(".print-enter").click(function () {
    var id = $(this).attr('value');
    $("#true-print").val(id);

    $.get('{{ url('/purchase/ajaxPurchaseInfo') }}', {'id':id}, function (e) {
    if(e.status == 1){
    var template = $('#print-purchase-tmp').html();
    var views = Mustache.render(template, e.data);
    $("#thn-out-order").html(views);
    }else if(e.status == 0){
    alert(e.message);
    }else if(e.status == -1){
    alert(e.msg);
    }
    },'json');


    $("#print-purchase-order").modal('show');
    });

    {{--预览打印--}}
    $("#true-print").click(function () {
    {{--加载本地lodop打印控件--}}
    doConnectKdn();

    if(isConnect == 0){
    $('#down-print').show();
    return false;
    }

    var id = $(this).attr('value');

    $.get('{{ url('/purchase/ajaxPurchaseInfo') }}', {'id':id}, function (e) {
    if(e.status == 1){
    var n = 7;
    var data = e.data;
    var len = data.purchase_sku_relation.length;
    var purchase_sku_relation = data.purchase_sku_relation;
    var count = Math.ceil(len / 7);
    for (var i = 0; i < count; i++){
    var newData = data;
    if(i+1 == count){
    newData.purchase_sku_relation = purchase_sku_relation.slice(i*n);
    newData.info = {"total":count, 'page':count}
    }else{
    newData.purchase_sku_relation = purchase_sku_relation.slice(i*n, n*(i+1));
    newData.info = {"total":count, 'page':i+1}
    }
    doLodop('采购单', newData);
    }

    }else if(e.status == 0){
    alert(e.message);
    }else if(e.status == -1){
    alert(e.msg);
    }
    },'json');

    $("#print-purchase-order").modal('hide');
    });

    {{--lodop打印--}}
    function lodopPrint(name, template) {
    LODOP.PRINT_INIT(name);
    LODOP.ADD_PRINT_HTM(0,0,"100%","100%",template);
    LODOP.PRINT();
    };

    /**
    * 执行打印操作
    *
    * @param name 打印名称
    * @param data  打印数据
    */
    function doLodop(name,data) {
    {{--console.log(data);--}}
    var template = $('#print-purchase-tmp').html();
    var views = Mustache.render(template, data);
    {{--console.log(views);--}}
    lodopPrint(name, views);
    };

    {{--按时时间、类型导出--}}
    $("#purchases-excel-1").click(function () {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    if(start_date == '' || end_date == ''){
    alert('请选择时间');
    }else{
    post('{{url('/dateGetPurchasesExcel')}}',{'start_date':start_date,'end_date':end_date});
    }

    });

    {{--post请求--}}
    function post(URL, PARAMS) {
    var temp = document.createElement("form");
    temp.action = URL;
    temp.method = "post";
    temp.style.display = "none";
    var opt = document.createElement("textarea");
    opt.name = '_token';
    opt.value = _token;
    temp.appendChild(opt);
    for (var x in PARAMS) {
    var opt = document.createElement("textarea");
    opt.name = x;
    opt.value = PARAMS[x];
    {{--// alert(opt.name)--}}
    temp.appendChild(opt);
    }
    document.body.appendChild(temp);
    temp.submit();
    return temp;
    };

    $("#in_purchase").click(function () {
    $("#purchaseInputSuccess").text(0);
    $("#purchaseInputError").text(0);
    $("#purchaseInputMessage").val('');
    $('#purchaseReturn').hide();
    $("#addPurchase").modal('show');
    });

    {{--导出--}}
    $("#out_purchase").click(function(){
    {{--alert(111);return false;--}}
    var id_array=[];
    $("input[name='purchase']").each(function(){
    if($(this).is(':checked')){
    id_array.push($this).attr('value');
    }
    });
    post('{{url('/purchaseList')}}',id_array);
    });


    $("#purchaseExcelSubmit").click(function () {
    var formData = new FormData($("#purchaseInput")[0]);

    var purchaseInputSuccess = $("#purchaseInputSuccess");
    var purchaseInputError = $("#purchaseInputError");
    var purchaseInputMessage = $("#purchaseInputMessage");
    $.ajax({
    url : "{{ url('/purchaseExcel') }}",
    type : 'POST',
    dataType : 'json',
    data : formData,
    {{--// 告诉jQuery不要去处理发送的数据--}}
    processData : false,
    {{--// 告诉jQuery不要去设置Content-Type请求头--}}
    contentType : false,
    beforeSend:function(){
    var loading=document.getElementById("loading");
    loading.style.display = 'block';
    console.log("正在进行，请稍候");
    },
    success : function(e) {
    loading.style.display = 'none';
    var data = e.data;
    if(e.status == 1){
    purchaseInputSuccess.text(data.success_count);
    purchaseInputError.text(data.error_count);
    purchaseInputMessage.val(data.error_message);
    $('#purchaseReturn').show();
    }else if(e.status == -1){
    alert(e.msg);
    }else{
    console.log(e.message);
    alert(e.message);
    }
    },
    error : function(e) {
    alert('导入文件错误');
    }
    });
    });


@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    采购单列表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.purchase.subnav')
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row fz-0">
            <div class="col-md-12">
                <a href="{{ url('/purchase/create') }}" class="btn btn-white mr-2r">
                    <i class="glyphicon glyphicon-edit"></i> 新增采购单
                </a>
                {{--@if (!$verified)--}}
                {{--<button type="button" class="btn btn-success mr-2r" id="verified">--}}
                {{--<i class="glyphicon glyphicon-check"></i> 审核--}}
                {{--</button>--}}
                {{--@endif--}}

                @if ($verified == 1)
                    {{--<button type="button" class="btn btn-success mr-2r" id="approved">--}}
                    {{--<i class="glyphicon glyphicon-ok"></i> 通过审批--}}
                    {{--</button>--}}
                    {{--<button type="button" class="btn btn-warning mr-2r" id="rejected">--}}
                    {{--<i class="glyphicon glyphicon-remove"></i> 驳回审批--}}
                    {{--</button>--}}


                    <button type="button" class="btn btn-success mr-2r" id="approved">
                        <i class="glyphicon glyphicon-ok"></i> 通过审批
                    </button>
                    <button class="btn btn-magenta btn-sm mr-3r" data-toggle="modal" id="pruchaseBohui" data-target="#myModal" >
                        <i class="glyphicon glyphicon-remove"></i> 驳回
                    </button>

                @endif
                @if ($verified == 9)
                    <button type="button" class="btn btn-danger mr-2r" id="returned">
                        <i class="glyphicon glyphicon-share"></i> 采购退货
                    </button>
                @endif
                <button type="button" class="btn btn-default mr-2r" id="in_purchase">
                    导入
                </button>
                {{--暂时不使用导出--}}
                {{--<button type="button" class="btn btn-default mr-2r" id="out_purchase">--}}
                {{--导出--}}
                {{--</button>--}}

            </div>
        </div>
        <form method="post"  class="form-horizontal" role="form" id="myForm" onsubmit="return ">
            <div class="modal fade" id="myModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="btn-info modal-header modal-header-back ">
                            <button type="button" class="close close-back" data-dismiss="modal">&times;</button>
                            <h4>驳回原因</h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group form-group-back"  >
                                <textarea id='purchaseStatusTextarea' rows='8' cols='60' name='msg'></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="sure" class="btn btn-info btn_style">确定</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
        <div id="loading" class="loading" style="display: none;">Loading...</div>

        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        @if($verified != 9)
                            <th>审核状态</th>
                        @endif
                        @if($verified == 9)
                            <th>入库状态</th>
                        @endif
                        <th>单据编号</th>
                        <th>类型</th>
                        <th>供应商</th>
                        <th>仓库</th>
                        <th>部门</th>
                        <th>采购数量</th>

                        @if($verified == 9)
                            <th>已入库数量</th>
                        @endif
                        <th>采购总额</th>
                        <th>创建时间</th>
                        <th>制单人</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox" id="{{$purchase->id}}"></td>
                            @if($verified != 9)
                                <th>
                                    @if($purchase->verified == 0)
                                        <span class="label label-default">未审核</span>
                                    @endif
                                    @if($purchase->verified == 1)
                                        <span class="label label-danger">待审核</span>
                                    @endif
                                    @if($purchase->verified == 9)
                                        <span class="label label-success">通过审核</span>
                                    @endif
                                </th>
                            @endif
                            @if($verified == 9)
                                <th>
                                    @if($purchase->storage_status == 0)
                                        <span class="label label-default">未入库</span>
                                    @endif
                                    @if($purchase->storage_status == 1)
                                        <span class="label label-warning">入库中</span>
                                    @endif
                                    @if($purchase->storage_status == 5)
                                        <span class="label label-success">已入库</span>
                                    @endif
                                </th>
                            @endif
                            <td class="magenta-color">{{$purchase->number}}</td>
                            <td>{{$purchase->supplier_type_val}}[{{ $purchase->type_val }}]</td>
                            <td>{{$purchase->supplier_name}}</td>
                            <td>{{$purchase->storage}}</td>
                            <td>{{$purchase->department_val}}</td>
                            <td>{{$purchase->count}}</td>
                            @if($verified == 9)
                                <td>{{$purchase->in_count}}</td>
                            @endif

                            <td>{{$purchase->price}}元</td>
                            <td>{{$purchase->created_at_val}}</td>
                            <td>{{$purchase->user}}</td>
                            <td>{{$purchase->summary}}</td>
                            <td tdr="nochect">
                                <a href="{{url('/purchase/show')}}?id={{$purchase->id}}" class="magenta-color mr-r">查看详情</a>
                                @if($verified != 9)
                                    <a href="{{url('/purchase/edit')}}?id={{$purchase->id}}" class="magenta-color mr-r">编辑</a>
                                    <a href="javascript:void(0)" value="{{$purchase->id}}" class="magenta-color delete">删除</a>
                                @endif
                                @if($verified == 9)
                                    @role(['admin'])
                                    <a href="javascript:void(0)" value="{{$purchase->id}}" class="magenta-color delete">删除</a>
                                    @endrole
                                @endif
                                @if($verified == 9)
                                    <button type="button" id="edit-enter" value="{{$purchase->id}}" class="btn btn-white btn-sm mr-r print-enter">打印预览</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($purchases)
            <div class="row">
                <div class="col-md-12 text-center">{!! $purchases->appends(['where' => $where , 'verified' => $verified])->render() !!}</div>
            </div>
        @endif
    </div>

    <div class="modal fade bs-example-modal-lg" id="print-purchase-order" tabindex="-1" role="dialog"
         aria-labelledby="appendskuLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        打印出库单
                    </h4>
                </div>
                <div class="modal-body">
                    <div id="thn-out-order">
                        {{--填充的打印模板--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-magenta" id="true-print" value="">确定打印</button>
                </div>
            </div>
        </div>
    </div>


    <object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
        <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
    </object>

    @include('home/purchase.printPurchase')

    {{--导入弹出框--}}
    @include('home/purchase.inPurchase')
    <script src="{{ url('build/assets/js/LodopFuncs.js') }}"></script>
@endsection

