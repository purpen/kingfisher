@extends('home.base')

@section('customize_css')
    @parent
    .bnonef{
    padding:0;
    box-shadow:none !important;
    background:none;
    color:#fff !important;
    }
    #form-user,#form-product,#form-jyi,#form-beiz {
    height: 225px;
    overflow: scroll;
    }
    .scrollspy{
    height:180px;
    overflow: scroll;
    margin-top: 10px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        发货人设置
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    @include('block.errors')
                    <ul class="nav navbar-nav nav-list">
                        <ul class="nav navbar-nav nav-list">
                            <li><a href="{{url('/logistics')}}">物流设置</a></li>
                            <li><a href="{{url('/logistics/go')}}">物流配送</a></li>
                            <li class="active"><a href="{{url('/consignor')}}">发货人列表</a></li>
                        </ul>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="" method="POST">
                                <div class="form-group">
                                    <input type="text" name="where" class="form-control">
                                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                                </div>
                                <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mainwrap">
        <div class="row fz-0">
            <button type="button" class="btn btn-white mr-2r" data-toggle="modal" data-target="#addConsignor">
                <i class="glyphicon glyphicon-user"></i> 添加发货人
            </button>
            <button class="btn btn-gray" type="button" id="delete-consignor">
                <i class="glyphicon glyphicon-trash"></i> 删除
            </button>
        </div>
        
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="active">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>发货仓库</th>
                        <th>发货人</th>
                        <th>始发地</th>
                        <th>发货人手机</th>
                        <th>发货地址</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($consignors as $consignor)
                    <tr>
                        <td class="text-center">
                            <input name="Order" class="sku-order" type="checkbox" active="0" value="{{ $consignor->id }}">
                        </td>
                        <td>{{ $consignor->storage->name }}</td>
                        <td>{{ $consignor->name }}</td>
                        <td>{{ $consignor->origin_city }}</td>
                        <td>{{ $consignor->phone }}</td>
                        <td>{{ $consignor->address }}</td>
                        <td>
                            <button class="btn btn-gray btn-sm mr-2r show-order" type="button" value="{{$consignor->id}}" active="1" id="update-consignor"><i class="glyphicon glyphicon-edit"></i> 编辑</button>
                            <button class="btn btn-gray btn-sm mr-2r show-order" type="button" value="{{$consignor->id}}" active="1" id="delete-consignor"><i class="glyphicon glyphicon-trash"></i> 删除</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--添加发货人--}}
        <div class="modal fade" id="addConsignor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">添加发货人</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="addConsignorForm" role="form" method="POST" action="{{ url('/consignor/store') }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="storage_id" class="col-sm-2 control-label">指定仓库</label>
                                <div class="col-sm-4">
                                    <select class="selectpicker" id="storage_id" name="storage_id">
                                        @foreach($storage_list as $storage)
                                        <option value="{{$storage->id}}">{{$storage->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="name" class="col-sm-2 control-label">发货人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="发货人">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="origin_city" class="col-sm-2 control-label">始发地</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="origin_city" name="origin_city" placeholder="始发地">
                                </div>
                                <label for="tel" class="col-sm-2 control-label">电话</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="tel" name="tel" placeholder="联系电话">
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">手机</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="手机">
                                </div>
                                <label for="zip" class="col-sm-2 control-label">邮编</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="province_id" class="col-sm-2 control-label">省份</label>
                                <div class="col-sm-4">
                                    <select class="selectpicker" id="province_id" name="province_id">
                                        @foreach($china_city as $v)
                                            <option class="province" value="{{$v->oid}}">{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="district_id" class="col-sm-2 control-label">城市</label>
                                <div class="col-sm-4">
                                    <select class="selectpicker" id="district_id" name="district_id"></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label">详细地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="address" name="address" placeholder="详细地址">
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="modal-footer pb-r">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button id="submit_supplier" type="submit" class="btn btn-magenta">确认提交</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{--更新发货人--}}
        <div class="modal fade" id="updateConsignor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">编辑发货人</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="updateConsignorForm" role="form" method="POST" action="{{ url('/consignor/edit') }}">
                            {!! csrf_field() !!}
                            <input type="text" id="consignor_id" name="consignor_id" hidden>
                            <div class="form-group">
                                <label for="storage_id" class="col-sm-2 control-label">仓库</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="storage_id1" disabled>
                                </div>
                                <label for="name" class="col-sm-2 control-label">发货人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="name1" name="name" placeholder="发货人">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="origin_city" class="col-sm-2 control-label">始发地</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="origin_city1" name="origin_city" placeholder="始发地">
                                </div>
                                <label for="tel" class="col-sm-2 control-label">电话</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="tel1" name="tel" placeholder="联系电话">
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">手机</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="phone1" name="phone" placeholder="手机">
                                </div>
                                <label for="zip" class="col-sm-2 control-label">邮编</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="zip1" name="zip" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="province_id" class="col-sm-2 control-label">省份</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="province_id1" disabled>
                                </div>
                                <label for="district_id" class="col-sm-2 control-label">城市</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="district_id1" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label">详细地址</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="address1" name="address" placeholder="详细地址">
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="modal-footer pb-r">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button id="submit_supplier" type="submit" class="btn btn-magenta">确认更新</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('customize_js')
    @parent
    {{--添加表单验证--}}
    $("#addConsignorForm").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            storage_id: {
                validators: {
                    notEmpty: {
                        message: '请选择仓库！'
                    },
                }
            },

            name: {
                validators: {
                    notEmpty: {
                        message: '发货人不能为空！'
                    },
                    stringLength: {
                        min:1,
                        max:20,
                        message: '发货人不能超过20字符'
                    }
                }
            },
            origin_city: {
                validators: {
                    notEmpty: {
                        message: '始发地不能为空！'
                    },
                    stringLength: {
                        min:1,
                        max:20,
                        message: '始发地1-15字符之间！'
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
            phone: {
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
            zip: {
                validators: {
                    stringLength: {
                        min:1,
                        max:20,
                        message: '邮编长度1-50字之间！'
                    }
                }
            },
            province_id: {
                validators: {
                    notEmpty: {
                        message: '省份不能为空！'
                    }
                }
            },
            district_id: {
                validators: {
                    notEmpty: {
                        message: '城市不能为空！'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: '详细地址不能为空！'
                    },
                    stringLength: {
                        min:1,
                        max:500,
                        message: '长度1-500字之间！'
                    }
                }
            }
        }
    });

    var _token = $("#_token").val();

    $("#delete-consignor").click(function() {
        if(confirm('确认删除?')){
            var id = $(this).attr('value');
            var obj = $(this);
            $.post('{{url('/consignor/ajaxDestroy')}}',{'_token':_token,'id':id},function (e) {
                if(e.status){
                    obj.parent().parent().remove();
                }
            },'json');
        }

    });
    
    $("#update-consignor").click(function() {
        var id = $(this).attr('value');
        var obj = $(this);
        $.get('{{url('/consignor/ajaxShow')}}',{'id':id},function (e) {
            if(e.status){
                $("#consignor_id").val(e.data.id);
                $("#storage_id1").val(e.data.storage_name);
                $("#name1").val(e.data.name);
                $("#origin_city1").val(e.data.origin_city);
                $("#tel1").val(e.data.tel);
                $("#phone1").val(e.data.phone);
                $("#zip1").val(e.data.zip);
                $("#province_id1").val(e.data.province_name);
                $("#district_id1").val(e.data.city_name);
                $("#address1").val(e.data.address);

                $("#updateConsignor").modal('show');
            }
        },'json');
    });

    $("#province_id").change(function() {
        var oid = $(this)[0].options[$(this)[0].selectedIndex].value;

        $.get('{{url('/ajaxFetchCity')}}',{'oid':oid,'layer':2},function (e) {
            if(e.status){
                var template = '@{{ #data }}<option class="province" value="@{{oid}}">@{{name}}</option>@{{ /data }}';
                var views = Mustache.render(template, e);
                
                $("#district_id")
                    .html(views)
                    .selectpicker('refresh');
            }
        },'json');

    });
@endsection