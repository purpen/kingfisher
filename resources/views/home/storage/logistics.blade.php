@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    物流管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li class="active"><a href="{{url('/logistics')}}">物流设置</a></li>
                    <li><a href="{{url('/logistics/go')}}">物流配送</a></li>
                    <li><a href="{{url('/consignor')}}">发货人列表</a></li>
                </ul>
            </div>
        </div>

        <div class="container mainwrap">
            @include('block.errors')

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-white mr-2r" data-toggle="modal" data-target="#addlog">
                        <i class="glyphicon glyphicon-plane"></i> 添加物流公司
                    </button>
                    <button class="btn btn-danger mr-2r" type="button" id="delete-logistics">
                        <i class="glyphicon glyphicon-trash"></i> 删除
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th>设为默认</th>
                            <th>物流公司</th>
                            <th>快递代码</th>
                            <th>联系人</th>
                            <th>联系方式</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logistics as $logistic)
                        <tr>
                            <td>
                                <div class="checkbox mtb-0">
                                    <label>
                                        <input type="checkbox" name="logistics" value="{{$logistic->id}}">
                                        {{--<button class="btn btn-gray btn-sm">
                                            <i class="glyphicon glyphicon-flag"></i> 默认
                                        </button>--}}
                                    </label>
                                </div>
                            </td>
                            <td>{{ $logistic->name }}</td>
                            <td>{{ $logistic->logistics_id }}</td>
                            <td>{{ $logistic->contact_user }}</td>
                            <td>{{ $logistic->contact_number }}</td>
                            <td>
                                <button type="button" class="btn btn-default btn-sm mr-2r" onclick="update_logistic({{ $logistic->id }});">
                                    <i class="glyphicon glyphicon-edit"></i> 修改
                                </button>
                                @if($logistic->status)
                                <button class="btn btn-warning btn-sm" type="button" id="change_status" onclick="changeStatus({{ $logistic->id }})">
                                    <i class="glyphicon glyphicon-off"></i> {{ $logistic->status_val }}
                                </button>
                                @else
                                <button class="btn btn-success btn-sm" type="button" id="change_status" onclick="changeStatus({{ $logistic->id }})">
                                    <i class="glyphicon glyphicon-off"></i> {{ $logistic->status_val }}
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            
            {{--  弹出框 --}}
            <div class="modal fade" id="addlog" tabindex="-1" role="dialog" aria-labelledby="addlogLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">物流公司信息</h4>
                        </div>
                        <div class="modal-body">
                            <form id="add-logistics" class="form-horizontal" method="post" action="{{ url("/logistics/store") }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">快递名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="name" class="form-control" id="name">
                                    </div>
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                    <label for="logistics_id" class="col-sm-2 control-label">所属公司</label>
                                    <div class="col-sm-4">
                                       <select class="selectpicker" id="logistics_id" name="logistics_id">
                                           @foreach($logistics_id as $k => $v)
                                               <option value="{{ $k }}">{{ $k }}</option>
                                           @endforeach
                                       </select>
                                    </div>
                                    @if ($errors->has('logistics_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logistics_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact_user" class="col-sm-2 control-label">联系人</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="contact_user" name="contact_user" ordertype="discountFee" class="form-control">
                                    </div>
                                    @if ($errors->has('contact_user'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_user') }}</strong>
                                    </span>
                                    @endif
                                    <label for="contact_number" class="col-sm-2 control-label">联系方式</label>
                                    <div class="col-sm-4">
                                       <input type="text" name="contact_number" class="form-control" id="contact_number" placeholder="手机号、电话号码">
                                    </div>
                                    @if ($errors->has('contact_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label for="summary" class="col-sm-2 control-label">备注说明</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="summary" class="form-control" id="summary">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                    <button type="submit" class="btn btn-magenta">确认提交</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>

            {{--  修改弹出框 --}}
            <div class="modal fade" id="updatelog" tabindex="-1" role="dialog" aria-labelledby="addlogLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">物流公司信息</h4>
                        </div>
                        <div class="modal-body">
                            <form id="add-logistics" class="form-horizontal" method="post">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" id="logistic_id" >
                                
                                
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">快递名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="name" class="form-control" id="name1">
                                    </div>
                                    
                                    <label for="logistics_id" class="col-sm-2 control-label">所属公司</label>
                                    <div class="col-sm-4">
                                       <input class="form-control" id="area1" type="text" disabled>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact_user" class="col-sm-2 control-label">联系人</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="contact_user1" name="contact_user" ordertype="discountFee" class="form-control">
                                    </div>
                                    
                                    <label for="contact_number" class="col-sm-2 control-label">联系方式</label>
                                    <div class="col-sm-4">
                                       <input type="text" name="contact_number" class="form-control" id="contact_number1" placeholder="手机号、电话号码">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="summary" class="col-sm-2 control-label">备注说明</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="summary" class="form-control" id="summary1">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button id="update_logistic" type="button" class="btn btn-magenta">确认更新</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection

@section('customize_js');
    @parent
    var _token = $("#_token").val();
    $("#add-logistics").formValidation({
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
                        message: '快递名称不能为空！'
                    }
                }
            },

            logistics_id: {
                validators: {
                    notEmpty: {
                        message: '请选择公司！'
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
                        message: '联系方式不能为空！'
                    }
                }
            }
        }
    });

    {{--添加物流--}}
    {{--$("#submit_supplier").click(function () {--}}
        {{--var name = $("#name").val();--}}
        {{--var contact_user = $("#contact_user").val();--}}
        {{--var contact_number = $("#contact_number").val();--}}
        {{--var summary = $("#summary").val();--}}
        {{--var logistics_id = $("#logistics_id").val();--}}
        {{--$.ajax({--}}
            {{--type: 'post',--}}
            {{--url: '/logistics/store',--}}
            {{--data: {"_token": _token, "name": name,"logistics_id": logistics_id, "contact_user":contact_user,"contact_number":contact_number,"summary":summary},--}}
            {{--dataType: 'json',--}}
            {{--success: function(data){--}}
                {{--$('#addlog').modal('hide');--}}
                {{--if (data.status == 1) {--}}
                    {{--location.reload();--}}
                {{--}--}}
                {{--if (data.status == 0) {--}}
                    {{--$('#showtext').html(data.message);--}}
                    {{--$('#warning').show().delay(4000).hide(0);--}}
                {{--}--}}
            {{--},--}}
            {{--error: function(data){--}}
                {{--$('#addlog').modal('hide');--}}
                {{--var messages = eval("("+data.responseText+")");--}}
                {{--for(i in messages){--}}
                    {{--var message = messages[i][0];--}}
                    {{--break;--}}
                {{--}--}}
                {{--$('#showtext').html(message);--}}
                {{--$('#warning').show().delay(4000).hide(0);--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}
    
    {{--展示物流信息--}}
    function update_logistic(id) {
        $.get('/logistics/edit',{'id':id},function (e) {
            $("#logistic_id").val(e.data.id);
            $('#name1').val(e.data.name);
            $('#area1').attr("placeholder",e.data.area);
            $('#logistics_id1').val(e.data.logistics_id);
            $('#contact_user1').val(e.data.contact_user);
            $('#contact_number1').val(e.data.contact_number);
            $('#summary1').val(e.data.summary);
            $('#updatelog').modal('show');
        },'json');
    }
    


    function changeStatus(id) {
        $.post('/logistics/status', {"_token":_token,"id":id},function(e) {
            if (e.status == 1) {
                location.reload();
            }else{
                alert(e.message);
            }
        },"json");
    }

@endsection

@section('load_private');
    @parent
{{--更改物流信息--}}
$('#update_logistic').click(function(){
    var id = $('#logistic_id').val();
    var name = $('#name1').val();
    var contact_user = $('#contact_user1').val();
    var contact_number = $('#contact_number1').val();
    var summary = $('#summary1').val();
    var logistics_id = $("#logistics_id1").val();
    $.ajax({
        type: 'post',
        url: '/logistics/update',
        data: {"_token": _token, "name": name, "contact_user":contact_user, "contact_number":contact_number, "summary":summary, "id":id},
        dataType: 'json',
        success: function(data){
            $('#updatelog').modal('hide');
            if (data.status == 1){
                location.reload();
            }
            if (data.status == 0){
                $('#showtext').html(data.message);
                $('#warning').show();
            }
        },
        error: function(data){
            $('#updatelog').modal('hide');
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

{{--物流删除--}}
$("#delete-logistics").click(function () {
    if(confirm('确认删除此物流？')){
        var id = '';
        $("input[name='logistics']").each(function () {
            if($(this).is(':checked')){
                id = $(this).attr('value');
                var dom = $(this);
                $.post('{{url('/logistics/destroy')}}',{'_token': _token,'id': id}, function (e) {
                    if(e.status){
                        dom.parent().parent().parent().parent().remove();
                    }else{
                        alert(e.message);
                    }
                },'json');
            }
        });
    }
});
@endsection