@extends('home.base')

@section('title', '基本资料')

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
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-2r pr-2r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        基本资料
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active">
                            <a href="{{url('/paymentAccount')}}"> 付款账户
                            </a>
                        </li>
                        <li class="">
                            <a href="">收支类型
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar navbar-default mb-0 border-n nav-stab">
        <div class="container mr-4r pr-4r">
            <ul class="nav navbar-nav navbar-left mr-0">
                <li class="dropdown">
                    <button type="button" class="btn btn-default btn-default" data-toggle="modal" data-target="#myModal">添加</button>
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
                <th>所属店铺</th>
                <th>开户行</th>
                <th>账号</th>
                <th>默认收款账号</th>
                <th>备注</th>
                <th>操作</th>

            </tr>
            </thead>
            <tbody>
            @foreach($paymentAccount as $d)
                <tr>
                    <th class="text-center"><input type="checkbox"></th>
                    <th>{{$d->store->name}}</th>
                    <th>{{$d->bank}}</th>
                    <th>{{$d->account}}</th>
                    <th></th>
                    <th>{{$d->summary}}</th>
                    <th>
                        <button type="button" class="btn btn-default btn-default" onclick="editPayment({{ $d->id }})" value="{{ $d->id }}">详情</button>
                        <button type="button" class="btn btn-default btn-default" onclick="destroyPayment({{ $d->id }})" value="{{ $d->id }}">删除</button>
                    </th>
                </tr>
            @endforeach

            {{--弹出框--}}
            <!-- 添加Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <form action="{{url('/paymentAccount/store')}}" method="post" id="addpayment">
                            {{ csrf_field() }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">新增付款账户</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-2r">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56 mr-r">选择店铺</div><br>
                                            <select name="store_id" id="store_id">
                                                @foreach($store as $v)
                                                <option value="{{$v->id}}">{{$v->name}}</option>
                                                @endforeach
                                            </select><br>
                                            <div class="form-group m-56 mr-r">开户银行</div><br>
                                            <div class="form-group">
                                                <input type="text" value="" placeholder=" " id="bank" class="form-control float" name="bank" style="width:350px">
                                            </div><br>
                                            <div class="form-inline ">
                                                <div class="form-group m-56">账号</div><br>
                                                <div class="form-group">
                                                    <input type="text" placeholder=" " id="account" class="form-control float" name="account" style="width:350px">
                                                </div>
                                            </div>
                                            <div class="form-inline">
                                                <div class="form-group m-56">备注</div><br>
                                                <div class="form-group">
                                                    <input type="text" placeholder=" " id="summary " class="form-control float" name="summary" style="width:350px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-default">提交</button>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>


            {{--弹出框--}}
            <!-- 更新Modal -->
            <div class="modal fade" id="updateMyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <form action="{{url('/paymentAccount/update')}}" method="post" id="updatepayment">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">更改付款账户</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-2r">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group m-56 mr-r">选择店铺</div><br>
                                            <select name="store_id" id="store_id1">
                                                @foreach($store as $v)
                                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                                @endforeach
                                            </select><br>
                                            <div class="form-group m-56 mr-r">开户银行</div><br>
                                            <div class="form-group">
                                                <input type="text" value="" placeholder=" " id="bank1" class="form-control float" name="bank" style="width:350px">
                                            </div><br>
                                            <div class="form-inline ">
                                                <div class="form-group m-56">账号</div><br>
                                                <div class="form-group">
                                                    <input type="text" placeholder=" " id="account1" class="form-control float" name="account" style="width:350px">
                                                </div>
                                            </div>
                                            <div class="form-inline">
                                                <div class="form-group m-56">备注</div><br>
                                                <div class="form-group">
                                                    <input type="text" placeholder=" " id="summary1" class="form-control float" name="summary" style="width:350px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-default">提交</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            </tbody>
        </table>
    </div>
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    var _token = $("#_token").val();
    function editPayment(id) {
        $.get('/paymentAccount/edit',{'id':id},function (e) {
            if (e.status == 1){
                $("#id").val(e.data.id);
                $("#store_id1").val(e.data.store_id);
                $("#bank1").val(e.data.bank);
                $("#account1").val(e.data.account);
                $("#summary1").val(e.data.summary);
                $('#updateMyModal').modal('show');
            }
        },'json');

    }

    function destroyPayment(id) {
        if(confirm('确认删除吗？')){
            $.post('/paymentAccount/destroy',{"_token":_token,"id":id},function (e) {
                if(e.status == 1){
                    location.reload();
                }else{
                    alert(e.message);
                }
            },'json');
        }

    }


@endsection

