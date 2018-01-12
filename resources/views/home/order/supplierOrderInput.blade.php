<div class="modal fade" id="supplierOrderInput" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">代发订单物流信息导入</h4>
            </div>
            <div class="modal-body">
                <form id="daiFaSupplierInput" class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/daiFaSupplierInput') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">供应商</label>
                        <div class="col-md-9">
                            <select class="selectpicker" id="supplier_id" name="supplier_id" style="display: none;">
                                <option value="">选择供应商</option>
                                @foreach($supplier_list as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->nam}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">文件：</label>
                        <div  class="col-md-9">
                            <input type="file" name="file">
                        </div>
                    </div>
                    <div id="daiFaSupplierInputReturn" hidden>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">成功：</label>
                            <div  class="col-md-3 control">
                                <p><span id="daiFaSupplierInputSuccess" style="color: #00a65a">0</span></p>
                            </div>

                            <label class="col-sm-3 control-label">失败：</label>
                            <div  class="col-md-3 control">
                                <p>
                                    <span id="daiFaSupplierInputError" style="color: #9f191f">0</span>
                                </p>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">信息：</label>
                            <div  class="col-md-9 control">
                                <textarea class="form-control" id="daiFaSupplierInputMessage" rows="3" readonly></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" id="supplierOrderInputSubmit" class="btn btn-magenta">确认</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
