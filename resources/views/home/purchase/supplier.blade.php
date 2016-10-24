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
                                <input type="text" name="name" class="form-control" placeholder="请输入公司名称">
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
                            <th>联系人</th>
                            <th>手机号</th>
                            <th>备注</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($suppliers)
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td class="text-center"><input type="checkbox" value="{{ $supplier->id }}"></td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->tel }}</td>
                                <td>{{ $supplier->contact_user }}</td>
                                <td>{{ $supplier->contact_number }}</td>
                                <td>{{ $supplier->summary }}</td>
                                <td>
                                    <span class="label label-success">已审核</span>
                                    <span class="label label-danger">待审核</span>
                                    <span class="label label-default">已关闭</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-white btn-sm" onclick="editSupplier({{ $supplier->id }})" value="{{ $supplier->id }}">查看详情</button>
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
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="inputName" class="col-sm-2 control-label">公司名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="公司名称">
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="inputAddress" class="col-sm-2 control-label">注册地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputAddress" name="address" placeholder="注册地址">
                            </div>
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('ein') ? ' has-error' : '' }}">
                            <label for="inputAddress" class="col-sm-2 control-label">税号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEin" name="ein" placeholder="税号">
                            </div>
                            @if ($errors->has('ein'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ein') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('bank_number') ? ' has-error' : '' }}">
                            <label for="inputBank_number" class="col-sm-2 control-label">开户行号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputBank_number" name="bank_number" placeholder="开户行号">
                            </div>
                            @if ($errors->has('bank_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bank_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('bank_address') ? ' has-error' : '' }}">
                            <label for="inputBank_address" class="col-sm-2 control-label">开户银行</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputBank_address" name="bank_address" placeholder="开户银行">
                            </div>
                            @if ($errors->has('bank_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bank_address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('general_taxpayer') ? ' has-error' : '' }}">
                            <label for="inputGeneral_taxpayer" class="col-sm-2 control-label">一般纳税人</label>
                            <div class="col-sm-10">
                                一般纳税人<input type="radio" name="general_taxpayer" value="1" checked>&nbsp&nbsp
                                小规模纳税人<input type="radio" name="general_taxpayer" value="0">
                            </div>
                            @if ($errors->has('general_taxpayer'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('general_taxpayer') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('legal_person') ? ' has-error' : '' }}">
                            <label for="inputLegalPerson" class="col-sm-2 control-label">公司法人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputLegalPerson" name="legal_person" placeholder="法人">
                            </div>
                            @if ($errors->has('legal_person'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('legal_person') }}</strong>
                                </span>
                            @endif
                            <label for="inputTel" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputTel" name="tel" placeholder="法人电话">
                            </div>
                            @if ($errors->has('tel'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tel') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('contact_user') ? ' has-error' : '' }}">
                            <label for="inputContactUser" class="col-sm-2 control-label">联系人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="contact_user" name="contact_user" placeholder="联系人姓名 ">
                            </div>
                            @if ($errors->has('contact_user'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_user') }}</strong>
                                </span>
                            @endif
                            <label for="inputContactNumber" class="col-sm-2 control-label">手机</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactNumber" name="contact_number" placeholder="联系人电话">
                            </div>
                            @if ($errors->has('contact_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                </span>
                            @endif

                        </div>
                        <div class="form-group {{ $errors->has('contact_number') ? ' has-error' : '' }}">
                            <label for="inputContactEmail" class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactEmail" name="contact_email" placeholder="联系人邮箱 ">
                            </div>
                            @if ($errors->has('contact_email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                </span>
                            @endif
                            <label for="inputContactQQ" class="col-sm-2 control-label">qq</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactQQ" name="contact_qq" placeholder="qq">
                            </div>
                            @if ($errors->has('contact_qq'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_qq') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
                            <label for="summary" class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputSummary" name="summary" placeholder="备注">
                            </div>
                            @if ($errors->has('summary'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
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

    {{--更改供应商弹窗--}}
    <div class="modal fade" id="supplierModalUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新供应商信息</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="upSupplier" role="form" method="POST" action="{{ url('/supplier/update') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" id="supplier-id" name="id">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="inputName" class="col-sm-2 control-label">公司名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName1" name="name" placeholder="公司名称">
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="inputAddress" class="col-sm-2 control-label">注册地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputAddress1" name="address" placeholder="注册地址">
                            </div>
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('ein') ? ' has-error' : '' }}">
                            <label for="inputEin" class="col-sm-2 control-label">税号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEin1" name="ein" placeholder="税号">
                            </div>
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('bank_number') ? ' has-error' : '' }}">
                            <label for="inputBank_number" class="col-sm-2 control-label">开户行号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputBank_number1" name="bank_number" placeholder="开户行号">
                            </div>
                            @if ($errors->has('bank_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bank_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('bank_address') ? ' has-error' : '' }}">
                            <label for="inputBank_address" class="col-sm-2 control-label">开户银行</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputBank_address1" name="bank_address" placeholder="开户银行">
                            </div>
                            @if ($errors->has('bank_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bank_address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('general_taxpayer') ? ' has-error' : '' }}">
                            <label for="inputGeneral_taxpayer" class="col-sm-2 control-label">一般纳税人</label>
                            <div class="col-sm-10">
                                一般纳税人<input type="radio" name="general_taxpayer" value="1" id="general_taxpayer1">&nbsp&nbsp
                                小规模纳税人<input type="radio" name="general_taxpayer" value="0" id="general_taxpayer0">
                            </div>
                            @if ($errors->has('general_taxpayer'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('general_taxpayer') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('legal_person') ? ' has-error' : '' }}">
                            <label for="inputLegalPerson" class="col-sm-2 control-label">公司法人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputLegalPerson1" name="legal_person" placeholder="法人">
                            </div>
                            @if ($errors->has('legal_person'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('legal_person') }}</strong>
                                </span>
                            @endif
                            <label for="inputTel" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputTel1" name="tel" placeholder="法人电话">
                            </div>
                            @if ($errors->has('tel'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tel') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('contact_user') ? ' has-error' : '' }}">
                            <label for="inputContactUser" class="col-sm-2 control-label">联系人</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactUser1" name="contact_user" placeholder="联系人姓名 ">
                            </div>
                            @if ($errors->has('contact_user'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_user') }}</strong>
                                </span>
                            @endif
                            <label for="inputContactNumber" class="col-sm-2 control-label">手机</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactNumber1" name="contact_number" placeholder="联系人电话">
                            </div>
                            @if ($errors->has('contact_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('contact_number') ? ' has-error' : '' }}">
                            <label for="inputContactEmail" class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactEmail1" name="contact_email" placeholder="联系人邮箱 ">
                            </div>
                            @if ($errors->has('contact_email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                </span>
                            @endif
                            <label for="inputContactQQ" class="col-sm-2 control-label">qq</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputContactQQ1" name="contact_qq" placeholder="qq">
                            </div>
                            @if ($errors->has('contact_qq'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_qq') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
                            <label for="summary" class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputSummary1" name="summary" placeholder="备注">
                            </div>
                            @if ($errors->has('summary'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
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

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
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
        if(confirm('确认删除该供货商吗？')){
            $.post('/supplier/destroy',{"_token":_token,"id":id},function (e) {
                if(e.status == 1){
                    location.reload();
                }else{
                    alert(e.message);
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
                $("#inputEin1").val(e.data.ein);
                $("#inputBank_number1").val(e.data.bank_number);
                $("#inputBank_address1").val(e.data.bank_address);
                if(e.data.general_taxpayer==1){
                    $("#general_taxpayer1").prop("checked","true");
                }else{
                    $("#general_taxpayer0").prop("checked","true");
                }
                $("#inputLegalPerson1").val(e.data.legal_person);
                $("#inputTel1").val(e.data.tel);
                $("#inputContactUser1").val(e.data.contact_user);
                $("#inputContactNumber1").val(e.data.contact_number);
                $("#inputContactEmail1").val(e.data.contact_email);
                $("#inoutContactQQ1").val(e.data.contact_qq);
                $("#inputSummary1").val(e.data.summary);
                $('#supplierModalUp').modal('show');
            }
        },'json');
    }



@endsection