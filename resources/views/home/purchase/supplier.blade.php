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
                <ul class="nav navbar-nav nav-list">
                    <li class="active"><a href="{{url('/supplier')}}">已审核</a></li>
                    <li><a href="{{url('/supplier/verifyList')}}">待审核</a></li>
                    <li><a href="{{url('/supplier/closeList')}}">已关闭</a></li>
                </ul>
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
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <button type="button" class="btn btn-white" data-toggle="modal" data-target="#supplierModal">
                    <i class="glyphicon glyphicon-edit"></i> 添加供应商
                </button>
                <button type="button" id="batch-verify" class="btn btn-white">
                    <i class="glyphicon glyphicon-ok"></i> 通过审核
                </button>
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
                                    <button type="button" class="btn btn-white btn-sm" onclick="editSupplier({{ $supplier->id }})" value="{{ $supplier->id }}">编辑</button>
                                    <button type="button" class="btn btn-white btn-sm" onclick=" destroySupplier({{ $supplier->id }})" value="{{ $supplier->id }}">关闭使用</button>
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
    @include('modal.add_supplier_info')
    {{--更改供应商弹窗--}}
    @include('modal.edit_supplier_info')

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
                $("#inputDiscount1").val(e.data.discount);
                $("#inputTaxRate1").val(e.data.tax_rate);
                $("#inputNam1").val(e.data.nam);
                $(".inputType1").each(function () {
                    if($(this).attr('value') == e.data.type){
                        $(this).attr('selected',true);
                    }
                });

                $('#supplierModalUp').modal('show');

                var template = ['@{{ #assets }}<div class="col-md-2 mb-3r">',
                    '<img src="@{{ path }}" style="width: 100px;height: 100px;" class="img-thumbnail">',
                    '<a class="removeimg" value="@{{ id }}">删除</a>',
                    '</div>@{{ /assets }}'].join("");
                var views = Mustache.render(template, e.data);
                $('#update-sku-pic').html(views);

                $('.removeimg').click(function(){
                    var id = $(this).attr("value");
                    var img = $(this);
                    $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                        if(e.status){
                            img.parent().remove();
                        }else{
                            console.log(e.message);
                        }
                    },'json');
                });
            }
        },'json');
    }

    {{--创建供应商信息上传图片--}}
    new qq.FineUploader({
        element: document.getElementById('add-sku-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: 'https://up.qbox.me',
            params:  {
                "token": '{{ $token }}',
                "x:random": '{{ $random[0] }}',
                "x:user_id":'{{ $user_id }}'
            },
            inputName:'file',
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png','tpg'],
            sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
        },
        //回调函数
        callbacks: {
            //上传完成后
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    $("#create_cover_id").val(responseJSON.asset_id);
                    $('.sku-pic').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
                    $('.removeimg').click(function(){
                        var id = $(this).attr("value");
                        var img = $(this);
                        $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                            if(e.status){
                                img.parent().remove();
                            }else{
                                console.log(e.message);
                            }
                        },'json');
                    });
                } else {
                    alert('上传图片失败');
                }
            }
        }
    });
    
    {{--修改供应商信息上传图片--}}
    new qq.FineUploader({
        element: document.getElementById('update-sku-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: 'http://upload.qiniu.com/',
            params:  {
                "token": '{{ $token }}',
                "x:random": '{{ $random[1] }}',
                "x:user_id":'{{ $user_id }}',
            },
            inputName:'file',
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png' ,'tpg'],
            sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
        },
        //回调函数
        callbacks: {
            //上传完成后
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    console.log(responseJSON.success);
                    $("#update_cover_id").val(responseJSON.asset_id);
                    $('#update-sku-pic').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
                    $('.removeimg').click(function(){
                        var id = $(this).attr("value");
                        var img = $(this);
                        $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                            if(e.status){
                                img.parent().remove();
                            }else{
                                console.log(e.message);
                            }
                        },'json');
                    });
                } else {
                    alert('上传图片失败');
                }
            }
        }
    });
    
    $('#batch-verify').click(function () {
        var supplier = [];
        $("input[name='Order']").each(function () {
            if($(this).is(':checked')){
                supplier.push($(this).attr('value'));
            }
        });
        $.post('{{url('/supplier/ajaxVerify')}}',{'_token': _token,'supplier': supplier}, function (e) {
            if(e.status){
                location.reload();
            }else{
                alert(e.message);
            }
        },'json');
    });

@endsection