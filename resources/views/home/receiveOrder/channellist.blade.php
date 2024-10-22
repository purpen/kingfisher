@extends('home.base')

@section('customize_css')
    @parent
    .loading{
    width:160px;
    height:56px;
    position: absolute;
    top:50%;
    left:50%;
    line-height:56px;
    color:#fff;
    padding-left:60px;
    font-size:15px;
    background: #000 url(images/loader.gif) no-repeat 10px 50%;
    opacity: 0.7;
    z-index:9999;
    -moz-border-radius:20px;
    -webkit-border-radius:20px;
    border-radius:20px;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
    }
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();
@endsection


@section('load_private')
    @parent
    {{--<script>--}}
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
    });

    $(".delete").click(function () {
    if(confirm('确认删除该收款单？')){
    var id = $(this).attr('value');
    var de = $(this);
    $.post('{{url('/receive/Destroy')}}',{'_token':_token,'id':id},function (e) {
    if(e.status){
    de.parent().parent().remove();
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




    {{--导出--}}
    $('#out_purchase').click(function () {
    var channels = [];
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    channels.push($(this).attr('value'));
    }
    });
    post('{{url('/channelLists')}}',{'channels':channels});

    });

    {{--导入--}}
    $("#in_purchase").click(function () {
    $("#purchaseInputSuccess").text(0);
    $("#purchaseInputError").text(0);
    $("#purchaseInputMessage").val('');
    $('#purchaseReturn').hide();
    $("#addPurchase").modal('show');
    });

    $("#channelExcelSubmit").click(function () {
    var formData = new FormData($("#purchaseInput")[0]);

    var purchaseInputSuccess = $("#purchaseInputSuccess");
    var purchaseInputError = $("#purchaseInputError");
    var purchaseInputMessage = $("#purchaseInputMessage");
    $.ajax({
    url : "{{ url('/channelExcel') }}",
    type : 'POST',
    dataType : 'json',
    data : formData,
    {{--// 告诉jQuery不要去处理发送的数据--}}
    processData : false,
    {{--// 告诉jQuery不要去设置Content-Type请求头--}}
    contentType : false,
    beforeSend:function(){
    var loading=document.getElementById("loading");
    loading.style.display = 'block';
    console.log("正在进行，请稍候");
    },
    success : function(e) {
    loading.style.display = 'none';
    var data = e.data;
    if(e.status == 1){
    purchaseInputSuccess.text(data.success_count);
    purchaseInputError.text(data.error_count);
    purchaseInputMessage.val(data.error_message);
    $('#purchaseReturn').show();
    }else if(e.status == -1){
    alert(e.msg);
    }else{
    console.log(e.message);
    alert(e.message);
    }
    },
    error : function(e) {
    alert('导入文件错误');
    }
    });
    });

@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    渠道收款单列表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li @if($tab_menu == 'default')class="active"@endif><a href="{{url('/receive/receiveIndex')}}">全部</a></li>
                    {{--<li @if($tab_menu == 'guanlianlish')class="active"@endif><a href="{{url('/receive/guanlianrenList')}}">待关联、销售确认</a></li>--}}
                    <li @if($tab_menu == 'saled')class="active"@endif><a href="{{url('/receive/saleList')}}">待负责人确认</a></li>
                    <li @if($tab_menu == 'unpublish')class="active"@endif><a href="{{url('/receive/unpublishList')}}">待分销商确认 </a></li>
                    <li @if($tab_menu == 'canceled')class="active"@endif><a href="{{url('/receive/cancList')}}">待确认付款</a></li>
                    <li @if($tab_menu == 'overled')class="active"@endif><a href="{{url('/receive/overList')}}">完成</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/receive/channel') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 创建渠道收款单
                        </a>

                    </div>


                <button type="button" class="btn btn-default mr-2r" id="in_purchase">
                    导入
                </button>
                    <button type="submit" id="out_purchase" class="btn btn-white mr-2r">
                        导出
                    </button>
            </div> </div>
        </div>
        <div id="loading" class="loading" style="display: none;">Loading...</div>
        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>单号</th>
                        <th>状态</th>
                        <th>渠道商</th>
                        <th>总金额</th>
                        <th>操作人</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if ($channel)
                    @foreach($channel as $channels)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox"  active="0" value="{{$channels->id}}"></td>
                            <td class="magenta-color">{{$channels->number}}</td>
                            <td>
                                @if ($channels->status == 0)
                                    {{--待关联人确认--}}
                                    <span class="label label-danger">默认</span>
                                @endif
                                @if ($channels->status == 1)
                                    <span class="label label-danger">待负责人确认</span>
                                @endif
                                @if ($channels->status == 2)
                                    <span class="label label-danger">待分销商确认</span>
                                @endif

                                @if ($channels->status == 3)
                                    <span class="label label-success">待确认付款</span>
                                @endif

                                @if ($channels->status == 4)
                                    <span class="label label-default">完成</span>
                                @endif

                            </td>
                            <td>
                                {{$channels->name}}
                            </td>
                            <td>{{$channels->price}}</td>
                            <td>{{ \Illuminate\Support\Facades\Auth::user()->realname}}</td>
                            <td>{{ $channels->created_at }}</td>
                            <td>
                                <a href="{{url('/receive/show')}}?id={{$channels->id}}" class="btn btn-white btn-sm mr-r">查看详情</a>
                                <a href="{{url('/receive/edit')}}?id={{$channels->id}}" class="magenta-color mr-r">编辑</a>
                                <a href="javascript:void(0)" value="{{$channels->id}}" class="magenta-color delete">删除</a>

                            </td>
                        </tr>
                    @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>

    {{--导入弹出框--}}
    @include('home/receiveOrder.inchannel')
@endsection
