@extends('home.base')

@section('title', '经销商详情')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
	#picForm .form-control {
		top: 0;
	    left: 0;
	    position: absolute;
	    opacity: 0;
	    width: 100px;
	    height: 100px;
	    z-index: 3;
	    cursor: pointer;
	}
	#appendsku {
		margin-left:40px;
		font-size:14px;
	}
	.qq-upload-button {
		width: 100px;
		height: 100px;
		position: absolute !important;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    经销商详情
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    {{--<form id="add-product" role="form" class="form-horizontal" method="post">--}}
                        {{--{{ csrf_field() }}--}}
                    <div class="row mb-2r" id="update-product-img">

                        <div class="col-md-2 mb-3r" style="display: none">
                            <div style="width: 70px;height: 5px;background: lightblue;">
                                <div id="progress_bar" style="width: 0px;height: 5px;background: blue;"></div>
                            </div>
                        </div>
                        <div class="asset col-md-12">
                            <h5>企业信息</h5>
                            <hr>

                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="name" class="mb-0r control-label col-md-6"><b>企业全称:</b>{{ $distributors->full_name }}</li>
                                <li for="name" class="mb-0r control-label col-md-6"><b>企业所在地址:</b>{{ $distributors->enter_address }}</li>
                                <li for="name" class="mb-0r control-label col-md-6"><b>企业电话:</b>{{ $distributors->enter_phone }}</li>
                                <li for="bank_name" class="mb-0r control-label col-md-6"><b>企业开户行:</b>{{ $distributors->bank_name }}</li>
                                <li for="phone" class="mb-0r control-label col-md-6"><b>法人姓名:</b>{{ $distributors->legal_person }}</li>
                                <li for="phone" class="mb-0r control-label col-md-6"><b>法人手机号:</b>{{ $distributors->legal_phone }}</li>
                                {{--<li for="phone" class="mb-0r control-label col-md-6"><b>法人身份证号:</b>{{ $distributors->legal_number }}</li>--}}
                                <li for="bank_number" class="mb-0r control-label col-md-6"><b>银行账号:</b>{{ $distributors->bank_number }}</li>
                                <li for="business_license_number" class="mb-0r control-label col-md-6"><b>营业执照号:</b>{{ $distributors->business_license_number }}</li>
                                <li for="taxpayer" class="mb-0r control-label col-md-6"><b>纳税人类型:</b>    @if($distributors->taxpayer == 1)
                                        <td>一般纳税人</td>
                                    @elseif($distributors->taxpayer == 2)
                                        <td>小规模纳税人</td>
                                    @endif</li>
                            </ul>

                            <h5>门店信息</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="store_name" class="mb-0r control-label col-md-6"><b>门店名称:</b>{{ $distributors->store_name }}</li>
                                <li for="province_id" class="mb-0r control-label col-md-6"><b>门店所在地址:</b>{{ $distributors->address }}</li>
                                <li for="name" class="mb-0r control-label col-md-6"><b>门店联系人姓名:</b>{{ $distributors->name }}</li>
                                <li for="phone" class="mb-0r control-label col-md-6"><b>门店联系人手机号:</b>{{ $distributors->phone }}</li>
                                {{--<li for="phone" class="mb-0r control-label col-md-6"><b>用户名:</b>{{ $user->account }}</li>--}}
                                <li for="phone" class="mb-0r control-label col-md-6"><b>门店联系人职位:</b>{{ $distributors->position }}</li>
                            </ul>


                            <h5>图片信息</h5>
                            <hr>

                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">

                                <li for="front_id" class="mb-0r control-label col-md-6"><b>门店正面照片:</b>
                                @if($assets_front)
                                        <a href="{{$assets_front->file->p800}}" target="_blank">
                                            <img src="{{$assets_front->file->small}}" alt="" class="img-thumbnail">
                                        </a>
                                    @endif
                                </li>

                                <li for="Inside_id" class="mb-0r control-label col-md-6"><b>门店内部照片:</b>
                                    @if($assets_Inside)
                                        <a href="{{$assets_Inside->file->p800}}" target="_blank">
                                            <img src="{{$assets_Inside->file->small}}" alt="" class="img-thumbnail">
                                        </a>
                                    @endif
                                </li>

                                <li for="portrait_id" class="mb-0r control-label col-md-6"><b>身份证人像面照片:</b>
                                    @if($assets_portrait)
                                        <a href="{{$assets_portrait->file->p800}}" target="_blank">
                                            <img src="{{$assets_portrait->file->small}}" alt="" class="img-thumbnail">
                                        </a>
                                    @endif
                                </li>

                                <li for="national_emblem_id" class="mb-0r control-label col-md-6"><b>身份证国徽面照片:</b>
                                    @if($assets_national_emblem)
                                        <a href="{{$assets_national_emblem->file->p800}}" target="_blank">
                                            <img src="{{$assets_national_emblem->file->small}}" alt="" class="img-thumbnail">
                                        </a>
                                    @endif
                                </li>

                            </ul>

                            <h5>审核状态</h5>
                            <hr>
                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">
                                <li for="status" class="mb-0r control-label col-md-6"><b>状态:</b>
                                @if($distributors->status == 1)
                                    <td>待审核</td>
                                @elseif($distributors->status == 2)
                                    <td>已审核</td>
                                @elseif($distributors->status == 3)
                                    <td>未通过</td>

                                @elseif($distributors->status == 4)
                                    <td>重新审核</td>

                                @endif
                                </li>
                                {{--<li for="msg" class="mb-0r control-label col-md-6"><b>原因:</b>{{ $supplier->msg}}</li>--}}
                            </ul>
                            <input type="hidden" name="id" value="{{$distributors->id}}">

                            <h5>商品分类</h5>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="category_id" class="col-sm-6 control-label {{ $errors->has('category_id') ? ' has-error' : '' }}"><em style="color: red">*</em> 选择商品分类</label>

                                    <div class="input-group  col-md-12">
                                        <div class="col-sm-6" style="padding-top:5px">
                                            @foreach($categorys as $list)
                                                @if($list['type'] == 1)
                                        <input type="checkbox" name="category_id" id="category_id" class="checkcla" required value="{{ $list->id }}"  @if(in_array($list->id,$categorie)) checked="checked" @endif>{{ $list->title }}
                                        @endif
                                            @endforeach

                                        </div>
                                        <input type="hidden" name="diyu" id="diyu" value="@Model.diyu" />
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <label for="authorization_id" class="col-sm-6 control-label {{ $errors->has('authorization_id') ? ' has-error' : '' }}"><em style="color: red">*</em> 选择授权类型</label>

                                    <div class="input-group  col-md-12">
                                        <div class="col-sm-6" style="padding-top:5px">
                                            @foreach($authorization as $list)
                                                @if($list['type'] == 2)
                                                    <input type="checkbox" name="authorization_id" id="authorization_id" class="checkcla" required value="{{ $list->id }}"  @if(in_array($list->id,$authoriza)) checked="checked" @endif>{{ $list->title }}
                                                @endif
                                            @endforeach

                                        </div>
                                        <input type="hidden" name="Jszzdm" id="Jszzdm" value="@Model.Jszzdm" />
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <label for="mode" class="col-sm-6 control-label"><em style="color: red">*</em> 选择是否月结</label>
                                    <div class="input-group col-md-6">
                                        <select class="chosen-select" name="mode">
                                            {{--<option value="" >请选择是否月结</option>--}}
                                                <option value="2"{{ $distributors->mode == 2?'selected':'' }}>非月结</option>
                                                <option value="1"{{ $distributors->mode == 1?'selected':'' }}>月结</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                                <div class="form-group" style="padding-top: 100px;width: 100%">
                                <h5>电子版合同<small class="text-warning">［请上传文件,大小10MB以内］</small></h5>
                                <hr>
                                <div class="row mb-2r sku-pic">
                                    {{--<div class="row mb-2r" id="update-product-img" style="float: left">--}}
                                    <div class="row mb-2r" id="update-product-img">
                                        <div class="col-md-2">
                                            <div id="picForm" enctype="multipart/form-data">
                                                <div class="img-add">
                                                    <span class="glyphicon glyphicon-plus f46"></span>
                                                    <p class="uptitle">添加图片</p>
                                                    <div id="fine-uploader"></div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="contract_id" name="contract_id" value="{{$distributors->contract_id}}">
                                            <script type="text/template" id="qq-template">
                                                <div id="add-img" class="qq-uploader-selector qq-uploader">
                                                    <div class="qq-upload-button-selector qq-upload-button">
                                                        <div>上传图片</div>
                                                    </div>
                                                    <ul class="qq-upload-list-selector qq-upload-list">
                                                        <li hidden></li>
                                                    </ul>
                                                </div>
                                            </script>
                                        </div>
                                        <div class="col-md-2 mb-3r" style="display: none">
                                            <div style="width: 70px;height: 5px;background: lightblue;">
                                                <div id="progress_bar" style="width: 0px;height: 5px;background: blue;"></div>
                                            </div>
                                        </div>

                                        <div class="asset">
                                            @if($assets_contract)
                                                <a href="{{$assets_contract->file->p800}}" target="_blank">
                                                    <img src="{{$assets_contract->file->small}}" style="width: 150px;" class="img-thumbnail">
                                                </a>

                                                <a class="removeimg" value="{{ $assets_contract->id }}"><i class="glyphicon glyphicon-remove"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <input type="hidden" name="random" value="{{ $random }}">
                                    <input type="hidden" id="id" name="id" value="{{ $distributors->id }}">
                                    <input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
                            <div class="col-sm-12" style="text-align: center">

                                <button type="button" id="batch-verify" class="btn btn-success mr-2r">
                                <i class="glyphicon glyphicon-ok"></i> 通过审核
                                </button>
                                <button type="button" id="batch-close" class="btn btn-danger mr-2r">
                                <i class="glyphicon glyphicon-remove"></i> 驳回
                                </button>

                                </div>
                        </div>


                </div>
            </div>
                    {{--</form>--}}
        </div>
	</div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
@endsection

@section('customize_js')
    @parent

    {{--<script>--}}
    var _token = $('#_token').val();
    {{--授权条件--}}
    $("input[name='authorization_id']").change(function(){
    $('#Jszzdm').val($("input[name='authorization_id']:checked").map(function(){
    return this.value
    }).get().join(','))
    });

    {{--商品分类--}}
    $("input[name='category_id']").change(function(){
    $('#diyu').val($("input[name='category_id']:checked").map(function(){
    return this.value
    }).get().join(','))
    })


    $(document).on("click","#batch-verify",function(obj){
            {{--if($("input[name='category_id']").prop("checked")){--}}
                {{--var diyu = $("input[name='diyu']").val();--}}
                {{--}else{--}}
                {{--layer.msg("请完善必填项！");--}}
                {{--return false;--}}
                {{--}--}}
                {{--if($("input[name='authorization_id']").prop("checked")){--}}
                {{--var Jszzdm = $("input[name='Jszzdm']").val();--}}
                {{--}else{--}}
                {{--layer.msg("请完善必填项！");--}}
                {{--return false;--}}
                {{--}--}}
    layer.confirm('我已勾选商品分类和授权条件，确认通过审核',function(index){
                var id = $("input[name='id']").val();
                var Jszzdm = $("input[name='Jszzdm']").val();
                var diyu = $("input[name='diyu']").val();
                var mode = $("select[name='mode']").val();
                var contract_id = $("input[name='contract_id']").val();

                if(Jszzdm == '' || diyu == '' || mode == ''){
                layer.msg("请完善必填项！");
                return false;
                }

    $.post('{{url('/distributors/ajaxVerify')}}',{'_token': _token,'id': id,'Jszzdm':Jszzdm,'diyu':diyu,'mode':mode,'contract_id':contract_id}, function (data) {
    if(data.status == 0){
    layer.msg('操作成功！');
    {{--window.location.go(-1);--}}
    {{--window.history.go(-1);--}}
    location.href = '{{url('/distributors')}}';
    }else if(data.status == 1){
    alert(data.message);
    }else{
    location.reload();
    }
    },'json');
    });
    });


    {{--经销商关闭--}}

    $(document).on("click","#batch-close",function(obj){
    layer.confirm('确认要驳回审核吗？',function(index){
    var id =  $("input[name='id']").val();
    var Jszzdm =  $("input[name='Jszzdm']").val();
    var diyu =  $("input[name='diyu']").val();

    $.post('{{url('/distributors/ajaxClose')}}',{'_token': _token,'id': id,'Jszzdm':Jszzdm,'diyu':diyu}, function (e) {

    if(e.status == 0){
    layer.msg('操作成功！');
    location.href = '{{url('/distributors')}}';
    }else if(e.status == 1){
    alert(e.message);
    }else{
    location.reload();
    }
    },'json');
    });
    });

    new qq.FineUploader({
    element: document.getElementById('fine-uploader'),
    autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
    // 远程请求地址（相对或者绝对地址）
    request: {
    endpoint: 'https://up.qbox.me',
    params:  {
                "token": '{{ $token }}',
                "x:random": '{{ $random }}',
                "x:user_id":'{{ $user_id }}',
                "x:target_id":'{{ $distributors->id }}',
                "x:type": 19,
    },
    inputName:'file',
    },
    validation: {
                allowedExtensions: ['pdf','jpeg', 'jpg', 'png'],
                sizeLimit: 10485760 // 10M = 10 * 1024 * 1024 bytes
                },
                messages: {
                typeError: "仅支持后缀['pdf','jpeg', 'jpg', 'png']格式文件",
                sizeError: "上传文件最大不超过10M"
    },
    //回调函数
    callbacks: {
    //上传完成后
    onComplete: function(id, fileName, responseJSON) {
    if (responseJSON.success) {
    console.log(responseJSON.success);
    $("#contract_id").val(responseJSON.asset_id);

    $('.sku-pic').append('<div class="col-md-2"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');

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
    alert('上传失败！');
    }
    }
    }
    });

@endsection