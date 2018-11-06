@extends('home.base')

@section('partial_css')
    @parent
    <link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
    @parent
    .m-92{
    min-width:92px;
    text-align:right;
    vertical-align: top !important;
    line-height: 34px;
    }
    .img-add{
    width: 100px;
    height: 100px;
    background: #f5f5f5;
    vertical-align: middle;
    text-align: center;
    padding: 24px 0;
    }
    .img-add .glyphicon{
    font-size:30px;
    }
    #picForm{
    position:relative;
    color: #f36;
    height: 100px;
    text-decoration: none;
    width: 100px;
    }
    #picForm:hover{
    color:#e50039;
    }
    #picForm .form-control{
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    width: 100px;
    height: 100px;
    z-index: 3;
    cursor: pointer;
    }
    .removeimg{
    position: absolute;
    left: 75px;
    bottom: 10px;
    font-size: 13px;
    }
    #appendsku{
    margin-left:40px;
    font-size:14px;
    }
    .qq-uploader {
    position: relative;
    width: 100%;
    width: 100px;
    height: 100px;
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    }
    .qq-upload-button{
    width:100px;
    height:100px;
    position:absolute !important;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        @include('block.errors')
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    供货商管理
                </div>
            </div>

            <div class="navbar-collapse collapse">
                @include('home.supplier.subnav')
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-sm-12">

                    {{--<button type="button" id="batch-verify" class="btn btn-success mr-2r">--}}
                    {{--<i class="glyphicon glyphicon-ok"></i> 通过审核--}}
                    {{--</button>--}}
                    {{--<button type="button" id="batch-close" class="btn btn-danger mr-2r">--}}
                    {{--<i class="glyphicon glyphicon-remove"></i> 驳回--}}
                    {{--</button>--}}
                    <div class="container">
                        <a type="button" class="btn btn-white mr-2r" href="{{url('/supplier/create')}}">
                            <i class="glyphicon glyphicon-edit"></i> 添加供应商
                        </a>
                        <button type="button"  data-toggle="modal" data-target="#myModal" class="btn btn-success mr-2r">
                            <i class="glyphicon glyphicon-ok"></i> 通过审核
                        </button>
                        <button type="button"  data-toggle="modal" data-target="#myorderOut" id="pruchaseBohui" class="btn btn-danger mr-2r">
                            <i class="glyphicon glyphicon-remove"></i> 驳回
                        </button>
                        <button type="submit" id="batch-excel" class="btn btn-white mr-2r">
                            导出
                        </button>
                        <form method="post"  class="form-horizontal" role="form" id="myForm" onsubmit="return ">
                            <div class="modal fade" id="myModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="btn-info modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4>请填写通过原因</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group" style="margin-left:40px;">
                                                <textarea id="suresTextarea"  rows='8' cols='60' name='msg'></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  id='sures' class="btn btn-info">确定</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form method="post"  class="form-horizontal" role="form" id="myForm" onsubmit="return ">
                            <div class="modal fade" id="myorderOut"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="btn-info modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4>请填写驳回原因</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group" style="margin-left:40px;">
                                                <textarea id='supplierTextarea' rows='8' cols='60' name='msg'></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="sure" class="btn btn-info">确定</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
            @if (session('error_message'))
                <div class="alert alert-success error_message">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p class="text-danger">{{ session('error_message') }}</p>
                </div>
            @endif
            <div class="row scroll">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>ID</th>
                            <th>简称/公司全称</th>
                            <th>是否签订协议</th>
                            <th>供应商类型</th>
                            {{--<th>折扣</th>--}}
                            {{--<th>开票税率</th>--}}
                            {{--<th>联系人/手机号</th>--}}
                            <th>合作时间</th>
                            <th>授权期限</th>
                            {{--<th>关联人</th>--}}
                            <th>供应商关联人</th>
                            <th>审核状态</th>
                            <th>操作</th>
                        </tr>

                        </thead>
                        <tbody>
                        @if ($suppliers)
                            @foreach($suppliers as $supplier)
                                <tr>
                                    <td class="text-center"><input name="Order" type="checkbox" active="0" value="{{ $supplier->id }}"></td>
                                    <td>{{ $supplier->id }}</td>
                                    <td>简称:{{ $supplier->nam }}<br>全称:{{ $supplier->name }}</td>
                                    <td>{{ $supplier->agreements }}</td>
                                    <td>
                                        @if($supplier->type == 1)
                                            <span class="label label-danger">采销</span>
                                        @elseif($supplier->type == 2)
                                            <span class="label label-warning">代销</span>
                                        @elseif($supplier->type == 3)
                                            <span class="label label-success">代发</span>
                                        @endif
                                    </td>
                                    {{--<td>@if($supplier->discount) {{ (float)$supplier->discount }}% @endif</td>--}}

                                    {{--<td>@if($supplier->tax_rate) {{ (float)$supplier->tax_rate }}% @endif</td>--}}
                                    {{--<td>联系人:{{ $supplier->contact_user }}<br>手机号:{{ $supplier->contact_number }}</td>--}}

                                    {{--如果是关闭这的，全部正常显示--}}
                                    @if($supplier->status == 3)
                                        <td>
                                            @if($supplier->start_time == '0000-00-00')

                                            @else
                                                开始:{{ $supplier->start_time}}
                                            @endif
                                            <br>

                                            @if($supplier->end_time == '0000-00-00')
                                            @else
                                                结束:{{ $supplier->end_time}}
                                            @endif
                                        </td>
                                    @else
                                        {{--如果合同日期小于30天，红色显示--}}
                                        @if((strtotime($supplier->end_time) - strtotime(date("Y-m-d")))/86400 < 30)
                                            <td class="magenta-color">
                                                @if($supplier->start_time == '0000-00-00')

                                                @else
                                                    开始:{{ $supplier->start_time}}
                                                @endif
                                                <br>
                                                @if($supplier->end_time == '0000-00-00')
                                                @else
                                                    结束:{{ $supplier->end_time}}

                                                @endif
                                            </td>
                                        @else
                                            {{--合同大于30天，正常显示--}}
                                            <td>
                                                @if($supplier->start_time == '0000-00-00')

                                                @else
                                                    开始:{{ $supplier->start_time}}
                                                @endif
                                                <br>
                                                @if($supplier->end_time == '0000-00-00')
                                                @else
                                                    结束:{{ $supplier->end_time}}

                                                @endif
                                            </td>
                                        @endif
                                    @endif

                                    <td>
                                        @if($supplier->authorization_deadline == '0000-00-00')

                                        @else
                                            {{ $supplier->authorization_deadline}}
                                        @endif
                                    </td>
                                    {{--                                    <td>{{ $supplier->relation_user_name }} </td>--}}
                                    <td>{{ $supplier->supplier_user_name }} </td>
                                    @if($supplier->status == 1)
                                        <td>待审核</td>
                                    @elseif($supplier->status == 2)
                                        <td>已审核</td>
                                    @elseif($supplier->status == 3)
                                        <td>未通过</td>

                                    @elseif($supplier->status == 4)
                                        <td>重新审核</td>

                                    @endif

                                    <td>
                                        <a type="button" class="btn btn-white btn-sm" href="{{url('/supplier/edit')}}?id={{ $supplier->id }}" value="{{ $supplier->id }}">编辑</a>
                                        <a class="btn btn-default btn-sm" href="{{ url('/supplier/details') }}?id={{$supplier->id}}" target="_blank">详情</a>
                                        {{--<button class="btn btn-default btn-sm" data-toggle="modal" onclick="addMould({{$supplier->id}})"  value="{{ $supplier->id }}">模版</button>
                                        @if($supplier->supplier_user_id == 0)
                                            <button class="btn btn-success btn-sm" data-toggle="modal" onclick="addSupplierUser({{$supplier->id}})"  value="{{ $supplier->id }}">生成用户</button>
                                        @else
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" onclick="deleteSupplierUser({{$supplier->id}})"  value="{{ $supplier->id }}">取消用户</button>
                                        @endif--}}

                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                @if ($suppliers)
                    <div class="col-md-12 text-center">{!! $suppliers->appends(['nam' => $nam , 'status' => $status])->render() !!}</div>
                @endif
            </div>
        </div>

    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

    {{--协议--}}
    @include("home/supplier.xieYiModal")

    {{--模版--}}
    @include("home/supplier.addMould")
@endsection
@section('partial_js')
    @parent
    <script src="{{ elixir('assets/js/fine-uploader.js') }}" type="text/javascript"></script>
@endsection

@section('customize_js')
    {{--添加表单验证--}}
    $("#addSupplier,#updateSupplier").formValidation({
    framework: 'bootstrap',
    icon: {
    valid: 'glyphicon glyphicon-ok',
    invalid: 'glyphicon glyphicon-remove',
    validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
    name: {
    validators: {
    notEmpty: {
    message: '公司名称不能为空！'
    },
    stringLength: {
    min:1,
    max:50,
    message: '公司名称1-50字之间！'
    }
    }
    },

    address: {
    validators: {
    stringLength: {
    min:1,
    max:100,
    message: '公司地址1-100字之间！'
    }
    }
    },
    legal_person: {
    validators: {
    stringLength: {
    min:1,
    max:15,
    message: '公司法人长度1-15字之间！'
    }
    }
    },
    tel: {
    validators: {
    regexp: {
    regexp:/^[0-9-]+$/,
    message: '联系方式包括为数字或-'
    }
    }
    },
    contact_user: {
    validators: {
    stringLength: {
    min:1,
    max:15,
    message: '联系人长度1-15字之间！'
    }
    }
    },
    contact_number: {
    validators: {
    regexp: {
    regexp: /^1[34578][0-9]{9}$/,
    message: '联系人手机号码格式不正确'
    },
    stringLength: {
    min:1,
    max:20,
    message: '长度1-20字之间！'
    }
    }
    },
    contact_email: {
    validators: {
    emailAddress: {
    message: '邮箱格式不正确'
    },
    stringLength: {
    min:1,
    max:50,
    message: '长度1-50字之间！'
    }
    }
    },
    contact_qq: {
    validators: {
    stringLength: {
    min:1,
    max:20,
    message: '长度1-50字之间！'
    }
    }
    }
    }
    });

    var _token = $("#_token").val();
    function destroySupplier (id) {
    if(confirm('确认关闭该供货商吗？')){
    $.post('/supplier/ajaxClose',{"_token":_token,"id":id},function (e) {
    if(e.status == 1){
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    }

    }

    {{--协议地址--}}
    function AddressXieYi (address) {
    var address = address;
    document.getElementById("xyAddress").src = address;
    }
    {{--绑定模版--}}
    function addMould(id){
    $.get('/supplier/addMould',{'id':id},function (e) {
    if (e.status == 1){
    $("#2supplier_id").val(id);
    $('select').val(e.data.mould_id);
    $('.selectpicker').selectpicker('refresh');
    $('#addMouldModel').modal('show');
    }
    },'json');
    }
    {{--生成用户--}}
    function addSupplierUser(id){
    $.post('/supplier/addUser',{"_token":_token,'id':id},function (e) {
    if (e.status == 1){
    alert(e.message);
    location.reload();
    }else{
    alert(e.message);
    location.reload();
    }
    },'json');
    }

    {{--取消关联用户--}}
    function deleteSupplierUser(id){
    $.post('/supplier/deleteUser',{"_token":_token,'id':id},function (e) {
    if (e.status == 1){
    alert(e.message);
    location.reload();

    }else{
    alert(e.message);
    location.reload();
    }
    },'json');
    }
@endsection

@section('load_private')
    @parent

    {{--供应商审核--}}
    {{--$('#batch-verify').click(function () {--}}
    {{--layer.confirm('确认要通过审核吗？',function(index){--}}

    {{--layer.open({--}}
    {{--type: 1,--}}
    {{--skin: 'layui-layer-rim',--}}
    {{--area: ['420px', '240px'],--}}
    {{--content: '<h5 style="text-align: center">请填写通过原因：</h5><textarea name="msg" id="msg" cols="50" rows="5" style="margin-left: 10px;"></textarea><button type="button" style="margin-left: 170px;text-align: center" class="btn btn-white btn-sm" id="sures">确定</button>'--}}
    {{--});--}}
    {{--});--}}

    {{--});--}}

    $('#pruchaseBohui').click(function(){
    var id_array = [];
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    id_array.push($(this).attr('value'));
    }
    });
    if(id_array == ''){
    layer.msg('请先勾选！');
    return false;
    }
    })

    $(document).on("click","#sures",function(obj){

    var supplier = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    supplier.push($(this).attr('value'));
    }
    });

    var msg=$("#suresTextarea").val();

    $.post('{{url('/supplier/ajaxVerify')}}',{'_token': _token,'supplier': supplier,'msg': msg}, function (data) {

    {{--console.log(data);return false;--}}

    if(data.status == 0){
    layer.msg('操作成功！');
    location.reload();
    }else if(data.status == 1){
    alert(data.message);
    }else{
    location.reload();
    }
    },'json');
    });


    {{--供应商关闭--}}
    {{--$('#batch-close').click(function () {--}}
    {{--layer.confirm('确认要驳回审核吗？',function(index){--}}

    {{--layer.open({--}}
    {{--type: 1,--}}
    {{--skin: 'layui-layer-rim',--}}
    {{--area: ['420px', '240px'],--}}
    {{--content: '<h5 style="text-align: center">请填写驳回原因：</h5><textarea name="msg" id="msg" cols="50" rows="5" style="margin-left: 10px;"></textarea><button type="button" style="margin-left: 170px;text-align: center" class="btn btn-white btn-sm" id="sure">确定</button>'--}}
    {{--});--}}
    {{--});--}}

    $(document).on("click","#sure",function(obj){
    var supplier = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    supplier.push($(this).attr('value'));
    }
    });
    var msg=$("#supplierTextarea").val();

    $.post('{{url('/supplier/ajaxClose')}}',{'_token': _token,'supplier': supplier,'msg':msg}, function (e) {

    {{--console.log(e);return false;--}}

    if(e.status == 0){
    layer.msg('操作成功！');
    location.reload();
    }else if(e.status == 1){
    alert(e.message);
    }else{
    location.reload();
    }
    },'json');

    });
    {{--});--}}

    {{--供应商导出--}}
    $('#batch-excel').click(function () {
    var supplier = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    supplier.push($(this).attr('value'));
    }
    });
    post('{{url('/supplierExcel')}}',{'supplier':supplier});

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
    // alert(opt.name)
    temp.appendChild(opt);
    }
    document.body.appendChild(temp);
    temp.submit();
    return temp;
    };

@endsection
