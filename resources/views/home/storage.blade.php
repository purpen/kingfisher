 @extends('home.base')

@section('title', '仓储')

@section('customize_css')
    @parent
    #erp_storage {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    }
    #erp_storageRacks {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    }
@endsection
@section('content')
    @parent
    <div class = 'container-fluid'>
        <div id="warning" class="alert alert-danger" role="alert" style="display: none">
            <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong id="showtext"></strong>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="radio-inline">
                    <input type="radio" name="storageRadio1" id="inlineRadio1" checked  value="1"> 全部
                </label>
                <label class="radio-inline">
                    <input type="radio" name="storageRadio1" id="inlineRadio2" value="0"> 禁用
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <h5 style="padding: 0px 20px; line-height: 30px;">
                   <strong>仓库</strong>
                    <span class="pull-right">
                        <button class="btn btn-default" id="storage" data-toggle="modal" data-target="#storageModal" type="button">添加仓库</button>
                    </span>
                </h5>
                <div id="erp_storages"></div>
            </div>

            <div class="col-sm-3">
                <h5 style="padding: 0px 20px; line-height: 30px;">
                    <strong>仓区</strong>
                    <span class="pull-right">
                        <button class="btn btn-default" id="storageRack" type="button" data-toggle="modal" data-target="#storageRackModal">添加仓区</button>
                    </span>
                </h5>
                <div id="erp_storageRacks">
                </div>
            </div>
            <div class="col-sm-3">
                <h5 style="padding: 0px 20px; line-height: 30px;">
                    <strong>仓位</strong>
                    <span class="pull-right">
                        <button class="btn btn-default" type="button">添加仓位</button>
                    </span>
                </h5>
                <div id="erp_storage">
                    <div class="list-group">
                        <a href="" class="list-group-item">
                            <h5 class="list-group-item-heading">默认仓库
                                <i class="glyphicon"> (空闲)</i>
                                <span class="pull-right">
                                <button class="btn btn-default btn-xs" type="button">删除</button>
                                <button class="btn btn-default btn-xs" type="button">信息</button>
                                </span>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加仓库拟态弹窗 -->
    <div class="modal fade" id="storageModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        新增仓库
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <label class="radio-inline">
                            <input type="radio" name="storageRadio2" id="inlineRadio3" checked  value="1"> 自建仓库
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="storageRadio2" id="inlineRadio4" value="2"> 奇门仓库
                        </label>
                        <div class="form-group">
                            <input type="hidden" id="storage-id">
                            <label class="col-xs-2">仓库名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-2">仓库简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storage-content"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">初始化库存
                    </button>
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button id="storage-submit" type="button" class="btn btn-primary">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <!-- 更新仓库拟态弹窗 -->
    <div class="modal fade" id="storageModalUp" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        仓库信息
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="hidden" id="storage-id-up">
                            <label class="col-xs-2">仓库名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-name-up">
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label class="col-xs-2">仓库状态</label>--}}
                            {{--<div class="col-xs-9">--}}
                                {{--<input class="form-control" id="storage-number">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="" class="col-xs-2">仓库简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storage-content-up"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button id="storage-update" type="button" class="btn btn-primary">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <!-- 添加仓区拟态弹窗 -->
    <div class="modal fade" id="storageRackModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        新增仓区
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input type="hidden" id="storageRack-storageId">
                        <div class="form-group">
                            <label class="col-xs-2">仓区名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storageRack-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-2">仓区简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storageRack-content"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button id="storageRack-submit" type="button" class="btn btn-primary">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <!-- 更新仓区拟态弹窗 -->
    <div class="modal fade" id="storageRackModalUp" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        仓区信息
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input type="hidden" id="storageRack-id-up">
                        <div class="form-group">
                            <label class="col-xs-2">仓区名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storageRack-name-up">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-2">仓区简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storageRack-content-up"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button id="storageRack-update" type="button" class="btn btn-primary">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">


@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    var _token = $('#_token').val();

    $('#storage-submit').click(function(){
        var type = $("input[name='storageRadio2']:checked").val();
        var name = $('#storage-name').val();
        var content = $('#storage-content').val();
    $.ajax({
            type: 'post',
            url: '/storage/add',
            data: {"_token": _token, "name": name, "content": content,"type":type},
            dataType: 'json',
            success: function(data){
                $('#storageModal').modal('hide');
                if (data.status == 1){
                    storageList();
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error: function(data){
                $('#storageModal').modal('hide');
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

    $(".close").click(function () {
        $('#warning').hide();
    });

    $(function () {
        storageList();
    });

    function storageList(status) {
        $.get('/storage/storageList',{"status":status},function (e) {
            var template = ['<div id="erp_storage">',
                '                    <div class="list-group">',
                '                        @{{#data}} <a href="javascript:void(0)" class="list-group-item" onclick="storageRackList(@{{id}})">',
                '                            <h5 class="list-group-item-heading">@{{name}}',
                '                                <i class="glyphicon">  【@{{status}}】</i>',
                '                                <span class="pull-right">',
                '                                <button id="destroy-storage" class="btn btn-default btn-xs destroy-storage" value="" onclick="destroyStorage(@{{id}});" type="button">删除</button>',
                '                                <button id="edit-storage" class="btn btn-default btn-xs edit-storage" value="" onclick="editStorage(@{{id}});" type="button">信息</button>',
                '                                </span>',
                '                            </h5>',
                '                        </a>@{{/data}}',
                '                    </div>',
                '                </div>'].join("");
            var views = Mustache.render(template, e);
            $('#erp_storages').html(views);

        },'json');
    }

    function destroyStorage (id) {
        if(confirm('确认删除仓库吗？')){
            var type = $("input[name='storageRadio1']:checked").val();
            $.get('/storage/destroy',{"id":id},function (e) {
            if(e.status == 1){
            storageList(type);
            }else{
            $('#showtext').html(e.message);
            $('#warning').show();
            }
            },'json');
        }

    }
    function editStorage(id) {
        $.get('/storage/edit',{'id':id},function (e) {
            $('#storage-name-up').val(e.data.name);
            $('#storage-content-up').val(e.data.content);
            $('#storage-id-up').val(e.data.id);
            $('#storageModalUp').modal('show');
        },'json');
    }

    $('#storage-update').click(function(){
        var id = $('#storage-id-up').val();
        var name = $('#storage-name-up').val();
        var content = $('#storage-content-up').val();
        $.ajax({
            type: 'post',
            url: '/storage/edit',
            data: {"_token": _token, "name": name, "content": content,"id":id},
            dataType: 'json',
            success: function(data){
                $('#storageModalUp').modal('hide');
                if (data.status == 1){
                    storageList();
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error: function(data){
                $('#storageModalUp').modal('hide');
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

    $('#storageRack-submit').click(function () {
        var storage_id = $('#storageRack-storageId').val();
        var name = $('#storageRack-name').val();
        var content = $('#storageRack-content').val();
        $.ajax({
            type: 'post',
            url: '/storageRack/add',
            data: {"_token": _token, "name": name, "content": content,"storage_id":storage_id},
            dataType: 'json',
            success: function(data){
                $('#storageRackModal').modal('hide');
                if (data.status == 1){
                    storageRackList(storage_id);
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error: function(data){
                $('#storageRackModal').modal('hide');
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

    function storageRackList(storage_id){
        $('#storageRack-storageId').val(storage_id);
        $.get('/storageRack/list',{"storage_id":storage_id},function (e) {
            var template = ['                    <div class="list-group">',
                '                        @{{#data}} <a href="javascript:void(0)" class="list-group-item" onclick="(@{{id}})">',
                '                            <h5 class="list-group-item-heading">@{{name}}',
                '                                <span class="pull-right">',
                '                                <button id="destroy-storageRack" class="btn btn-default btn-xs destroy-storageRack" value="" onclick="destroyStorageRack(@{{id}},@{{storage_id}});" type="button">删除</button>',
                '                                <button id="edit-storageRack" class="btn btn-default btn-xs edit-storageRack" value="" onclick="editStorageRack(@{{id}},@{{storage_id}});" type="button">信息</button>',
                '                                </span>',
                '                            </h5>',
                '                        </a>@{{/data}}',
                '                    </div>'].join("");
            var views = Mustache.render(template, e);
            $('#erp_storageRacks').html(views);

        },'json');
    }

    function destroyStorageRack(id,storage_id){
        if(confirm('确认删除仓区吗？')){
            $.get('/storageRack/destroy',{"id":id},function (e) {
                if(e.status == 1){
                    storageRackList(storage_id);
                }else{
                    $('#showtext').html(e.message);
                    $('#warning').show();
                }
            },'json');
        }
    }

    function editStorageRack(id) {
        $.get('/storageRack/edit',{'id':id},function (e) {
            $('#storageRack-name-up').val(e.data.name);
            $('#storageRack-content-up').val(e.data.content);
            $('#storageRack-id-up').val(e.data.id);
            $('#storageRackModalUp').modal('show');
            },'json');
    }

    $('#storageRack-update').click(function(){
        var storage_id = $('#storageRack-storageId').val();
        var id = $('#storageRack-id-up').val();
        var name = $('#storageRack-name-up').val();
        var content = $('#storageRack-content-up').val();
        $.ajax({
            type: 'post',
            url: '/storageRack/edit',
            data: {"id":id,"_token": _token, "name": name, "content": content},
            dataType: 'json',
            success: function(data){
                $('#storageRackModalUp').modal('hide');
                if (data.status == 1){
                    storageRackList(storage_id);
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error: function(data){
                $('#storageRackModalUp').modal('hide');
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
@endsection
