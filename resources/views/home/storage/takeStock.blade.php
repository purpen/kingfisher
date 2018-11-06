@extends('home.base')

@section('title', '库存盘点')

@section('customize_css')
    @parent
    .operate-update-offlineEshop,.operate-update-offlineEshop:hover,.btn-default.operate-update-offlineEshop:focus{
    border: none;
    display: inline-block;
    background: none;
    box-shadow: none !important;
    }
@endsection

@section('content')
    @parent

    @include('block.errors')

    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    库存盘点
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>

                    </li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('/createTakeStock') }}" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-2">
                            <select class="form-control" name="storage_id">
                                <option value="">选择仓库</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{$storage->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="" type="submit" class="btn btn-default">开始盘点</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>仓库</th>
                            <th>盘点记录</th>
                            <th>备注</th>
                            <th>操作人</th>
                            <th>时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($take_stock as $v)
                            <tr>
                                <th class="text-center"><input type="checkbox"></th>
                                <th>{{$v->storage->name}}</th>
                                <th>{{$v->log? $v->log : '无'}}</th>
                                <th>{{$v->summary? $v->summary : '无'}}</th>
                                <th>{{$v->user->realname}}</th>
                                <th>{{ $v->created_at }}</th>
                                @if($v->status == 0)
                                    <th>
                                        <sapn class="label label-danger">未确认</sapn>
                                    </th>
                                @else
                                    <th>
                                        <span class="label label-success">已确认</span>
                                    </th>
                                @endif

                                <th>
                                    <a class="btn btn-default" target="_blank" href="{{ url('/takeStockDetailed') }}?id={{$v->id}}" role="button">明细</a>
                                    <button type="button" class="btn btn-primary addSummary" value="{{ $v->id }}"
                                            summary="{{ $v->summary }}">备注
                                    </button>
                                    @if($v->status == 0)
                                    <button class="btn btn-success take-stock-true" value="{{ $v->id }}" type="button">确认</button>
                                    @endif
                                    @if($v->status == 0)
                                    <button class="btn btn-danger take-stock-delete" type="button" value="{{ $v->id }}">
                                        删除
                                    </button>
                                    @endif
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                @if ($take_stock)
                    <div class="col-md-12 text-center">{!! $take_stock->render() !!}</div>
                @endif
            </div>
        </div>
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

    <div class="modal fade bs-example-modal-lg" id="addSummary" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加备注</h4>
                </div>
                <form action="{{ url('/takeStock/addSummary') }}" method="post">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <input type="text" id="take-stock-id" name="id" value="" hidden="hidden">
                        <textarea class="form-control" id="summary" name="summary" rows="3"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-magenta">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('customize_js')
    @parent

@endsection

@section('load_private')
    @parent
    {{--<script>--}}
        {{--添加备注--}}
        $(".addSummary").click(function () {
            var id = $(this).attr('value');
            var summary = $(this).attr('summary');
            $('#take-stock-id').attr('value', id);
            $("#summary").text(summary);
            $("#addSummary").modal('show');
        });
        {{--删除盘点记录--}}
        $(".take-stock-delete").click(function () {
            var isthis = $(this);
            var id = $(this).attr('value');
            var token = $("#_token").attr('value');
            $.post('{{url('/ajaxDeleteTakeStock')}}', {"id": id,"_token": token}, function (e) {
                if (e.status == 0) {
                    alert(e.message);
                } else if (e.status == -1) {
                    alert(e.msg);
                }else{
                    isthis.parent().parent().remove();
                    alert('删除成功');
                }
            }, 'json');
        });
    
        {{--确认盘点完成--}}
        $(".take-stock-true").click(function () {
            if(confirm('确认完成盘点，sku库存的修改将生效？')){
                var id = $(this).attr('value');
                var token = $("#_token").attr('value');
                $.post('{{url('/takeStock/ajaxTrue')}}',{"id": id,"_token": token}, function (e) {
                    if (e.status == 0) {
                        alert(e.message);
                    } else if (e.status == -1) {
                        alert(e.msg);
                    }else{
                        alert('盘点调整完成');
                        location.reload();
                    }
                }, 'json');
            }
        });
@endsection