@extends('home.base')

@section('title', '供应商')

@section('customize_css')
    @parent

@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        供货商信息
                    </div>
                </div>
                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/supplier/search') }}" method="POST">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="请输入供应商名称">
                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            </div>
                            <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
                <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="showtext"></strong>
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <button type="button" class="btn btn-white" data-toggle="modal" data-target="#supplierModal">添加供应商</button>
            </div>
            <div class="row">
               <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>公司名称</th>
                            <th>法人</th>
                            <th>法人联系方式</th>
                            <th>联系人</th>
                            <th>联系人电话</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($suppliers)
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td class="text-center"><input type="checkbox"></td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->legal_person }}</td>
                            <td>{{ $supplier->tel }}</td>
                            <td>{{ $supplier->contact_user }}</td>
                            <td>{{ $supplier->contact_number }}</td>
                            <td>
                                <button type="button" class="btn btn-white btn-sm" onclick="editSupplier({{ $supplier->id }})" value="{{ $supplier->id }}">详情</button>
                                <button type="button" class="btn btn-white btn-sm" onclick=" destroySupplier({{ $supplier->id }})" value="{{ $supplier->id }}">删除</button>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
               </table> 
            </div>
        </div>
        

    </div>
    
    @if ($suppliers)
    <div class="col-md-6 col-md-offset-6">{!! $suppliers->render() !!}</div>
    @endif
    {{--填加供应商弹窗--}}
    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加供应商信息</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="addSupplier" role="form" method="POST" action="{{ url('/supplier/store') }}">
                        {!! csrf_field() !!}
                        <div class="form-group {{ $errors->has('inputName') ? ' has-error' : '' }}">
                            <label for="inputName" class="col-sm-2 control-label">公司名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="公司名称">
                            </div>
                            @if ($errors->has('inputName'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputName') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('inputAddress') ? ' has-error' : '' }}">
                            <label for="inputAddress" class="col-sm-2 control-label">公司地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputAddress" name="address" placeholder="公司地址">
                            </div>
                            @if ($errors->has('inputAddress'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputAddress') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('inputLegalPerson') ? ' has-error' : '' }}">
                            <label for="inputLegalPerson" class="col-sm-2 control-label">公司法人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputLegalPerson" name="legal_person" placeholder="法人">
                            </div>
                            @if ($errors->has('inputLegalPerson'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputLegalPerson') }}</strong>
                                </span>
                            @endif
                            <label for="inputTel" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputTel" name="tel" placeholder="法人电话">
                            </div>
                            @if ($errors->has('inputTel'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputTel') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('inputContactUser') ? ' has-error' : '' }}">
                            <label for="inputContactUser" class="col-sm-2 control-label">联系人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactUser" name="contact_user" placeholder="联系人姓名 ">
                            </div>
                            @if ($errors->has('inputContactUser'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputContactUser') }}</strong>
                                </span>
                            @endif
                            <label for="inputContactNumber" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactNumber" name="contact_number" placeholder="联系人电话">
                            </div>
                            @if ($errors->has('inputContactNumber'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputContactNumber') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('inputContactEmail') ? ' has-error' : '' }}">
                            <label for="inputContactEmail" class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactEmail" name="contact_email" placeholder="联系人邮箱 ">
                            </div>
                            @if ($errors->has('inputContactEmail'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputContactEmail') }}</strong>
                                </span>
                            @endif
                            <label for="inputContactQQ" class="col-sm-2 control-label">qq</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactQQ" name="contact_qq" placeholder="qq">
                            </div>
                            @if ($errors->has('inputContactQQ'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('inputContactQQ') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <div class="modal-footer pb-r">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button id="submit_supplier" type="submit" class="btn btn-magenta">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    {{--更改供应商信息弹窗--}}
    <div class="modal fade" id="supplierUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新供应商信息</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="updateSupplier" action="{{ url('/supplier/update') }}">
                        <input type="hidden" id="supplier-id">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">公司名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName1" name="name" placeholder="公司名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-sm-2 control-label">公司地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputAddress1" name="address" placeholder="公司地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLegalPerson" class="col-sm-2 control-label">公司法人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputLegalPerson1" name="legal_person" placeholder="法人">
                            </div>
                            <label for="inputTel" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputTel1" name="tel" placeholder="法人电话">
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                        <div class="form-group">
                            <label for="inputContactUser" class="col-sm-2 control-label">联系人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactUser1" name="contact_user" placeholder="联系人姓名 ">
                            </div>
                            <label for="inputContactNumber" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactNumber1" name="contact_number" placeholder="联系人电话">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputContactEmail" class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactEmail1" name="contact_email" placeholder="联系人邮箱 ">
                            </div>
                            <label for="inputContactQQ" class="col-sm-2 control-label">qq</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactQQ1" name="contact_qq" placeholder="qq">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button id="update_supplier" type="button" class="btn btn-magenta">确认修改</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    {{--添加表单验证--}}
    $('#addSupplier').formValidation({
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
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: '公司地址不能为空！'
                    }
                }
            },
            legal_person: {
                validators: {
                    notEmpty: {
                        message: '公司法人不能为空！'
                    }
                }
            },
            tel: {
                validators: {
                    notEmpty: {
                        message: '联系方式不能为空！'
                    }
                }
            },
            contact_user: {
                validators: {
                    notEmpty: {
                        message: '联系人不能为空！'
                    }
                }
            },
            contact_number: {
                validators: {
                    notEmpty: {
                        message: '联系人电话不能为空！'
                    }
                }
            },
        }
    });

    {{--添加表单验证--}}
    $('#updateSupplier').formValidation({
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
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: '公司地址不能为空！'
                    }
                }
            },
            legal_person: {
                validators: {
                    notEmpty: {
                        message: '公司法人不能为空！'
                    }
                }
            },
            tel: {
                validators: {
                    notEmpty: {
                        message: '联系方式不能为空！'
                    }
                }
            },
            contact_user: {
                validators: {
                    notEmpty: {
                        message: '联系人不能为空！'
                    }
                }
            },
            contact_number: {
                validators: {
                    notEmpty: {
                        message: '联系人电话不能为空！'
                    }
                }
            },
        }
    });
/*
    $(".close").click(function () {
        $('#warning').hide();
    });

    var _token = $("#_token").val();
    $("#submit_supplier").click(function () {
        var name = $("#inputName").val();
        var address = $("#inputAddress").val();
        var legal_person = $("#inputLegalPerson").val();
        var tel = $("#inputTel").val();
        var contact_user = $("#inputContactUser").val();
        var contact_number = $("#inputContactNumber").val();
        var contact_email = $("#inputContactEmail").val();
        var contact_qq = $("#inoutContactQQ").val();
        $.ajax({
            type: "post",
            url: "/supplier/store",
            data: {"_token":_token, "name":name, "address":address, "legal_person":legal_person, "tel":tel, "contact_user":contact_user, "contact_number":contact_number, "contact_email":contact_email, "contact_qq":contact_qq},
            dataType:'json',
            success:function (data) {
                if (data.status == 1){
                    location.reload();
                }
                if(data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error:function (data) {
                $('#supplierModal').modal('hide');
                var messages = eval("("+data.responseText+")");
                for(i in messages){
                    var message = messages[i][0];
                    break;
                }
                $('#showtext').html(message);
                $('#warning').show();
            }
        });
    });

    function destroySupplier (id) {
        if(confirm('确认删除该供货商吗？')){
            $.post('/supplier/destroy',{"_token":_token,"id":id},function (e) {
                if(e.status == 1){
                    location.reload();
                }else{
                    $('#showtext').html(e.message);
                    $('#warning').show();
                }
            },'json');
        }

    }

    function editSupplier(id) {
        //alert(123);
        $.get('/supplier/edit',{'id':id},function (e) {
            if (e.status == 1){
                $("#supplier-id").val(e.data.id);
                $("#inputName1").val(e.data.name);
                $("#inputAddress1").val(e.data.address);
                $("#inputLegalPerson1").val(e.data.legal_person);
                $("#inputTel1").val(e.data.tel);
                $("#inputContactUser1").val(e.data.contact_user);
                $("#inputContactNumber1").val(e.data.contact_number);
                $("#inputContactEmail1").val(e.data.contact_email);
                $("#inoutContactQQ1").val(e.data.contact_qq);
                $('#supplierUpModal').modal('show');
            }else{
                $('#showtext').html(e.message);
                $('#warning').show();
            }
        },'json');
    }

    $("#update_supplier").click(function () {
        var id = $("#supplier-id").val();
        var name = $("#inputName1").val();
        var address = $("#inputAddress1").val();
        var legal_person = $("#inputLegalPerson1").val();
        var tel = $("#inputTel1").val();
        var contact_user = $("#inputContactUser1").val();
        var contact_number = $("#inputContactNumber1").val();
        var contact_email = $("#inputContactEmail1").val();
        var contact_qq = $("#inoutContactQQ1").val();
        $.ajax({
            type: "post",
            url: "/supplier/update",
            data: {"_token":_token, "id":id, "name":name, "address":address, "legal_person":legal_person, "tel":tel, "contact_user":contact_user, "contact_number":contact_number, "contact_email":contact_email, "contact_qq":contact_qq},
            dataType:'json',
            success:function (data) {
                if (data.status == 1){
                    location.reload();
                }
                if(data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error:function (data) {
                $('#supplierModal').modal('hide');
                var messages = eval("("+data.responseText+")");
                for(i in messages){
                    var message = messages[i][0];
                    break;
                }
                $('#showtext').html(message);
                $('#warning').show();
            }
        });
    });*/

@endsection