<div class="modal fade bs-example-modal-lg" id="in-warehouse" tabindex="-1" role="dialog" aria-labelledby="appendskuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    编辑入库
                </h4>
            </div>
            <div class="modal-body">
                <form id="addsku" class="form-horizontal" method="post" action="{{ url('/enterWarehouse/update') }}">
                    <div id="append-sku">
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-magenta">确认提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>