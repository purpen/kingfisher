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
                <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1"> 全部
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2"> 空闲
                    </label>
                </div>
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

            <div class="col-sm-3">
                <h5 style="padding: 0px 20px; line-height: 30px;">
                    <strong>仓区</strong>
                    <span class="pull-right">
                        <button class="btn btn-default" type="button">添加仓区</button>
                    </span>
                </h5>
                <div id="erp_storage">
                    <div class="list-group">
                        <a href="" class="list-group-item">
                            <h5 class="list-group-item-heading">默认仓区
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
                            <input type="radio" name="storageRadio" id="inlineRadio1" checked  value="1"> 自建仓库
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="storageRadio" id="inlineRadio2" value="2"> 奇门仓库
                        </label>
                        <div class="form-group">
                            <label class="col-xs-2">仓库名称</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2">仓库编号</label>
                            <div class="col-xs-9">
                                <input class="form-control" id="storage-number">
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
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">


@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    var _token = $('#_token').val();

    $('#storage-submit').click(function(){
        var type = $("input[name='storageRadio']:checked").val();
        var name = $('#storage-name').val();
        var content = $('#storage-content').val();
        var number = $('#storage-number').val();
        $.ajax({
            type: 'post',
            url: '/storage/add',
            data: {"_token": _token, "name": name, "content": content, "number":number ,"type":type},
            dataType: 'json',
            success: function(data){
                $('#storageModal').modal('hide');
                if (data.status == 1){

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
{{--//   </script>--}}

@endsection
