<div class="modal fade" id="addzcfile" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/dis/test/excel') }}">
                    {!! csrf_field() !!}
                    {{--<div class="form-group">--}}
                        {{--<label class="col-sm-3 control-label">订单类型</label>--}}
                        {{--<div class="col-md-9">--}}

                            {{--<input type="text"  name="excel_type">--}}
                        {{--</div>--}}

                    {{--</div>--}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">id</label>
                        <div class="col-md-9">

                            <input type="text"  name="id">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">导入文件</label>
                        <div class="col-md-9">

                            <input type="file"  name="file">
                        </div>

                    </div>

                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" id="ajax_test2" class="btn btn-magenta">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>