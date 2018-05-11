{{--绑定模版--}}
<div class="modal fade" id="addMouldModel" tabindex="-1" role="dialog" aria-labelledby="addMouldLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">绑定模版</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/supplier/storeMould') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="supplier_id" id="2supplier_id" clas="form-control">
                    <div class="form-group">

                        <label for="inputTel" class="col-sm-2 control-label">关联模版</label>
                        <div class="col-sm-3">
                            <select class="selectpicker" id="mould_id" name="mould_id" style="display: none;">
                                <option value=0 >请选择</option>
                                @foreach($order_moulds as $order_mould)
                                    <option value='{{$order_mould->id}}'>{{$order_mould->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-magenta ">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>