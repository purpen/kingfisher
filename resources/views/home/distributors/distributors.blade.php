@extends('home.base')

@section('partial_css')
    @parent
    <link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
    @parent
    .m-92{
    min-width:92px;
    text-align:right;
    vertical-align: top !important;
    line-height: 34px;
    }
    .img-add{
    width: 100px;
    height: 100px;
    background: #f5f5f5;
    vertical-align: middle;
    text-align: center;
    padding: 24px 0;
    }
    .img-add .glyphicon{
    font-size:30px;
    }
    #picForm{
    position:relative;
    color: #f36;
    height: 100px;
    text-decoration: none;
    width: 100px;
    }
    #picForm:hover{
    color:#e50039;
    }
    #picForm .form-control{
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    width: 100px;
    height: 100px;
    z-index: 3;
    cursor: pointer;
    }
    .removeimg{
    position: absolute;
    left: 75px;
    bottom: 10px;
    font-size: 13px;
    }
    #appendsku{
    margin-left:40px;
    font-size:14px;
    }
    .qq-uploader {
    position: relative;
    width: 100%;
    width: 100px;
    height: 100px;
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    }
    .qq-upload-button{
    width:100px;
    height:100px;
    position:absolute !important;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        @include('block.errors')
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    经销商管理
                </div>
            </div>

            <div class="navbar-collapse collapse">
                @include('home.distributors.subnav')
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-sm-12">

                    <button type="button" id="batch-verify" class="btn btn-success mr-2r">
                        <i class="glyphicon glyphicon-ok"></i> 通过审核
                    </button>
                    <button type="button" id="batch-close" class="btn btn-danger mr-2r">
                        <i class="glyphicon glyphicon-remove"></i> 驳回
                    </button>


                </div>
            </div>
            @if (session('error_message'))
                <div class="alert alert-success error_message">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p class="text-danger">{{ session('error_message') }}</p>
                </div>
            @endif
            <div class="row scroll">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>ID</th>
                            <th>门店名称</th>
                            <th>姓名</th>
                            <th>所在省份</th>
                            <th>商品分类</th>
                            <th>审核状态</th>
                            <th>操作</th>
                        </tr>

                        </thead>
                        <tbody>
                        @if ($distributors['data'])
                            @foreach($distributors['data'] as $distributor)
                                <tr>
                                    <td class="text-center"><input name="Order" type="checkbox" active="0" value="{{ $distributor['id'] }}"></td>
                                    <td>{{ $distributor['id'] }}</td>
                                    <td>{{ $distributor['store_name'] }}</td>
                                    <td>{{ $distributor['name'] }}</td>
                                    <td>{{ $distributor['province'] }} </td>
                                    <td>{{ $distributor['category'] }} </td>
                                    <td>
                                        @if($distributor['status'] == 1)
                                            待审核
                                        @elseif($distributor['status'] == 2)
                                            已审核
                                        @elseif($distributor['status'] == 3)
                                            未通过
                                        @elseif($distributor['status'] == 4)
                                            重新审核
                                        @endif
                                    </td>

                                    <td>
                                        <a class="btn btn-default btn-sm" href="{{ url('/distributors/details') }}?id={{$distributor['id']}}" target="_blank">详情</a>
                                        <a class="btn btn-default btn-sm del" href="javascript:void(0);" value="{{$distributor['id']}}">删除</a>

                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
            {{--<div class="row">--}}
                {{--@if ($distributors['data'])--}}
                    {{--<div class="col-md-12 text-center">{!! $distributors->appends(['name' => $name , 'status' => $status])->render() !!}</div>--}}
                {{--@endif--}}
            {{--</div>--}}
        </div>

    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">


@endsection
@section('partial_js')
    @parent
    <script src="{{ elixir('assets/js/fine-uploader.js') }}" type="text/javascript"></script>
@endsection

@section('customize_js')


    var _token = $("#_token").val();
    function destroySupplier (id) {
    if(confirm('确认关闭该经销商吗？')){
    $.post('/distributors/ajaxClose',{"_token":_token,"id":id},function (e) {
    if(e.status == 1){
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    }

    }

@endsection

@section('load_private')
    @parent

    $(document).on("click","#batch-verify",function(obj){
    layer.confirm('确认要通过审核吗？',function(index){
        var distributors = [];
        $("input[name='Order']").each(function () {
            if($(this).is(':checked')){
                distributors.push($(this).attr('value'));
            }
        });

        $.post('{{url('/distributors/ajaxVerify')}}',{'_token': _token,'distributors': distributors}, function (data) {
            if(data.status == 0){
                layer.msg('操作成功！');
                location.reload();
            }else if(data.status == 1){
                alert(data.message);
            }else{
                location.reload();
            }
        },'json');
    });
    });


    {{--经销商关闭--}}

        $(document).on("click","#batch-close",function(obj){
            layer.confirm('确认要驳回审核吗？',function(index){
            var distributors = [];
            $("input[name='Order']").each(function () {
                if($(this).is(':checked')){
                 distributors.push($(this).attr('value'));
                }
            });

            $.post('{{url('/distributors/ajaxClose')}}',{'_token': _token,'distributors': distributors}, function (e) {

                if(e.status == 0){
                    layer.msg('操作成功！');
                    location.reload();
                }else if(e.status == 1){
                    alert(e.message);
                }else{
                    location.reload();
                }
            },'json');

        });
    });


    $('.del').click(function () {
    if(confirm('确认删除该经销商？')){
    var id = $(this).attr('value');
    var delete_obj = $(this).parent().parent();
    $.post('{{url('/distributors/ajaxDestroy')}}',{'_token': _token, 'id': id},function (e) {
    if(e.status == 1){
    layer.msg('操作成功！');
    delete_obj.remove();
    }else if(e.status == 0){
    alert(e.message);
    }else{
    location.reload();
    }
    },'json');
    }
    });


    {{--post请求--}}
    function post(URL, PARAMS) {

        var temp = document.createElement("form");
        temp.action = URL;
        temp.method = "post";
        temp.style.display = "none";
        var opt = document.createElement("textarea");
        opt.name = '_token';
        opt.value = _token;
        temp.appendChild(opt);
        for (var x in PARAMS) {
            var opt = document.createElement("textarea");
            opt.name = x;
            opt.value = PARAMS[x];
            {{--// alert(opt.name)--}}
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;
    };

@endsection
