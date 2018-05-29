{{--创建渠道收款单 订单商品详情弹出框--}}
<div class="modal fade" id="addsku" tabindex="-1" role="dialog" aria-labelledby="addskuLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel">sku列表</h4>
            </div>
            <div class="modal-body">
                {{--<div class="input-group">--}}
                {{--<input id="search_val" type="text" placeholder="请输入SKU编码/商品名称" class="form-control">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>--}}
                {{--</span>--}}
                {{--</div>--}}
                <div class="mt-4r scrollt">
                    <div id="sku-list" style="overflow-y:auto; height:450px;"></div>
                </div>
                <div class="form-group mb-0 sublock">
                    <div class="modal-footer pb-r">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" id="choose-sku" class="btn btn-magenta">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>