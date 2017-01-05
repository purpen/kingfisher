@extends('home.base')

@section('customize_css')
    @parent
    .bnonef{
    	padding:0;
    	box-shadow:none !important; 
    	background:none;
    	color:#fff !important;
    }
    .maindata input{
        width:100px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						编辑客户
					</div>
				</div>

			</div>
		</div>
        
        <div class="container mainwrap">
            @include('block.form-errors')

            <div class="row formwrapper">
                <div class="col-md-12">
                    <form id="edit-order" role="form" method="post" class="form-horizontal" action="{{ url('/orderUser/update') }}">
                        <input type="hidden" name="id" value="{{$orderUser->id}}">
                        <h5>客户信息</h5>
                        <hr>

                        <div class="form-group">
                            <label for="username" class="col-sm-1 control-label">收货人<em>*</em></label>
                            <div class="col-sm-2">
                                <input type="text" name="username" class="form-control" value="{{$orderUser->username}}">
                            </div>

                            <label for="phone" class="col-sm-1 control-label">手机号<em>*</em></label>
                            <div class="col-sm-2">
                                <input type="text" name="phone" class="form-control" value="{{$orderUser->phone}}">
                            </div>

                            <label for="tel" class="col-sm-1 control-label">电话</label>
                            <div class="col-sm-2">
                                <input type="text" name="tel" class="form-control" value="{{$orderUser->tel}}">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="store_id" class="col-sm-1 control-label">店铺名称<em>*</em></label>
                            <div class="col-sm-2">
                                <select class="selectpicker" id="store_id" name="store_id" style="display: none;">
                                    <option value="">选择店铺</option>
                                    @foreach($store_list as $store)
                                        @if($orderUser->store_id == $store->id )
                                        <option value="{{$store->id}}" selected>{{$store->name}}</option>
                                        @else
                                        <option value="{{$store->id}}">{{$store->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <label for="type" class="col-sm-1 control-label">会员性质<em>*</em></label>
                            <div class="col-sm-3">
                                <select class="selectpicker" id="type" name="type" style="display: none;">
                                    @if($orderUser->type == 1)
                                    <option selected value='1'>普通订单</option>
                                    <option value='2'>渠道订单</option>
                                    <option value='3'>电商订单</option>
                                    @elseif($orderUser->type == 2)
                                    <option value='1'>普通订单</option>
                                    <option selected value='2'>渠道订单</option>
                                    <option value='3'>电商订单</option>
                                    @else
                                    <option value='1'>普通订单</option>
                                    <option value='2'>渠道订单</option>
                                    <option selected value='3'>电商订单</option>
                                    @endif
                                </select>
                            </div>

                            <label for="from_to" class="col-sm-1 control-label">会员来源<em>*</em></label>
                            <div class="col-sm-3">
                                <select class="selectpicker" id="from_to" name="from_to" style="display: none;">
                                    @if($orderUser->from_to == 1)
                                    <option value="">选择来源</option>
                                    <option value='1' selected>淘宝</option>
                                    <option value='2'>京东</option>
                                    <option value='3'>自营</option>
                                    @elseif($orderUser->from_to == 2)
                                    <option value="">选择来源</option>
                                    <option value='1'>淘宝</option>
                                    <option value='2' selected>京东</option>
                                    <option value='3'>自营</option>
                                    @else
                                    <option value="">选择来源</option>
                                    <option value='1'>淘宝</option>
                                    <option value='2'>京东</option>
                                    <option value='3' selected>自营</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="account" class="col-sm-1 control-label">账户</label>
                            <div class="col-sm-2">
                                <input type="text" name="account" class="form-control" value="{{$orderUser->account}}">
                                @if (session('error_message'))
                                    <div class="col-sm-10 col-sm-offset-2 error_message">
                                        <p class="text-danger">{{ session('error_message') }}</p>
                                    </div>
                                @endif
                            </div>

                            <label for="email" class="col-sm-1 control-label">邮箱</label>
                            <div class="col-sm-2">
                                <input type="text" name="email" class="form-control" value="{{$orderUser->email}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="qq" class="col-sm-1 control-label">QQ</label>
                            <div class="col-sm-2">
                                <input type="text" name="qq" class="form-control" value="{{$orderUser->qq}}">
                            </div>

                            <label for="ww" class="col-sm-1 control-label">旺旺</label>
                            <div class="col-sm-2">
                                <input type="text" name="ww" class="form-control" value="{{$orderUser->ww}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sex" class="col-sm-1 control-label">性别</label>
                            <div class="col-sm-2">
                                <div class="radio-inline">
                                    @if($orderUser->sex == 0)
                                    <label class="mr-3r">
                                        <input name="sex" value="1" type="radio" id="orderUserSex1"> 男
                                    </label>
                                    <label class="ml-3r">
                                        <input name="sex" value="0" checked type="radio" id="orderUserSex0"> 女
                                    </label>
                                    @else
                                    <label class="mr-3r">
                                        <input name="sex" value="1" checked type="radio" id="orderUserSex1"> 男
                                    </label>
                                    <label class="ml-3r">
                                        <input name="sex" value="0" type="radio" id="orderUserSex0"> 女
                                    </label>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="province_id" class="col-sm-1 control-label">省份<em>*</em></label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="province_id" name="province_id" value="{{$orderUser->buyer_province}}">
                                {{--<select class="selectpicker" id="province_id" name="province_id">--}}
                                    {{--@foreach($china_city as $v)--}}
                                        {{--@if($orderUser->buyer_province == $v->name)--}}
                                        {{--<option class="province" value="{{$v->oid}}" selected>{{$v->name}}</option>--}}
                                        {{--@else--}}
                                        {{--<option class="province" value="{{$v->oid}}">{{$v->name}}</option>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            </div>
                            <label for="district_id" class="col-sm-1 control-label">城市<em>*</em></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="city_id" name="city_id" value="{{$orderUser->buyer_city}}">
                                {{--<select class="selectpicker" id="city_id" name="city_id">--}}
                                    {{--<option value="{{$orderUser->buyer_city}}" selected>{{$orderUser->buyer_city}}</option>--}}
                                {{--</select>--}}
                            </div>
                            <label for="county_id" class="col-sm-1 control-label">区/县</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="county_id" name="county_id" value="{{$orderUser->buyer_county}}">
                                {{--<select class="selectpicker" id="county_id" name="county_id">--}}
                                    {{--<option value="{{$orderUser->buyer_county}}" selected>{{$orderUser->buyer_county}}</option>--}}
                                {{--</select>--}}
                            </div>
                            <label for="township_id" class="col-sm-1 control-label">镇</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="township_id" name="township_id" value="{{$orderUser->buyer_township}}">
                                {{--<select class="selectpicker" id="township_id" name="township_id">--}}
                                    {{--<option value="{{$orderUser->buyer_township}}" selected>{{$orderUser->buyer_township}}</option>--}}
                                {{--</select>--}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="buyer_address" class="col-sm-1 control-label">详细地址<em>*</em></label>
                            <div class="col-sm-7">
                                <input type="text" name="buyer_address" class="form-control" value="{{$orderUser->buyer_address}}">
                            </div>
                            <label for="buyer_address" class="col-sm-1 control-label">邮编</label>
                            <div class="col-sm-2">
                                <input type="text" name="zip" class="form-control" value="{{$orderUser->zip}}">
                            </div>
                        </div><hr>


                        <div class="form-group mt-3r">
                            <div class="col-sm-6 mt-4r">
                                <button type="submit" class="btn btn-magenta btn-lg save mr-2r">确认提交</button>
                                <button type="button" class="btn btn-white cancel btn-lg once" onclick="window.history.back()">取消</button>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
            
        </div>
    </div>



@endsection

@section('customize_js')
    @parent
    $('#add-order').formValidation({
        framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                    validators: {
                        notEmpty: {
                            message: '收件人不能为空！'
                        }
                    }
                },
            phone: {
                validators: {
                    regexp: {
                        regexp: /^1[34578][0-9]{9}$/,
                        message: '联系人手机号码格式不正确'
                    },
                    notEmpty: {
                            message: '手机号不能为空！'
                        }
                    }

                },

            store_id: {
                validators: {
                    notEmpty: {
                            message: '请选择店铺！'
                        }
                    }
                },

            type: {
                validators: {
                    notEmpty: {
                        message: '请选择会员性质！'
                    }
                }
            },

            from_to: {
                validators: {
                    notEmpty: {
                        message: '请选择会员来源！'
                    }
                }
            },
            province_id: {
                validators: {
                    notEmpty: {
                        message: '请选择省份！'
                    }
                }
            },
            district_id: {
                validators: {
                    notEmpty: {
                        message: '请选择城市！'
                    }
                }
            },
            buyer_address: {
                validators: {
                    notEmpty: {
                        message: '请填写详细地址！'
                    }
                }
            },
        }

    });

    $("#province_id").change(function () {
        var oid = $(this)[0].options[$(this)[0].selectedIndex].value;

        new kingfisher.provinceList(oid);
    });

    $("#city_id").change(function () {
        var oid = $(this)[0].options[$(this)[0].selectedIndex].value;
        new kingfisher.cityList(oid);
    });
@endsection