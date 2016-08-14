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
                </div>
            </div>
        </div>
    </div>

        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <ul class="nav navbar-nav navbar-left mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/storageSkuCount/productSearch')}}" method="post">
                            <div class="form-group">
                                <input type="text" name="product_number" class="form-control" placeholder="请输入商品货号">
                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            </div>
                            <button id="search" type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
                <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="showtext"></strong>
                </div>
            </div>
        </div>
            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>商品货号</th>
                        <th>SKU编码</th>
                        <th>商品名称</th>
                        <th>商品属性</th>
                        <th>库存数量</th>
                        <th>拍下占货</th>
                        <th>付款占货</th>
                        <th>仓库</th>
                        <th>库区/库位</th>
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
                            <th></th>
                            <th></th>
                            <th>{{$v->Storage->name}}</th>
                            <th>
                                <div class="form-group pr-4r mr-2r has-feedback">
                                        <div class="dropdown-menu open dropnew bor-0 mt-0 bot-0" style="max-height: 147.967px; overflow: hidden; min-height: 0px;">
                                            <ul role="menu" class="dropdown-menu inner dropnew" style="max-height: 135.967px; overflow-y: auto; min-height: 0px;">
                                                <li data-original-index="0" class="selected">
                                                    <a data-tokens="null" style="" class="" tabindex="0">
                                                        <span class="text">所在库位</span>
                                                        <span class="glyphicon glyphicon-ok check-mark"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <select style="display: none;" name="store_id" id="store_id" class="selectpicker" data-fv-field="store_id" tabindex="-98">
                                            <option value="">所在库位</option>
                                        </select>
                                    <!-- 添加库位 -->
                                    <button type="button" action="{{$v->id}}"  class="btn btn-default storage" data-toggle="modal" data-target=".bs-example-modal-lg" >添加库位</button>
                                </div>
                            </th>

                        </tr>
                    @endforeach
                    <!-- 添加库位 -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                                    <button type="button" class="btn btn-default">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </tbody>
                </table>
            </div>



@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    var _token = $('#_token').val();
    $('.storage').click(function(){
        var id = $(this).attr('action');
        $.post('/storageSkuCount/productCountList',{_token:_token,id:id}, function(e){
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
                    var id = $(this).attr('value');
                    $.post('/storageSkuCount/storagePlace',{_token:_token,id:id}, function(e){
                        var storagePlace = [
                        '    <div class="list-group scrollspy-example" id="erp_storagePlaces" style="height:350px;">',
                            '        @{{#pname}}<a class="list-group-item operate-goodslocation-choose storage_place" href="javascript:void(0);">',
                                '            <h5 class="list-group-item-heading">@{{name}}',
                                    '            </h5>',
                                '        </a>@{{/pname}}',
                            '    </div>',

                        ].join("");
                        var place = Mustache.render(storagePlace, e.data);
                        $('#erp_storagePlaces').html(place);

                        {{--单机库位事件--}}
                        $('.storage_place').click(function(){
                            alert(111);
                        })

                    },'json');
                });


        },'json');

    });
@endsection
