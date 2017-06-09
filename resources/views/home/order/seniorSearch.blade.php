<div class="modal fade" id="addSeniorSearch" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">高级搜索</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/order/seniorSearch') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="order_status" class="col-sm-2 control-label">订单状态</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <select class="selectpicker" name="order_status" style="display: none;">
                                    <option value="no">默认分类</option>
                                    <option value="0">已关闭</option>
                                    <option value="1">待付款</option>
                                    <option value="5">待审核</option>
                                    <option value="8">待发货</option>
                                    <option value="10">已发货</option>
                                    <option value="20">已完成</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product_name" class="col-sm-2 control-label">商品名称</label>
                        <div class="col-sm-8">
                            <input type="text" name="product_name" class="form-control" id="product_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="order_number" class="col-sm-2 control-label">订单编号</label>
                        <div class="col-sm-8">
                            <input type="text" name="order_number" class="form-control" id="order_number">
                        </div>
                    </div>

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
