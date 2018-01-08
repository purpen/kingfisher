<div class="modal fade" id="excelDistributorOrder" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">上传exec</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/fiu/saas/user/distributorInExcel') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="display_name" class="col-sm-3 control-label p-0 lh-34 m-56">模版：</label>
                        <div class="col-sm-7">
                            <select class="selectpicker updateSelect" id="mould_id" name="mould_id" >
                                <option value="0">请选择</option>
                                @foreach($moulds as $mould)
                                    <option value="{{ $mould->id }}">{{ $mould->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="col-sm-3 control-label p-0 lh-34 m-56">选择文件：</label>
                        <div class="col-sm-7">

                            <input type="file" name="logistics_file" clas="form-control">
                        </div>
                    </div>


                    <input type="hidden" name="distributor_id" id="2distributor_id" clas="form-control">

                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-magenta">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
