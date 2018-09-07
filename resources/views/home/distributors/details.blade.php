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
                                <li for="phone" class="mb-0r control-label col-md-6"><b>法人身份证号:</b>{{ $distributors->legal_number }}</li>
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
                                <li for="name" class="mb-0r control-label col-md-6"><b>门店联系人姓名:</b>{{ $user->name }}</li>
                                <li for="phone" class="mb-0r control-label col-md-6"><b>门店联系人手机号:</b>{{ $user->phone }}</li>
                                {{--<li for="phone" class="mb-0r control-label col-md-6"><b>用户名:</b>{{ $user->account }}</li>--}}
                                <li for="phone" class="mb-0r control-label col-md-6"><b>门店联系人职位:</b>{{ $distributors->position }}</li>
                            </ul>


                            <h5>图片信息</h5>
                            <hr>

                            <ul class="form-group clearfix" style="list-style-type:none;line-height: 30px;">

                                <li for="front_id" class="mb-0r control-label col-md-6"><b>门店正面照片:</b>
                                @if($assets_front)
{{--                                    @foreach($assets_front as $v)--}}
                                        <img src="{{ $assets_front->file->small }}" style="width: 150px;" class="img-thumbnail">
                                    {{--@endforeach--}}
                                    @endif
                                </li>

                                <li for="Inside_id" class="mb-0r control-label col-md-6"><b>门店内部照片:</b>
                                    @if($assets_Inside)
{{--                                        @foreach($assets_Inside as $v)--}}
                                            <img src="{{ $assets_Inside->file->small }}" style="width: 150px;" class="img-thumbnail">
                                        {{--@endforeach--}}
                                    @endif
                                </li>

                                <li for="portrait_id" class="mb-0r control-label col-md-6"><b>身份证人像面照片:</b>
                                    @if($assets_portrait)
{{--                                        @foreach($assets_portrait as $v)--}}
                                            <img src="{{ $assets_portrait->file->small }}" style="width: 150px;" class="img-thumbnail">
                                        {{--@endforeach--}}
                                    @endif
                                </li>

                                <li for="national_emblem_id" class="mb-0r control-label col-md-6"><b>身份证国徽面照片:</b>
                                    @if($assets_national_emblem)
{{--                                        @foreach($assets_national_emblem as $v)--}}
                                            <img src="{{ $assets_national_emblem->file->small }}" style="width: 150px;" class="img-thumbnail">
                                        {{--@endforeach--}}
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
                                <label for="category_id" class="col-sm-2 control-label">选择商品分类<em>*</em></label>
                                <div class="col-sm-3">
                                    <div class="input-group  col-md-12">
                                        <div class="col-sm-8" style="padding-top:5px">
                                            @foreach($categorys as $list)
                                                @if($list['type'] == 1)
                                        <input type="checkbox" name="category_id" id="category_id" class="checkcla" required value="{{ $list->id }}">{{ $list->title }}
                                        @endif
                                            @endforeach

                                        </div>
                                        <input type="hidden" name="diyu" id="diyu" value="@Model.diyu" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="authorization_id" class="col-sm-2 control-label">选择授权类型<em>*</em></label>
                                <div class="col-sm-3">
                                    <div class="input-group  col-md-12">
                                        <div class="col-sm-8" style="padding-top:5px">
                                            @foreach($authorization as $list)
                                                @if($list['type'] == 2)
                                                    <input type="checkbox" name="authorization_id" id="authorization_id" class="checkcla" required value="{{ $list->id }}">{{ $list->title }}
                                                @endif
                                            @endforeach

                                        </div>
                                        <input type="hidden" name="Jszzdm" id="Jszzdm" value="@Model.Jszzdm" />
                                    </div>
                                </div>
                            </div>

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
            </div>
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
    })

    {{--商品分类--}}
    $("input[name='category_id']").change(function(){
    $('#diyu').val($("input[name='category_id']:checked").map(function(){
    return this.value
    }).get().join(','))
    })



    $(document).on("click","#batch-verify",function(obj){
    layer.confirm('确认要通过审核吗？',function(index){
    var id =  $("input[name='id']").val();
    var Jszzdm =  $("input[name='Jszzdm']").val();
    var diyu =  $("input[name='diyu']").val();

    $.post('{{url('/distributors/ajaxVerify')}}',{'_token': _token,'id': id,'Jszzdm':Jszzdm,'diyu':diyu}, function (data) {
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
    });


    {{--经销商关闭--}}

    $(document).on("click","#batch-close",function(obj){
    layer.confirm('确认要驳回审核吗？',function(index){
    var distributors = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    distributors.push($(this).attr('value'));
    }
    });

    $.post('{{url('/distributors/ajaxClose')}}',{'_token': _token,'distributors': distributors}, function (e) {

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
    });
@endsection