@extends('home.base')

@section('title', '商品库存')

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
    
    @include('block.errors')
    
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-2r pr-2r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        仓库管理
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="{{url('/storageSkuCount/productCount')}}">商品库存</a></li>
                        <li class=""><a href="{{url('/storage')}}">仓库信息</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/storageSkuCount/productSearch')}}" method="post">
                                <div class="form-group">
                                    <input type="text" name="product_number" value="{{$number}}" class="form-control" placeholder="请输入商品货号">
                                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                                </div>
                                
                                <button id="search" type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn dropdown-toggle btn-default" id="dropdownMenu1" data-toggle="dropdown">选择仓库
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    @foreach($storages as $storage)
                        <li role="presentation">
                            <a href="{{url('/storageSkuCount/productCount')}}?id={{$storage->id}}" role="menuitem" tabindex="-1">{{$storage->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>商品货号</th>
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>库存数量</th>
                            <th>仓库</th>
                            <th>库区/库位</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($storageSkuCounts as $v)
                        <tr>
                            <th class="text-center"><input type="checkbox"></th>
                            <th>{{$v->product_number}}</th>
                            <th>{{$v->ProductsSku->number}}</th>
                            <th>{{$v->Products->title}}</th>
                            <th>{{$v->ProductsSku->mode}}</th>
                            <th>{{$v->count}}</th>
                            <th>{{$v->Storage->name}}</th>
                            <th>
                                <div class="row">
                                    <div class="dropdown col-sm-6">
                                        <button class="btn btn-default dropdown-toggle btn-sm" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                            所在库位
                                            @if($v->place_count)
                                                <span class="badge" style="background-color:orangered;">{{$v->place_count}}</span>
                                            @else
                                                <span class="badge">0</span>
                                            @endif
                                            <span class="caret"></span>
                                        </button>

                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            @if(!empty($v->rack))
                                                @foreach($v->rack as $d)
                                                    <li role="presentation" class="row container"><a class="col-sm-6" role="menuitem" tabindex="-1" href="#">{{$d->StorageRack->name}}-{{$d->StoragePlace->name}}</a>
                                                    <button  value="{{$d->id}}" type="button" class="btn btn-default btn-xs col-sm-6 btn-danger delete-rack-place">删除</button></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <!-- 添加库位 -->
                                <button type="button" storangSkus="{{$v->id}}"  class="btn btn-default storage btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg">添加库位</button>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($storageSkuCounts)
        <div class="row">
            <div class="col-md-12 text-center">{!! $storageSkuCounts->appends(['number' => $number])->render() !!}</div>
        </div>
        @endif
    </div>
            <!-- 添加库位 -->
            <div class="modal fade bs-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">添加库位</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row mt15">
                                <!--parttwo star-->
                                <div class="col-md-4" style=" margin-top:0px; background:#f7f7f7; height:350px; padding:0;">
                                    <h5 style="padding:0px 10px;">
                                        <strong class="lh30">仓库</strong>
                                    </h5>
                                    <div class="list-group scrollspy-example" id="erp_storages" style="height:350px;">

                                    </div>
                                </div>
                                <!--parttwo end-->
                                <!--partthree star-->
                                <div class="col-md-4" style=" margin-top:0px; background:#f7f7f7; height:350px;; padding:0;" id="warehouseZoneDiv">
                                    <h5 style="padding:0px 10px;">
                                        <strong class="lh30">库区</strong>
                                    </h5>
                                    <div class="list-group scrollspy-example" id="erp_storageRacks" style="height:350px;">

                                    </div>
                                </div>
                                <!--partthree end-->
                                <!--partfour star-->
                                <div class="col-md-4" style="margin-top:0px; background:#f7f7f7; height:350px;padding:0;" id="warehouseLocationDiv">
                                    <h5 style="padding:0px 10px;">
                                        <strong class="lh30">库位</strong>
                                    </h5>
                                    <div class="list-group scrollspy-example" id="erp_storagePlaces" style="height:350px;">

                                    </div>
                                </div>
                                <!--partfour end-->
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-default rackPlaceAdd">添加</button>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    var _token = $('#_token').val();
    $('.storage').click(function(){
        var storage_sku_count_id = $(this).attr('storangSkus');
        $.post('/storageSkuCount/productCountList',{_token:_token,id:storage_sku_count_id}, function(e){
            var template = [
            '        <div class="list-group scrollspy-example" id="erp_storages" style="height:350px;">',
                '              @{{#data}}<a href="javascript:void(0)" class="list-group-item active">',
                    '               <h5 warehouseid="7775" class="list-group-item-heading">@{{name}}',
                        '                </h5>',
                    '           </a>@{{/data}}',
                '        </div>',
            ].join("");
            var storageRacks = [
            '    <div class="list-group scrollspy-example" id="erp_storageRacks" style="height:350px;">',
            '        @{{#rname}}<a class="list-group-item operate-warehousegoods-location storage_rack" href="javascript:void(0)" value="@{{id}}">',
            '            <h5 class="list-group-item-heading">@{{name}}',
            '            </h5>',
            '        </a>@{{/rname}}',
            '    </div>',
            ].join("");
            var views = Mustache.render(template, e);
            var Racks = Mustache.render(storageRacks, e.data);
            $('#erp_storages').html(views);
            $('#erp_storageRacks').html(Racks);

                {{--单机库区事件--}}
                $('.storage_rack').click(function(){
                $(this)
                .siblings().removeClass('active')
                .end().addClass('active');
                    var rack_id = $(this).attr('value');
                    $.post('/storageSkuCount/storagePlace',{_token:_token,id:rack_id}, function(e){
                        var storagePlace = [
                        '    <div class="list-group scrollspy-example" id="erp_storagePlaces" style="height:350px;">',
                            '        @{{#pname}}<a class="list-group-item operate-goodslocation-choose storage_place" href="javascript:void(0);" place="@{{id}}">',
                                '            <h5 class="list-group-item-heading">@{{name}}',
                                    '            </h5>',
                                '        </a>@{{/pname}}',
                            '    </div>',

                        ].join("");
                        var place = Mustache.render(storagePlace, e.data);
                        $('#erp_storagePlaces').html(place);

                        {{--单机库位事件--}}
                        $('.storage_place').click(function(){
                            $(this)
                            .siblings().removeClass('active')
                            .end().addClass('active');
                            var place_id = $(this).attr('place');
                            console.log(place_id);
                            {{--单机添加事件--}}
                            $('.rackPlaceAdd').click(function(){
                                $.post('/storageSkuCount/RackPlace',{_token:_token,storage_sku_count_id:storage_sku_count_id,rack_id:rack_id,place_id:place_id},function(e){
                                    console.log(e);
                                    if(e.status == 1){
                                        alert(e.message);
                                        location.reload();
                                    }else{
                                        alert(e.message);
                                        location.reload();
                                        return false;
                                    }
                                },'json');
                                $('#closedd').modal('hide');
                            });

                        });


                    },'json');
                });


        },'json');

    });

    /*删除sku存储位置信息*/
    var deleteRackPlace = function (id,dom) {
        $.post('{{url('/storageSkuCount/deleteRackPlace')}}',{'_token': _token, 'id': id},function(e){
            if(e.status == 1){
                dom.parent().remove();
                location.reload();
            }else{
                alert(e.message);
            }
        },'json');
    };
    $(".delete-rack-place").click(function () {
        var id = $(this).attr('value');
        var dom = $(this);
        deleteRackPlace(id,dom);
    });

{{--　   var sel=document.getElementById("storage_id");--}}
{{--　   sel.onchange=function(){--}}
{{--　　     var storage_id = sel.options[sel.selectedIndex].value;--}}
        {{--$.get('{{url('/storageSkuCount/productCount')}}',{'storage_id' : storage_id },function(e){--}}
            {{--if(e.status == 1){--}}
                {{--location.reload();--}}
            {{--}--}}
        {{--},'json');--}}
{{--　　 }　--}}

@endsection

