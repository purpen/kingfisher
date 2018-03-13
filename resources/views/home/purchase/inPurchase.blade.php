<div class="modal fade" id="addPurchase" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">上传excel</h4>
            </div>
            <div class="modal-body">
                <form id="purchaseInput"  class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/purchaseExcel') }}">
                    {!! csrf_field() !!}
                    <input type="file" name="purchaseFile" clas="form-control">

                    <div id="purchaseReturn" hidden>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">成功：</label>
                            <div  class="col-md-3 control">
                                <p><span id="purchaseInputSuccess" style="color: #00a65a">0</span></p>
                            </div>

                            <label class="col-sm-3 control-label">失败：</label>
                            <div  class="col-md-3 control">
                                <p>
                                    <span id="purchaseInputError" style="color: #9f191f">0</span>
                                </p>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">信息：</label>
                            <div  class="col-md-9 control">
                                <textarea class="form-control" id="purchaseInputMessage" rows="3" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" id="purchaseExcelSubmit"  class="btn btn-magenta">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
