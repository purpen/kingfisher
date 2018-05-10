<div class="modal fade" id="supplierOrderOutModal" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">代发订单导出</h4>
            </div>
            <div class="modal-body">
                <form id="supplierOrderOutForm" class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/getDaiFaSupplierData') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">供应商</label>
                        <div class="col-md-9">
                            <select class="selectpicker" name="supplier_id" style="display: none;">
                                <option value="">选择供应商</option>
                                @foreach($supplier_list as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->nam}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">开始日期：</label>
                        <div  class="col-md-9">
                            <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">结束日期：</label>
                        <div class="col-md-9">
                            <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期" value="">
                        </div>

                    </div>

                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" id="supplierOrderOutSubmit" class="btn btn-magenta">导出</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>