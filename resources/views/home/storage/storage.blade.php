 @extends('home.base')

@section('title', '仓库管理')

@section('customize_css')
    @parent
    
    .item-header {
        line-height: 30px;
    }
    
    #erp_storage {
        width: auto;
        height: 460px;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: auto;
        background:#fff;
    }
    #erp_storage .list-group-item-heading,
    #erp_storageRacks .list-group-item-heading,
    #erp_storagePlaces .list-group-item-heading {
        line-height: 40px;
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
    .list-group-item {
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
        @include('block.errors')
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    仓库管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li><a href="{{url('/storageSkuCount/productCount')}}">商品库存</a></li>
                    <li class="active"><a href="{{url('/storage')}}">仓库信息</a></li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-sm-4">
                    <h5 class="item-header">
                        仓库列表 
                        <span class="pull-right">
                            <button class="btn btn-default btn-sm" id="storage" data-toggle="modal" data-target="#storageModal" type="button"><i class="glyphicon glyphicon-plus"></i> 添加仓库</button>
                        </span>
                    </h5>
                    <div id="erp_storages"></div>
                </div>
                <div class="col-sm-4">
                    <div id="rack-list" hidden>
                        <h5 class="item-header">
                            仓区列表 
                            <span class="pull-right">
                                <button class="btn btn-default btn-sm" id="storageRack" type="button" data-toggle="modal" data-target="#storageRackModal"><i class="glyphicon glyphicon-plus"></i> 添加仓区</button>
                            </span>
                        </h5>
                        <div id="erp_storageRacks"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div id="place-list" hidden>
                        <h5 class="item-header">
                            仓位列表
                            <span class="pull-right">
                                <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#storagePlaceModal" type="button"><i class="glyphicon glyphicon-plus"></i> 添加仓位</button>
                            </span>
                        </h5>
                        <div id="erp_storagePlaces"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加仓库拟态弹窗 -->
    <div class="modal fade" id="storageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        新增仓库
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="addStorage" action="post">
                        <input type="hidden" id="storage-id">
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓库类型</label>
                            <div class="col-xs-9">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="storageRadio2" id="inlineRadio3" checked value="1"> 自建仓库
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓库名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" name="storageName" id="storage-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓库地址</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓库简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" name="storageContent" id="storage-content"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">初始化库存--}}
                    {{--</button>--}}
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        仓库信息
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input type="hidden" id="storage-id-up">
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓库名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-name-up">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓库地址</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-address-up">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓库简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storage-content-up"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
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
                            <label class="col-xs-2 control-label">仓区名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storageRack-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓区简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storageRack-content"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
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
                            <label class="col-xs-2 control-label">仓区名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storageRack-name-up">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓区简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storageRack-content-up"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        新增仓位
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="post">
                        <input type="hidden" id="storagePlace-storageRackId">
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓位名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storagePlace-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓位简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storagePlace-content"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"data-dismiss="modal">
                        取消
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
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
                            <label class="col-xs-2 control-label">仓区名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storagePlace-name-up">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">仓区简介</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" id="storagePlace-content-up"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
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

    
    function storageList(status) {
        $.get('/storage/storageList',{"status":status},function (e) {
            var template = ['<div id="erp_storage">',
                '                    <div class="list-group">',
                '                        @{{#data}} <a href="javascript:void(0)" class="list-group-item" onclick="storageRackList(@{{id}}, this)">',
                '                            <h5 class="list-group-item-heading">@{{name}}',
                '                                <i class="glyphicon">[@{{status}}]</i>',
                '                                <span class="pull-right">',
                '                                   <button id="destroy-storage" class="btn btn-default btn-sm destroy-storage" value="" onclick="destroyStorage(@{{id}});" type="button">删除</button>',
                '                                   <button id="edit-storage" class="btn btn-default btn-sm edit-storage" value="" onclick="editStorage(@{{id}});" type="button">查看信息</button>',
                '                                </span>',
                '                            </h5>',
                '                        </a>@{{/data}}',
                '                    </div>',
                '                </div>'].join("");
            var views = Mustache.render(template, e);
            $('#erp_storages').html(views);
        },'json');
    }

    function destroyStorage(id) {
        if(confirm('确认删除仓库吗？')){
            var type = $("input[name='storageRadio1']:checked").val();
            $.post('/storage/destroy',{"_token":_token, "id":id},function(e) {
                if(e.status == 1){
                    storageList(type);
                    $('#rack-list').hide();
                }else{
                    $('#showtext').html(e.message);
                    $('#warning').show().delay(4000).hide(0);
                }
            },'json');
        }
    }
    
    function editStorage(id) {
        $.get('/storage/edit', {'id':id}, function(e) {
            $('#storage-name-up').val(e.data.name);
            $('#storage-address-up').val(e.data.address);
            $('#storage-content-up').val(e.data.content);
            $('#storage-id-up').val(e.data.id);
            $('#storageModalUp').modal('show');
        }, 'json');
    }



    function storageRackList(storage_id, e){
        $(e)
            .siblings().removeClass('active')
            .end().addClass('active');
        
        $('#storageRack-storageId').val(storage_id);
        $.get('/storageRack/list',{"storage_id":storage_id},function (e) {
            var template = ['<div class="list-group">',
                '                        @{{#data}} <a href="javascript:void(0)" class="list-group-item" onclick="storagePlaceList(@{{id}}, this)">',
                '                            <h5 class="list-group-item-heading">@{{name}}',
                '                                <span class="pull-right">',
                '                                <button id="destroy-storageRack" class="btn btn-default btn-sm destroy-storageRack" value="" onclick="destroyStorageRack(@{{id}},@{{storage_id}});" type="button">删除</button>',
                '                                <button id="edit-storageRack" class="btn btn-default btn-sm edit-storageRack" value="" onclick="editStorageRack(@{{id}},@{{storage_id}});" type="button">查看信息</button>',
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
                    $('#warning').show().delay(4000).hide(0);
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



    function storagePlaceList (storage_rack_id, e) {
        $(e)
            .siblings().removeClass('active')
            .end().addClass('active');
        $('#storagePlace-storageRackId').val(storage_rack_id);
        $.get('/storagePlace/list',{"storage_rack_id":storage_rack_id},function (e) {
            var template = ['<div class="list-group">',
                '                        @{{#data}} <a href="javascript:void(0)" class="list-group-item" onclick="">',
                '                            <h5 class="list-group-item-heading">@{{name}}',
                '                                <span class="pull-right">',
                '                                <button id="destroy-storagePlace" class="btn btn-default btn-sm destroy-storagePlace" value="" onclick="destroyStoragePlace(@{{id}},@{{storage_rack_id}});" type="button">删除</button>',
                '                                <button id="edit-storagePlace" class="btn btn-default btn-sm edit-storagePlace" value="" onclick="editStoragePlace(@{{id}},@{{storage_rack_id}});" type="button">查看信息</button>',
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


    function destroyStoragePlace(id,storage_rack_id){
        if(confirm('确认删除库位吗？')){
            $.post('/storagePlace/destroy',{"_token":_token, "id":id},function (e) {
                if(e.status == 1){
                    storagePlaceList(storage_rack_id);
                }else{
                    $('#showtext').html(e.message);
                    $('#warning').show().delay(4000).hide(0);
                }
            },'json');
        }
    }
    
    $(function() {
        storageList();
    });


@endsection

@section('load_private')
    @parent

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

                    $('#storage-name').val(' ');
                    $('#storage-address').val(' ');
                    $('#storage-content').val(' ');
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show().delay(4000).hide(0);
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
                $('#warning').show().delay(4000).hide(0);
            }
        });
    });

    $('#storage-update').click(function(){
        var id = $('#storage-id-up').val();
        var name = $('#storage-name-up').val();
        var address = $('#storage-address-up').val();
        var content = $('#storage-content-up').val();
        $.ajax({
            type: 'post',
            url: '/storage/update',
            data: {"_token": _token, "name": name, "content": content,"address":address,"id":id},
            dataType: 'json',
            success: function(data){
            $('#storageModalUp').modal('hide');
                if (data.status == 1){
                    storageList();
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show().delay(4000).hide(0);
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
                $('#warning').show().delay(4000).hide(0);
            }
        });

    });

    $('#storageRack-submit').click(function() {
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
                    $('#storageRack-name').val('');
                    $('#storageRack-content').val('');
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show().delay(4000).hide(0);
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
                $('#warning').show().delay(4000).hide(0);
            }
        });
    });

    $('#storageRack-update').click(function(){
        var storage_id = $('#storageRack-storageId').val();
        var id = $('#storageRack-id-up').val();
        var name = $('#storageRack-name-up').val();
        var content = $('#storageRack-content-up').val();
        $.ajax({
            type: 'post',
            url: '/storageRack/update',
            data: {"id":id,"_token": _token, "name": name, "content": content},
            dataType: 'json',
            success: function(data){
                $('#storageRackModalUp').modal('hide');
                if (data.status == 1){
                    storageRackList(storage_id);
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show().delay(4000).hide(0);
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
            $('#warning').show().delay(4000).hide(0);
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
                    $('#storagePlace-name').val('');
                    $('#storagePlace-content').val('');
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show().delay(4000).hide(0);
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
                $('#warning').show().delay(4000).hide(0);
            }
        });
    });


    $('#storagePlace-update').click(function(){
        var storage_rack_id = $('#storagePlace-storageRackId').val();
        var id = $('#storagePlace-id-up').val();
        var name = $('#storagePlace-name-up').val();
        var content = $('#storagePlace-content-up').val();
        $.ajax({
            type: 'post',
            url: '/storagePlace/update',
            data: {"id":id,"_token": _token, "name": name, "content": content},
            dataType: 'json',
            success: function(data){
                $('#storagePlaceModalUp').modal('hide');
                if (data.status == 1){
                    storagePlaceList(storage_rack_id);
                }
                if (data.status == 0){
                    $('#showtext').html(data.message);
                    $('#warning').show().delay(4000).hide(0);
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
                $('#warning').show().delay(4000).hide(0);
            }
        });

    });
@endsection
