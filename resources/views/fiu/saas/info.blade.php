@extends('fiu.base')

@section('customize_css')
    @parent
    tr.bone > td{
    border:none !important;
    border-bottom: 1px solid #ddd !important;
    }
    tr.brnone > td{
    border: none !important;
    border-bottom: 1px solid #ddd !important;
    }
    .popover-content tr{
    line-height: 24px;
    font-size: 13px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    商品详情
                </div>
            </div>
            <div class="navbar-collapse collapse">
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-lg-1"><p>商品名称：</p></div>
            <div><p>{{ $product->tit }}</p></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-1"><p>权限设置：</p></div>
            {{--<div class="col-lg-1"><p>部分可查看</p></div>--}}
            <form action="{{url("fiu/saasProduct/ajaxSetCheck")}}" method="post">
                {{ csrf_field() }}
                <input type="text" name="product_id" value="{{$product->id}}" hidden>
                <div class="col-lg-2">
                    {{--<button class="btn btn-default btn-sm" onclick="">设置</button>--}}
                    <div class="input-group">
                        <select class="chosen-select" id="user_id" name="user_id">
                            <option value="">添加用户</option>
                            @foreach($user_list as $user)
                                <option value="{{ $user->id }}">{{ $user->account }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-1">
                    <input class="btn btn-default btn-sm input-submit" type="submit">
                </div>
            </form>

        </div>
        <div class="row container">
            @foreach($product_user_s as $product_user)
                <span class="label label-success" style="display: inline-block;">{{ $product_user->user->account }}</span>
            @endforeach
        </div>
        <hr>
        <div class="row">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th>公司名称</th>
                    <th>缩略图</th>
                    <th>编号</th>
                    <th>型号</th>
                    <th>售价</th>
                    <th class="text-center">库存</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($product_user_s as $product_user)
                    <tr class="brnone delete{{$product_user->id}}">
                        <td class="magenta-color text-center">{{ $product_user->user->account }}</td>
                        <td>
                            <img src="{{ $product_user->ProductsModel->firstimg }}" class="img-thumbnail"
                                 style="width: 80px;">
                        </td>
                        <td>{{ $product_user->ProductsModel->number }}</td>
                        <td></td>
                        <td>{{ $product_user->price }}</td>
                        <td class="magenta-color">{{ $product_user->stock ? $product_user->stock : "" }}</td>
                        <td>
                            <button class="btn btn-default btn-sm showSku"
                                    onclick="showSku({{$product_user->user->id}})">显示SKU
                            </button>
                            <button class="btn btn-default btn-sm" onclick="updateProduct({{$product_user->id}})">编辑
                            </button>
                            <button class="btn btn-default btn-sm" onclick="deleteUser({{$product_user->id}})">删除
                            </button>
                        </td>
                    </tr>
                    @foreach($product_user->ProductSkuRelation as $sku)
                        <tr class="bone product{{$product_user->user->id}} active delete{{$product_user->id}}" active="0" hidden>
                            <td></td>
                            <td>
                                <img src="{{ $sku->ProductsSkuModel->first_img }}" class="img-thumbnail"
                                     style="width: 80px;">
                            </td>
                            <td>SKU:<br>{{ $sku->ProductsSkuModel->product_number }}</td>
                            <td>属性：<br>{{ $sku->ProductsSkuModel->mode }}</td>
                            <td>{{ $sku->price }}</td>
                            <td>{{ $sku->quantity }}</td>

                            <td>
                                <button class="btn btn-default btn-sm"
                                        onclick="updateSku({{ $sku->id }},{{ $product_user->product_id }})">编辑
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">

    @include('fiu/saas.update')
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}

    var _token = $('#_token').val();
    /*搜索下拉框*/
    $(".chosen-select").chosen({
    no_results_text: "未找到：",
    search_contains: true,
    width: "100%",
    });

    {{--展示隐藏SKU--}}
    function showSku(id) {
    var dom = '.product' + id;

    if ($(dom).eq(0).attr('active') == 0) {
    $(dom).each(function () {
    $(this).attr("active", 1);
    });
    $(dom).show("slow");

    } else {
    $(dom).each(function () {
    $(this).attr("active", 0);
    });
    $(dom).hide("slow");
    }

    }
    {{--修改商品拟态框--}}
    function updateProduct(product_user_relation_id_1) {
    $('#product_user_relation_id_1').val(product_user_relation_id_1);

    var id = $("#product_user_relation_id_1").val();
    $.get('{{ url('fiu/saasProduct/getProduct') }}', {'id':id},function (e) {
    if(e.status == 1){
    $("#price1").val(e.data.price)
    }
    },'json');

    $('#updateProduct').modal('show');
    }
    {{--修改SKU拟态框--}}
    function updateSku(product_sku_relation_id, product_id) {
    $('#product_sku_relation_id').val(product_sku_relation_id);
    $('#product_id_2').val(product_id);

    var id = $("#product_sku_relation_id").val();
    $.get('{{ url('fiu/saasProduct/getSku') }}', {'id':id},function (e) {
    if(e.status == 1){
    $("#price2").val(e.data.price);
    $("#quantity").val(e.data.quantity);
    }
    },'json');

    $('#updateSku').modal('show');
    }
    {{--删除用户关联--}}
    function deleteUser(id) {
    if(confirm('确认取消对该用户推荐吗？') == true){
    $.post('{{ url('fiu/saasProduct/ajaxDelete') }}', {id: id, _token: _token},function (e) {
    if(parseInt(e.status) == 1){
    $('.delete' + id).remove();
    }else if (parseInt(e.status) == -1){
    alert('无权限');
    }else{
    alert(e.message);
    }
    },'json');
    }
    }
@endsection
@section('load_private')
    @parent
    {{--<script>--}}

@endsection
