@extends('home.base')

@section('title', '物流')

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
                    <li><a href="{{url('/logistics')}}">物流设置</a></li>
                    <li class="active"><a href="{{url('/logistics/go')}}">物流配送</a></li>
                    <li><a href="{{url('/consignor')}}">发货人列表</a></li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            @include('block.errors')
            
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-white mr-2r" data-toggle="modal" data-target="#addlog">
                        <i class="glyphicon glyphicon-log-out"></i> 添加物流配送
                    </button>
                    <button class="btn btn-danger mr-2r" type="button" id="delete-logistics-set">
                        <i class="glyphicon glyphicon-trash"></i> 删除
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>店铺</th>
                            <th>仓库</th>
                            <th>快递</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($storeStorageLogistics as $storeStorageLogistic)
                            <tr>
                                <td class="text-center">
                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="{{ $storeStorageLogistic->id }}">
                                </td>
                                <td id="store_id1" value="{{$storeStorageLogistic->store->id}}">{{ $storeStorageLogistic->store->name }}</td>
                                <td>
                                    <select class="selectpicker storage_id1"  name="storage_id" style="display: none;">
                                        @foreach($stores->storage as $storage)
                                            <option value="{{ $storage->id }}" class="storage_id2" {{$storeStorageLogistic->storage_id == $storage->id ? 'selected' : ''}}>{{ $storage->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="selectpicker logistic_id1" name="logistic_id" style="display: none;">
                                        @foreach($stores->logistic as $logistic)
                                            <option value="{{ $logistic->id }}" class="logistic_id2" {{$storeStorageLogistic->logistics_id == $logistic->id ? 'selected' : ''}}>{{ $logistic->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-default btn-sm mr-2r update_store"  type="button" action="{{ $storeStorageLogistic->id }}">确认</button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{--  添加弹出框 --}}
        <div class="modal fade" id="addlog" tabindex="-1" role="dialog" aria-labelledby="addlogLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">物流配送</h4>
                    </div>
                    <div class="modal-body">
                        <form id="add-logistics"  class="form-horizontal" method="post" action="{{url('/logistics/goStore')}}" >
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            
                            
                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label">选择店铺</label>
                                <div class="col-sm-10">
                                    <select class="selectpicker" id="store_id" name="store_id" style="display: none;">
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="storage_id" class="col-sm-2 control-label">指定仓库</label>
                                <div class="col-sm-10">
                                    <select class="selectpicker" id="storage_id" name="storage_id">
                                        @foreach($stores->storage as $storage)
                                            <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="logistic_id" class="col-sm-2 control-label">设置快递</label>
                                <div class="col-sm-10">
                                    <select class="selectpicker" id="logistic_id" name="logistic_id">
                                        @foreach($stores->logistic as $logistic)
                                            <option value="{{ $logistic->id }}" >{{ $logistic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button id="submit_store" type="button" class="btn btn-magenta">确认提交</button>
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
{{--添加--}}
$('#submit_store').click(function(){
    var store_id = $('#store_id').val();
    var storage_id = $('#storage_id').val();
    var logistics_id = $('#logistic_id').val();
    $.post('/logistics/goStore' , {_token : _token , store_id : store_id , storage_id : storage_id , logistics_id : logistics_id} ,function (data){
        if (data.status == 1){
            location.reload();
        }
        if (data.status == 0){
            alert(data.message);
        }
    },'json');
})

{{--更改--}}
{{--function update_store(id){--}}
$('.update_store').click(function(){
    var id =  $(this).attr('action');
    var store_id = $(this).parent().siblings('#store_id1').attr('value');
    var storage_id = $(this).parent().siblings().children().children().children('.storage_id2:selected').val();
    var logistics_id = $(this).parent().siblings().children().children().children('.logistic_id2:selected').val();

    $.post('/logistics/goUpdate',{ _token : _token , id : id , store_id : store_id , storage_id : storage_id , logistics_id : logistics_id} , function (data){
        var date_obj = data;
        if(data.status == 1){
            location.reload();
        }
    },'json');
});

{{--删除物流配置--}}
$("#delete-logistics-set").click(function () {
    if(confirm('确认删除此物流？')){
        var id = '';
        $("input[name='Order']").each(function () {
            if($(this).is(':checked')){
                id = $(this).attr('value');
                var dom = $(this);
                $.post('{{url('/logistics/goDestroy')}}',{'_token': _token,'id': id}, function (e) {
                    if(e.status){
                        dom.parent().parent().remove();
                    }else{
                        alert(e.message);
                    }
                },'json');
            }
        });
    }
});

$("#add-logistics").formValidation({
    framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        store_id: {
            validators: {
                notEmpty: {
                    message: '请选择店铺！'
                }
            }
        },
        storage_id: {
            validators: {
                notEmpty: {
                    message: '请选择仓库！'
                }
            }
        },
        logistic_id: {
            validators: {
                notEmpty: {
                    message: '请选择物流！'
                }
            }
        }

    }
});
@endsection