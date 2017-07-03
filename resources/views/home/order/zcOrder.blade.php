<div class="modal fade" id="addzcfile" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">上传exec</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/zcInExcel') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">店铺名称</label>
                        <div class="col-md-9">
                            <select class="selectpicker" id="store_id" name="store_id" style="display: none;">
                                <option value="">选择店铺</option>
                                @foreach($store_list as $store)
                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">选择商品</label>
                        <div class="col-md-9">
                            <select class="selectpicker" id="product_type" name="product_type" style="display: none;">
                                <option value="">选择商品</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">导入文件</label>
                        <div class="col-md-9">

                            <input type="file"  name="zcFile">
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
