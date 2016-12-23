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
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        供货商管理
                    </div>
                </div>
                @include('home.supplier.subnav')
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <a type="button" class="btn btn-white mr-2r" href="{{url('/supplier/create')}}">
                    <i class="glyphicon glyphicon-edit"></i> 添加供应商
                </a>
                @if($tab_menu == 'verifying')
                <button type="button" id="batch-verify" class="btn btn-success mr-2r">
                    <i class="glyphicon glyphicon-ok"></i> 通过审核
                </button>
                @endif
            </div>
            <div class="row scroll">
               <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>公司简称</th>
                            <th>是否签订协议</th>
                            <th>供应商类型</th>
                            <th>折扣</th>
                            <th>开票税率</th>
                            <th>联系人</th>
                            <th>手机号</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($suppliers)
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td class="text-center"><input name="Order" type="checkbox" value="{{ $supplier->id }}"></td>
                                <td>{{ $supplier->nam }}</td>
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
                                <td>{{ $supplier->discount }}</td>
                                <td>{{ $supplier->tax_rate }}</td>
                                <td>{{ $supplier->contact_user }}</td>
                                <td>{{ $supplier->contact_number }}</td>
                                <td>{{ $supplier->summary }}</td>
                                <td>
                                    @if($supplier->assets)
                                    <a href="{{ $supplier->assets->file->srcfile }}" target="_blank"><button type="button" class="btn btn-white btn-sm" >查看协议</button></a>
                                    @endif
                                    @if($tab_menu !== 'close')
                                    <a type="button" class="btn btn-white btn-sm" href="{{url('/supplier/edit')}}?id={{ $supplier->id }}" value="{{ $supplier->id }}">编辑</a>
                                    @endif
                                    <button type="button" class="btn btn-white btn-sm" onclick=" destroySupplier({{ $supplier->id }})" value="{{ $supplier->id }}">关闭</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
               </table> 
            </div>
            @if ($suppliers)
                <div class="col-md-6 col-md-offset-4">{!! $suppliers->appends(['nam' => $nam])->render() !!}</div>
            @endif
        </div>

    </div>
    


    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
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

    {{--供应商审核--}}
    $('#batch-verify').click(function () {
        var supplier = [];
        $("input[name='Order']").each(function () {
            if($(this).is(':checked')){
                supplier.push($(this).attr('value'));
            }
        });
        $.post('{{url('/supplier/ajaxVerify')}}',{'_token': _token,'supplier': supplier}, function (e) {
            if(e.status == 0){
                alert(e.message);
            }else if(e.status == -1){
                alert(e.msg);
            }else{
                location.reload();
            }
        },'json');
    });

@endsection