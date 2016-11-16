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
						创建会员
					</div>
				</div>

			</div>
		</div>
        
        <div class="container mainwrap">
            @include('block.form-errors')
            <div class="row formwrapper">
                <div class="col-md-12">
                    <form id="add-order" role="form" method="post" class="form-horizontal" action="{{ url('/orderUser/store') }}">
                        
                        <h5>会员信息</h5>
                        <hr>

                        <div class="form-group">
                            <label for="username" class="col-sm-1 control-label">收货人<em>*</em></label>
                            <div class="col-sm-2">
                                <input type="text" name="username" class="form-control">
                            </div>

                            <label for="phone" class="col-sm-1 control-label">手机号<em>*</em></label>
                            <div class="col-sm-2">
                                <input type="text" name="phone" class="form-control">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="store_id" class="col-sm-1 control-label">店铺名称<em>*</em></label>
                            <div class="col-sm-2">
                                <select class="selectpicker" id="store_id" name="store_id" style="display: none;">
                                    <option value="">选择店铺</option>
                                    @foreach($store_list as $store)
                                        <option value="{{$store->id}}">{{$store->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="type" class="col-sm-1 control-label">会员性质<em>*</em></label>
                            <div class="col-sm-3">
                                <select class="selectpicker" id="type" name="type" style="display: none;">
                                    <option value="">选择订单</option>
                                    <option value='1'>普通订单</option>
                                    <option value='2'>渠道订单</option>
                                </select>
                            </div>

                            <label for="from_to" class="col-sm-1 control-label">会员来源<em>*</em></label>
                            <div class="col-sm-3">
                                <select class="selectpicker" id="from_to" name="from_to" style="display: none;">
                                    <option value="">选择来源</option>
                                    <option value='1'>自营</option>
                                    <option value='2'>京东</option>
                                    <option value='3'>淘宝</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="account" class="col-sm-1 control-label">账户</label>
                            <div class="col-sm-2">
                                <input type="text" name="account" class="form-control">
                            </div>

                            <label for="email" class="col-sm-1 control-label">邮箱</label>
                            <div class="col-sm-2">
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="qq" class="col-sm-1 control-label">QQ</label>
                            <div class="col-sm-2">
                                <input type="text" name="qq" class="form-control">
                            </div>

                            <label for="ww" class="col-sm-1 control-label">旺旺</label>
                            <div class="col-sm-2">
                                <input type="text" name="ww" class="form-control">
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
                                        <input name="sex" value="0" type="radio" id="orderUserSex0"> 女
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="province_id" class="col-sm-1 control-label">省份<em>*</em></label>
                            <div class="col-sm-1">
                                <select class="selectpicker" id="province_id" name="province_id">
                                    @foreach($china_city as $v)
                                        <option class="province" value="{{$v->oid}}">{{$v->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="district_id" class="col-sm-1 control-label">城市<em>*</em></label>
                            <div class="col-sm-1">
                                <select class="selectpicker" id="city_id" name="city_id"></select>
                            </div>
                            <label for="county_id" class="col-sm-2 control-label">区/县</label>
                            <div class="col-sm-1">
                                <select class="selectpicker" id="county_id" name="county_id"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="buyer_address" class="col-sm-1 control-label">详细地址<em>*</em></label>
                            <div class="col-sm-6">
                                <input type="text" name="buyer_address" class="form-control">
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

    $("#province_id").change(function() {
        var oid = $(this)[0].options[$(this)[0].selectedIndex].value;

        $.get('{{url('/ajaxFetchCity')}}',{'oid':oid,'layer':2},function (e) {
            if(e.status){
                var template = '@{{ #data }}<option class="province" value="@{{oid}}">@{{name}}</option>@{{ /data }}';
                var views = Mustache.render(template, e);

                $("#city_id")
                        .html(views)
                        .selectpicker('refresh');
            }
        },'json');

    });

    $("#city_id").change(function() {
        var oid = $(this)[0].options[$(this)[0].selectedIndex].value;

        $.get('{{url('/ajaxFetchCity')}}',{'oid':oid,'layer':3},function (e) {
            if(e.status){
                var template = '@{{ #data }}<option class="province" value="@{{oid}}">@{{name}}</option>@{{ /data }}';
                var views = Mustache.render(template, e);

                $("#county_id")
                        .html(views)
                        .selectpicker('refresh');
            }
        },'json');

    });
@endsection