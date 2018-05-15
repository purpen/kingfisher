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
			<div class="navbar-header">
				<div class="navbar-brand">
					新增客户
				</div>
			</div>
		</div>
        
        <div class="container mainwrap">
            @if (session('error_message'))
                <div class="col-sm-10 col-sm-offset-2 error_message">
                    <p class="text-danger">{{ session('error_message') }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="formwrapper">
                        <form id="add-order" role="form" method="post" class="form-horizontal" action="{{ url('/orderUser/store') }}">

                            <h5>客户信息</h5>
                            <hr>

                            <div class="form-group">
                                <label for="store_id" class="col-sm-1 control-label">相关店铺<em>*</em></label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <select class="selectpicker" id="store_id" name="store_id">
                                            <option value="">选择店铺</option>
                                            @foreach($store_list as $store)
                                                <option value="{{$store->id}}">{{$store->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <label for="type" class="col-sm-1 control-label">客户性质<em>*</em></label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <select class="selectpicker" id="type" name="type">
                                            <option value="">选择订单</option>
                                            <option value='1'>普通订单</option>
                                            <option value='2'>渠道订单</option>
                                            <option value='3'>电商订单</option>
                                            <option value='4'>海外订单</option>
                                        </select>
                                    </div>
                                </div>

                                <label for="from_to" class="col-sm-1 control-label">客户来源<em>*</em></label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <select class="selectpicker" id="from_to" name="from_to">
                                            <option value="">选择来源</option>
                                            <option value='1'>淘宝</option>
                                            <option value='2'>京东</option>
                                            <option value='3'>自营平台</option>
                                            <option value='4'>自主开发</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <h5>联系方式</h5>
                            <hr>
                            
                            <div class="form-group">

                                <label for="username" class="col-sm-1 control-label">客户名称<em>*</em></label>
                                <div class="col-sm-2">
                                    <input type="text" name="username" class="form-control">
                                </div>

                                <label for="phone" class="col-sm-1 control-label">手机号<em>*</em></label>
                                <div class="col-sm-2">
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                <label for="province_id" class="col-sm-1 control-label">省份<em>*</em></label>
                                <div class="col-sm-1">
                                    <div class="input-group">
                                        <select class="selectpicker" id="province_id" name="province_id">
                                            @foreach($china_city as $v)
                                                <option class="province" value="{{$v->name}}" oid="{{$v->oid}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <label for="district_id" class="col-sm-1 control-label">城市<em>*</em></label>
                                <div class="col-sm-1">
                                    <div class="input-group">
                                        <select class="selectpicker" id="city_id" name="city_id"></select>
                                    </div>
                                </div>
                                <label for="county_id" class="col-sm-2 control-label">区/县</label>
                                <div class="col-sm-1">
                                    <div class="input-group">
                                        <select class="selectpicker" id="county_id" name="county_id"></select>
                                    </div>
                                </div>
                                <label for="township_id" class="col-sm-2 control-label">镇</label>
                                <div class="col-sm-1">
                                    <div class="input-group">
                                        <select class="selectpicker" id="township_id" name="township_id"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="buyer_address" class="col-sm-1 control-label">详细地址<em>*</em></label>
                                <div class="col-sm-7">
                                    <input type="text" name="buyer_address" class="form-control">
                                </div>

                                <label for="buyer_address" class="col-sm-1 control-label">邮编</label>
                                <div class="col-sm-2">
                                    <input type="text" name="zip" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                
                                <label for="email" class="col-sm-1 control-label">邮箱</label>
                                <div class="col-sm-2">
                                    <input type="text" name="email" class="form-control">
                                </div>
                                
                                <label for="tel" class="col-sm-1 control-label">电话</label>
                                <div class="col-sm-2">
                                    <input type="text" name="tel" class="form-control">
                                </div>
                                
                                <label for="account" class="col-sm-1 control-label">帐号</label>
                                <div class="col-sm-2">
                                    <input type="text" name="account" class="form-control">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="sex" class="col-sm-1 control-label">性别</label>
                                <div class="col-sm-2">
                                    <div class="radio-inline">
                                        <label class="mr-3r">
                                            <input name="sex" value="1" type="radio" id="orderUserSex1"> 男
                                        </label>
                                        <label class="ml-3r">
                                            <input name="sex" value="0" type="radio" id="orderUserSex0" checked> 女
                                        </label>
                                    </div>
                                </div>
                                
                                <label for="qq" class="col-sm-1 control-label">QQ</label>
                                <div class="col-sm-2">
                                    <input type="text" name="qq" class="form-control">
                                </div>

                                <label for="ww" class="col-sm-1 control-label">旺旺</label>
                                <div class="col-sm-2">
                                    <input type="text" name="ww" class="form-control">
                                </div>
                            </div>
                            


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
            zip: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]{6}$/,
                        message: '邮编格式不正确'
                    }
                }
            }
        }

    });


@endsection


@section('load_private')
    @parent
    {{--地区联动菜单--}}
    $("#province_id").change(function () {
        var oid = $($(this)[0].options[$(this)[0].selectedIndex]).attr('oid');
        new kingfisher.provinceList(oid);
    });
    $(kingfisher.provinceList(1));
    $("#city_id").change(function () {
        var oid = $($(this)[0].options[$(this)[0].selectedIndex]).attr('oid');
        new kingfisher.cityList(oid);
    });
    $("#county_id").change(function () {
        var oid = $($(this)[0].options[$(this)[0].selectedIndex]).attr('oid');
        new kingfisher.countyList(oid);
    });
@endsection