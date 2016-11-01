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
        margin-bottom: 30px;
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

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand logo" href="{{ url('/') }}">
                    <img id="logo" src="{{ url('images/logo.png') }}" class="img-responsive" alt="logo" title="logo">
                </a>
            </div>

            <div class="navbar-collapse collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="dropdown"><a href="{{ url('/home') }}">首页</a></li>
                    @role(['servicer', 'director', 'admin'])
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">客服
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="{{url('/order')}}">订单查询</a></li>
                            <li><a href="{{url('/order/nonOrderList')}}">待付款订单</a></li>
                            <li><a href="{{url('/refund')}}">退款售后</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="{{ url('/product') }}">商品列表</a></li>
                        </ul>
                    </li>
                    @endrole
                    
                    @role(['servicer', 'director', 'admin'])
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">订单
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a href="{{ url('/order/verifyOrderList') }}">审单</a></li>
                            <li><a href="{{ url('/order/reversedOrderList') }}">返审</a></li>
                            <li><a href="{{ url('/order/sendOrderList') }}">打单发货</a></li>
                            <li><a href="{{ url('/article') }}">验货</a></li>
                            <li><a href="{{ url('/article') }}">称重</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="{{ url('/product') }}">商品列表</a></li>
                        </ul>
                    </li>
                    @endrole
                    
                    @role(['storekeeper','admin'])
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">库管
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                            <li><a href="{{url('/enterWarehouse')}}">入库单</a></li>
                            <li><a href="{{url('/outWarehouse')}}">出库单</a></li>
                            <li><a href="{{url('/changeWarehouse')}}">调拨单</a></li>
                            <li><a href="">盘点单</a></li>
                            <li><a href="{{url('/storageSkuCount/list')}}">库存监控</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="{{ url('/logistics') }}">物流管理</a></li>
                            <li><a href="{{url('/storageSkuCount/productCount')}}">仓库管理</a></li>
                        </ul>
                    </li>
                    @endrole
                    
                    @role(['buyer','admin'])
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">采购
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
                            <li><a href="{{ url('/purchase') }}">采购单</a></li>
                            <li><a href="{{ url('/returned') }}">采购退货单</a></li>
                            <li><a href="{{ url('/storageSkuCount/list') }}">库存监控</a></li>
                            <li><a href="{{url('/storageSkuCount/storageCost')}}">库存成本</a></li>
                            <li><a href="{{ url('/product') }}">商品列表</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="{{ url('/supplier') }}">供应商信息</a></li>
                        </ul>
                    </li>
                    @endrole
                    
                    @role(['buyer', 'director', 'admin'])
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">运营
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu5">
                            <li><a href="{{ url('/product') }}">商品列表</a></li>
                            <li><a href="{{url('/synchronousStock')}}">库存同步</a></li>
                            <li><a href="">赠品策略</a></li>
                            <li><a href="{{url('/order')}}">订单查询</a></li>
                        </ul>
                    </li>
                    @endrole
                    
                    @role(['financer','admin'])
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">财务
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu6">
                            <li><a href="{{url('/receive')}}">收款</a></li>
                            <li><a href="{{url('/payment')}}">付款</a></li>
                            <li><a href="{{url('/storageSkuCount/storageCost')}}">库存成本</a></li>
                            <li><a href="{{url('/order')}}">订单查询</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="{{url('/paymentAccount')}}">财务资料</a></li>
                        </ul>
                    </li>
                    @endrole
                    
                    @role(['admin'])
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu6">
                            <li><a href="{{url('/user')}}">用户管理</a></li>
                            <li><a href="{{url('/role')}}">角色管理</a></li>
                            <li><a href="{{url('/permission')}}">权限管理</a></li>
                            <li><a href="{{url('/rolePermission')}}">分配权限</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="{{url('/category')}}">分类管理</a></li>
                            <li><a href="{{url('/chinaCity')}}">城市管理</a></li>
                            <li><a href="{{url('/record')}}">日志管理</a></li>
                            <li><a href="{{url('/positiveEnergy')}}">短语管理</a></li>
                            <li><a href="{{url('/store')}}">店铺管理</a></li>
                        </ul>
                    </li>
                    @endrole
                    
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right mr-0">
                    
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                       <li class="dropdown">
                            <a href="{{ url('/login') }}" class="transparent btn-magenta btn"> 登录</a>
                            <a href="{{ url('/register') }}" class="transparent btn-magenta btn"> 注册</a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-bell"></span>
                            </a>
                            <ul class="dropdown-menu mr-r" aria-labelledby="dropdownMenu7">
                                <li>
                                    <div class="ptb-4r plr-4r">
                                        暂时没有新的提醒哦 ...
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Auth::user()->account}}
                            </a>
                        </li>
                        <li class="dropdown"> 
                            <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="user img-circle" src="" align="absmiddle">

                                <span class="glyphicon glyphicon-menu-down"></span>
                            </a>
                            <ul class="dropdown-menu mr-3r" aria-labelledby="dropdownMenu8">
                                <li><a href="javascript:void(0);" data-toggle="modal" id="users" data-target="#updateuser1">个人资料</a></li>
                                <li><a href="{{url('/logout')}}">退出</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

            </div>

        </div>
    </nav>
    {{--更改--}}
    <div class="modal fade" id="updateuser1" tabindex="-1" role="dialog" aria-labelledby="updateuser1Label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">更改个人资料</h4>
                </div>
                <div class="modal-body">
                    <form id="updateuser" role="form" class="form-horizontal" method="post" action="{{ url('/update') }}">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" id="user_id" value="{{Auth::user()->id}}" >
                        <div class="form-group">
                            <label for="account" class="col-sm-2 control-label p-0 lh-34 m-56">帐号：</label>
                            <div class="col-sm-8">
                                <input type="text" name="account" class="form-control float" id="account1" placeholder="帐号" value="{{Auth::user()->account}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label p-0 lh-34 m-56">手机号：</label>
                            <div class="col-sm-8">
                                <input type="text" name="phone" class="form-control float" value="{{Auth::user()->phone}}" id="phone1" placeholder="手机号码">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sex" class="col-sm-2 control-label  p-0 lh-34 m-56">性别 : </label>
                            <div class="col-sm-8">
                                @if(Auth::user()->sex == 1)
                                男<input type="radio" checked value="1" name="sex" id="sex1">&nbsp&nbsp
                                女<input type="radio" value="0" name="sex" id="sex0">
                                @else
                                男<input type="radio" value="1" name="sex" id="sex1">&nbsp&nbsp
                                女<input type="radio" checked value="0" name="sex" id="sex0">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{Auth::user()->realname}}" name="realname" class="form-control float" id="realname1" placeholder="姓名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label p-0 lh-34 m-56">邮箱：</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{Auth::user()->email}}" name="email" class="form-control float" id="email1" placeholder="邮箱">
                            </div>
                        </div>
                        <div class="row mb-2r user-pic">
                            <div class="col-md-2 mb-3r">
                                <div id="picForm" enctype="multipart/form-data">
                                    <div class="img-add">
                                        <span class="glyphicon glyphicon-plus f46"></span>
                                        <p>添加头像</p>
                                        <div id="fine-user-uploader"></div>
                                    </div>
                                </div>
                                <input type="hidden" id="cover_id" name="cover_id">
                                <script type="text/template" id="qq-template">
                                    <div id="add-img" class="qq-uploader-selector qq-uploader">
                                        <div class="qq-upload-button-selector qq-upload-button">
                                            <div>上传头像</div>
                                        </div>
                                        <ul class="qq-upload-list-selector qq-upload-list">
                                            <li hidden></li>
                                        </ul>
                                    </div>
                                </script>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="modal-footer pb-0">
                                <button type="submit" class="btn btn-magenta">确定</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@section('partial_js')
    @parent
    <script src="{{ elixir('assets/js/fine-uploader.js') }}" type="text/javascript"></script>
@endsection

@section('load_private')
    var _token = $('#_token').val();
    {{--七牛token--}}
    var token = $('#tokens').val();

    $(document).ready(function() {
        new qq.FineUploader({
            element: document.getElementById('fine-user-uploader'),
            autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
            // 远程请求地址（相对或者绝对地址）
            request: {
                endpoint: 'https://up.qbox.me',
                params:  {
                    "token": token,
                    "x:user_id":'{{ Auth::user()->id }}'
                },
                inputName:'file',
            },

            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png'],
                sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
            },
            //回调函数
            callbacks: {
                //上传完成后
                onComplete: function(id, fileName, responseJSON) {
                console.log(responseJSON);
                    if (responseJSON.success) {
                        console.log(responseJSON.success);
                        $("#cover_id").val(responseJSON.asset_id);
                        $('.user-pic').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
                        $('.removeimg').click(function(){
                            var id = $(this).attr("value");
                            var img = $(this);
                            $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                                if(e.status){
                                    img.parent().remove();
                                }else{
                                    console.log(e.message);
                                }
                            },'json');

                        });
                    } else {
                        alert('上传图片失败');
                    }
                }
            }
        });
    });

    {{--七牛地址--}}
    var path = $('#path').val();
    {{--默认地址--}}
    var patht = $('#patht').val();

    if(path == null){
        $('.user').attr("src" , patht);
    }else{
        $('.user').attr("src" , path);
    }

@endsection