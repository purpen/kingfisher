@extends('home.base')

@section('title', '审核权限管理')

@section('customize_css')
    @parent
    .check-btn{
    width: 46px;
    height: 30px;
    position: relative;
    }
    .check-btn input{
    z-index: 2;
    width: 100%;
    height: 100%;
    top: 6px !important;
    opacity: 0;
    color: transparent;
    background: transparent;
    cursor: pointer;
    }
    .check-btn button{
    position: absolute;
    top: -4px;
    left: 0;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    审核权限管理
                </div>
            </div>
        </div>

        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-white" data-toggle="modal" data-target="#addroles">
                        <i class="glyphicon glyphicon-edit"></i> 新增权限模块
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th>ID</th>
                            <th>指定审核人员ID</th>
                            <th>类型</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($auditing_list as $val)
                            <tr>
                                <td>{{ $val->id }}</td>
                                <td class="magenta-color">{{ $val->user_id }}</td>
                                <td>
                                    @if($val->type == 1)
                                        订单审核
                                        @elseif($val->type == 2)
                                        订单财务审核
                                        @elseif($val->type == 3)
                                        采购审核
                                        @elseif($val->type == 4)
                                        采购财务审核
                                        @elseif($val->type == 5)
                                        出库审核
                                    @endif
                                    </td>
                                <td>
                                    @if($val->status ==1)
                                        启用
                                @else
                                        禁用
                                    @endif
                                </td>
                                <td>
{{--                                    <a class="btn btn-default btn-sm" href="{{ url('/auditing/edit') }}?id={{$val->id}}">编辑</a>--}}
                                    {{--<button data-toggle="modal" data-target="#updateAuditing" class="btn btn-default btn-sm" onclick="editauditing({{ $val->id }})" value="{{ $val->id }}">修改</button>--}}
                                    <button class="btn btn-default btn-sm" onclick=" destroyAuditing({{ $val->id }})" value="{{ $val->id }}">删除</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                {{--@if($data->render() !== "")--}}
                    {{--<div class="col-md-12 text-center">--}}
                        {{--{!! $data->render() !!}--}}
                    {{--</div>--}}
                {{--@endif--}}
            </div>
        </div>
    </div>
    @include('modal.add_auditing')
@endsection
@section('customize_js')
    @parent
    $('#addclassify').formValidation({
    framework: 'bootstrap',
    icon: {
    valid: 'glyphicon glyphicon-ok',
    invalid: 'glyphicon glyphicon-remove',
    validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
    user_id: {
    validators: {
    notEmpty: {
    message: '指定审核人不能为空！'
    }
    }
    },
    type: {
    validators: {
    notEmpty: {
    message: '审核模块名称不能为空！'
    }
    }
    }
    }
    });

    $("input[name='user_id']").change(function(){
    $('#Jszzdm').val($("input[name='user_id']:checked").map(function(){
    return this.value
    }).get().join(','))
    })

    function editauditing (id) {
    $.get('/auditing/edit',{'id':id},function (e) {
    if (e.status == 1){
    $("#type1").val(e.data.type);
    $("#user_id").val(e.data.user_id);
    if(e.data.status==1){
    $("#status1").prop('checked','true');
    }else{
    $("#status2").prop('checked','true');
    }
    $('#updateAuditing').modal('show');
    }
    },'json');
    }



    var _token = $("#_token").val();
    function destroyAuditing (id) {
    if(confirm('确认删除该审核模块吗？')){
    $.post("{{url('/auditing/destroy')}}",{"_token":_token,"id":id},function (e) {
    if(e.status == 1){
    layer.msg('删除成功！');
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    }

    }

    {{--添加模块名不允许重复--}}
    function sure()
    {
    var type = $("select[name='type']").val();
    var user_id = $("input[name='Jszzdm']").val();
    var status  = $("input[name='status']").val();
    var _token = $('#_token').val();

    $.post("{{ url('/auditing/store') }}",{_token:_token,type:type,user_id:user_id,status:status},function(data){

    $("input[name='type']").val("");
    if(data.status == 1){
    layer.msg(data.message);
    return false;
    }else{
    layer.msg('保存成功！');
    window.location.reload();
    }
    },'json');
    }
@endsection

@section('load_private')
    @parent

@endsection