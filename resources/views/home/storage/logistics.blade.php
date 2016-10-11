@extends('home.base')

@section('title', '物流')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        物流
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="#">物流设置</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container mainwrap">
            <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong id="showtext"></strong>
            </div>

            <div class="row">
                <button type="button" class="btn btn-white" data-toggle="modal" data-target="#addlog">添加物流公司</button>
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
                            <form id="add-logistics" method="post" action="{{ url("/logistics/store") }}">
                                <div class="row">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">快递名称:</div>
                                            <div class="form-group">
                                                <input type="text" name="name" ordertype="discountFee" class="form-control float" id="name" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">所在地区:</div>
                                            <div class="form-group mb-0">
                                                <input type="text" name="area" ordertype="discountFee" class="form-control float" id="area" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">快递代码:</div>
                                            <div class="form-group">
                                                <input type="text" name="logistics_id" ordertype="discountFee" class="form-control float" id="logistics_id" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group mr-3r">联系人:</div>
                                            <div class="form-group">
                                                <input type="text" id="contact_user" name="contact_user" ordertype="discountFee" class="form-control float" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">联系方式:</div>
                                            <div class="form-group">
                                                <input type="text" name="contact_number" ordertype="discountFee" class="form-control float" id="contact_number" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group mr-r pl-3r">备注：</div>
                                            <div class="form-group">
                                                <input type="text" name="summary" ordertype="discountFee" class="form-control float" id="summary" placeholder=" " style="width: 475px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button id="submit_supplier" type="button" class="btn btn-magenta">保存</button>
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
                            <form id="add-logistics" method="post" }}">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" id="logistic_id" >
                                <div class="row">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">快递名称：</div>
                                            <div class="form-group">
                                                <input type="text" name="name" ordertype="discountFee" class="form-control float" id="name1" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">所在地区：</div>
                                            <div class="form-group mb-0">
                                                <input class="form-control" id="area1" type="text" placeholder="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6 lh-34">
                                    <div class="form-inline">
                                        <div class="form-group mr-3r">快递代码：</div>
                                        <div class="form-group">
                                            <input type="text" id="logistics_id1" name="logistics_id" ordertype="discountFee" class="form-control float" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group mr-3r">联系人：</div>
                                            <div class="form-group">
                                                <input type="text" id="contact_user1" name="contact_user" ordertype="discountFee" class="form-control float" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">联系方式：</div>
                                            <div class="form-group">
                                                <input type="text" name="contact_number1" ordertype="discountFee" class="form-control float" id="contact_number1" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group mr-3r pl-3r">备注：</div>
                                            <div class="form-group">
                                                <input type="text" name="summary1" ordertype="discountFee" class="form-control float" id="summary1" placeholder=" " style="width: 475px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button id="update_logistic" type="button" class="btn btn-magenta">保存</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th>设为默认发货物流</th>
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
                                    <input type="checkbox">
                                    <div class="btn btn-gray btn-xs">默认</div>
                                </label>
                            </div>
                        </td>
                        <td>{{ $logistic->name }}</td>
                        <td>{{ $logistic->logistics_id }}</td>
                        <td>{{ $logistic->contact_user }}</td>
                        <td>{{ $logistic->contact_number }}</td>
                        <td>
                            <button class="btn btn-gray btn-sm mr-2r" type="button" id="change_status" onclick="changeStatus({{ $logistic->id }})">{{ $logistic->status }}</button>
                            <a href="javascript:void(0);" class="magenta-color" onclick="update_logistic({{ $logistic->id }});">修改</a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>

        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection

@section('customize_js');
@parent
{{--<script>--}}
    var _token = $("#_token").val();
    {{--关闭警告框--}}
    $(".close").click(function () {
        $('#warning').hide();
    });
    {{--添加物流--}}
    $("#submit_supplier").click(function () {
        var name = $("#name").val();
        var area = $("#area").val();
        var contact_user = $("#contact_user").val();
        var contact_number = $("#contact_number").val();
        var summary = $("#summary").val();
        var logistics_id = $("#logistics_id").val();
        $.ajax({
            type: 'post',
            url: '/logistics/store',
            data: {"_token": _token, "name": name,"logistics_id": logistics_id, "area": area,"contact_user":contact_user,"contact_number":contact_number,"summary":summary},
            dataType: 'json',
            success: function(data){
                $('#addlog').modal('hide');
                if (data.status == 1){
                    location.reload();
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error: function(data){
                $('#addlog').modal('hide');
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
            data: {"_token": _token, "name": name,"logistics_id": logistics_id, "contact_user":contact_user, "contact_number":contact_number,"summary":summary,"id":id},
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

    function changeStatus(id) {
        $.post('/logistics/status',{"_token":_token,"id":id},function(e) {
            if(e.status == 1){
                location.reload();
            }
        },"json");
    }
@endsection