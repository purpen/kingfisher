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
    background:#fff;
    }
    #erp_storageRacks {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    background:#fff;
    }
    #erp_storagePlaces {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    background:#fff;
    }
    .list-group-item:last-child{
        border-radius:0;
    }
    .list-group-item{
        border-left:none;
        border-right:none;
        border-top:none;
        margin-bottom:0;
    }
@endsection
@section('content')
    @parent
    <div id="warning" class="alert alert-danger" role="alert" style="display: none">
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong id="showtext"></strong>
    </div>
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        仓库管理
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class=""><a href="{{url('/storageSkuCount/productCount')}}">商品库存</a></li>
                        <li class="active"><a href="{{url('/storage')}}">仓库信息</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row mb-2r">
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

                <div id="rack-list" class="col-sm-3" hidden>
                    <h5 style="padding: 0px 20px; line-height: 30px;">
                        <strong>仓区</strong>
                        <span class="pull-right">
                            <button class="btn btn-default" id="storageRack" type="button" data-toggle="modal" data-target="#storageRackModal">添加仓区</button>
                        </span>
                    </h5>
                    <div id="erp_storageRacks">
                    </div>
                </div>
                <div id="place-list" class="col-sm-3" hidden>
                    <h5 style="padding: 0px 20px; line-height: 30px;">
                        <strong>仓位</strong>
                        <span class="pull-right">
                            <button class="btn btn-default" data-toggle="modal" data-target="#storagePlaceModal" type="button">添加仓位</button>
                        </span>
                    </h5>
                    <div id="erp_storagePlaces"></div>
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
                        <div class="form-group pl-4r">
                            <label class="radio-inline">
                                <input type="radio" name="storageRadio2" id="inlineRadio3" checked  value="1"> 自建仓库
                            </label>
                        </div>

                        <div class="form-group">
                            <input type="hidden" id="storage-id">
                            <label class="col-xs-2">仓库名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2">仓库地址</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-address">
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
                    <button id="storage-submit" type="button" class="btn btn-magenta">
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
                        <div class="form-group">
                            <label class="col-xs-2">仓库地址</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-address-up">
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
                    <button id="storage-update" type="button" class="btn btn-magenta">
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
                    <button id="storageRack-submit" type="button" class="btn btn-magenta">
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
                    <button id="storageRack-update" type="button" class="btn btn-magenta">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <!-- 添加仓位拟态弹窗 -->
    <div class="modal fade" id="storagePlaceModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        新增仓位
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input type="hidden" id="storagePlace-storageRackId">
                        <div class="form-group">
                            <label class="col-xs-2">仓位名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storagePlace-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-2">仓位简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storagePlace-content"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button id="storagePlace-submit" type="button" class="btn btn-magenta">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <!-- 更新仓位拟态弹窗 -->
    <div class="modal fade" id="storagePlaceModalUp" tabindex="-1" role="dialog"
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
                        <input type="hidden" id="storagePlace-id-up">
                        <div class="form-group">
                            <label class="col-xs-2">仓区名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storagePlace-name-up">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-2">仓区简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storagePlace-content-up"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button id="storagePlace-update" type="button" class="btn btn-magenta">
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
        var address = $('#storage-address').val();
        var content = $('#storage-content').val();
    $.ajax({
            type: 'post',
            url: '/storage/add',
            data: {"_token": _token, "name": name, "content": content, "address":address,"type":type},
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
            $.post('/storage/destroy',{"_token":_token,"id":id},function (e) {
            if(e.status == 1){
            storageList(type);
            $('#rack-list').hide();
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
            $('#storage-address-up').val(e.data.address);
            $('#storage-content-up').val(e.data.content);
            $('#storage-id-up').val(e.data.id);
            $('#storageModalUp').modal('show');
        },'json');
    }

    $('#storage-update').click(function(){
        var id = $('#storage-id-up').val();
        var name = $('#storage-name-up').val();
        var address = $('#storage-address-up').val();
        var content = $('#storage-content-up').val();
        $.ajax({
            type: 'post',
            url: '/storage/edit',
            data: {"_token": _token, "name": name, "content": content,"address":address,"id":id},
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
                '                        @{{#data}} <a href="javascript:void(0)" class="list-group-item" onclick="storagePlaceList(@{{id}})">',
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
            $('#place-list').hide();
            $('#rack-list').show();
        },'json');
    }

    function destroyStorageRack(id,storage_id){
        if(confirm('确认删除仓区吗？')){
            $.post('/storageRack/destroy',{"_token":_token, "id":id},function (e) {
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

    $('#storagePlace-submit').click(function () {
        var storage_rack_id = $('#storagePlace-storageRackId').val();
        var name = $('#storagePlace-name').val();
        var content = $('#storagePlace-content').val();
        $.ajax({
            type: 'post',
            url: '/storagePlace/add',
            data: {"_token": _token, "name": name, "content": content,"storage_rack_id":storage_rack_id},
            dataType: 'json',
            success: function(data){
                $('#storagePlaceModal').modal('hide');
                if (data.status == 1){
                    storagePlaceList(storage_rack_id);
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

    function storagePlaceList (storage_rack_id) {
        $('#storagePlace-storageRackId').val(storage_rack_id);
        $.get('/storagePlace/list',{"storage_rack_id":storage_rack_id},function (e) {
            var template = ['                    <div class="list-group">',
                '                        @{{#data}} <a href="javascript:void(0)" class="list-group-item" onclick="">',
                '                            <h5 class="list-group-item-heading">@{{name}}',
                '                                <span class="pull-right">',
                '                                <button id="destroy-storagePlace" class="btn btn-default btn-xs destroy-storagePlace" value="" onclick="destroyStoragePlace(@{{id}},@{{storage_rack_id}});" type="button">删除</button>',
                '                                <button id="edit-storagePlace" class="btn btn-default btn-xs edit-storagePlace" value="" onclick="editStoragePlace(@{{id}},@{{storage_rack_id}});" type="button">信息</button>',
                '                                </span>',
                '                            </h5>',
                '                        </a>@{{/data}}',
                '                    </div>'].join("");
            var views = Mustache.render(template, e);
            $('#erp_storagePlaces').html(views);
            $('#place-list').show();

        },'json');
    }

    function editStoragePlace(id) {
        $.get('/storagePlace/edit',{'id':id},function (e) {
            $('#storagePlace-name-up').val(e.data.name);
            $('#storagePlace-content-up').val(e.data.content);
            $('#storagePlace-id-up').val(e.data.id);
            $('#storagePlaceModalUp').modal('show');
        },'json');
    }

    $('#storagePlace-update').click(function(){
        var storage_rack_id = $('#storagePlace-storageRackId').val();
        var id = $('#storagePlace-id-up').val();
        var name = $('#storagePlace-name-up').val();
        var content = $('#storagePlace-content-up').val();
        $.ajax({
            type: 'post',
            url: '/storagePlace/edit',
            data: {"id":id,"_token": _token, "name": name, "content": content},
            dataType: 'json',
            success: function(data){
                $('#storagePlaceModalUp').modal('hide');
                if (data.status == 1){
                    storagePlaceList(storage_rack_id);
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show();
                }
            },
            error: function(data){
                $('#storagePlaceModalUp').modal('hide');
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


    function destroyStoragePlace(id,storage_rack_id){
        if(confirm('确认删除库位吗？')){
            $.post('/storagePlace/destroy',{"_token":_token, "id":id},function (e) {
                if(e.status == 1){
                    storagePlaceList(storage_rack_id);
                }else{
                    $('#showtext').html(e.message);
                    $('#warning').show();
                }
            },'json');
        }
    }
@endsection
