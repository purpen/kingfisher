@extends('home.base')

@section('title', '采购入库')

@section('customize_css')
    @parent
    
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();
    
    var validate_form = function() {
        $("#addsku").formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'count[]': {
                    validators: {
                        notEmpty: {
                            message: '入库数量不能为空！'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: '采购数量填写不正确！'
                        }
                    }
                },
            }
        });
    }
    
    $(".edit-enter").click(function() {
        var id = $(this).attr("value");
        
        $.get("{{url('/enterWarehouse/ajaxEdit')}}", {'enter_warehouse_id':id}, function(e) {
            if(e.status){
                var template = $('#enterhouse-form').html();
                var views = Mustache.render(template, e.data);
                $("#append-sku").html(views);
                
                $("#in-warehouse").modal('show');
                
                // 验证输入入库数量
                $(".count").focusout(function() {
                    var max_value = $(this).attr("not_count");
                    var value = $(this).val();
                    if(parseInt(value) > parseInt(max_value)){
                        alert("入库数量不能大于" + max_value);
                        $(this).focus();
                    }
                });
            }
            
        }, 'json');
    });
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        入库单列表
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    @include('home.storage.warehouse-subnav')
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>入库单编号</th>
                        <th>相关采购单</th>
                        <th>入库仓库</th>
                        <th>入库数量</th>
                        <th>已入库数量</th>
                        <th>制单时间</th>
                        <th>制单人</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enter_warehouses as $enter_warehouse)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox"></td>
                            <td class="magenta-color">{{ $enter_warehouse->number }}</td>
                            <td>{{ $enter_warehouse->purchase->number }}</td>
                            <td>{{ $enter_warehouse->storage->name }}</td>
                            <td>{{ $enter_warehouse->count }}</td>
                            <td>{{ $enter_warehouse->in_count }}</td>
                            <td>{{ $enter_warehouse->created_at_val }}</td>
                            <td>{{ $enter_warehouse->user->realname }}</td>
                            <td tdr="nochect">
                                <button type="button" value="{{$enter_warehouse->id}}" class="btn btn-white btn-sm edit-enter">编辑入库</button>
                                <a href="{{ url('/enterWarehouse/show/') }}/{{ $enter_warehouse->id }}" class="btn btn-white btn-sm">查看详细</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($enter_warehouses)
            <div class="col-md-6 col-md-offset-6">{!! $enter_warehouses->render() !!}</div>
        @endif
        
    </div>    
    
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    
    @include('modal.editwarehouse')
    
    @include('mustache.enter-warehouse-form')
    
@endsection
