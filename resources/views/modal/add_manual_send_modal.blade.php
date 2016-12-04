{{--手动发货弹出框--}}
<div class="modal fade" id="add-manual-send" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">手动发货</h4>
            </div>
            <div class="modal-body">
                <form id="addclassify" class="form-horizontal" role="form" method="POST">
                    <input type="hidden" name="order_id" id="manual-send-order-id">
                    <div class="row">
                        <label for="title" class="col-sm-2 control-label p-0 lh-34 m-56">快递公司</label>
                        <div class="col-sm-8">
                            <select class="selectpicker" id="logistics_id" name="logistics_id" style="display: none;">
                                @foreach($logistics_list as $logistics)
                                    <option value='{{$logistics->id}}'>{{$logistics->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="order" class="col-sm-2 control-label p-0 lh-34 m-56">快递单号</label>
                        <div class="col-sm-8">
                            <input type="text" name="logistics_no" class="form-control float" id="logistics_no" placeholder="快递单号">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-magenta" id="manual-send-goods">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>