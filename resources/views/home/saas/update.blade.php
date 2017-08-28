{{--跟新商品信息--}}
<div class="modal fade" id="updateProduct" tabindex="-1" role="dialog" aria-labelledby="updateProductLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel">更改商品信息</h4>
            </div>
            <div class="modal-body">
                <form id="updateRole" class="form-horizontal" role="form" method="POST"
                      action="{{ url('/saasProduct/setProduct') }}">
                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id" id="product_user_relation_id_1">
                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">价格</label>
                        <div class="col-sm-8">
                            <input type="text" name="price" class="form-control float" id="price1" placeholder="输入价格"
                                   value="{{ old('price') }}">
                            @if ($errors->has('price'))
                                <span class="help-block">
												<strong>{{ $errors->first('price') }}</strong>
											</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('stock') ? ' has-error' : '' }}">
                        <label for="display_name" class="col-sm-2 control-label p-0 lh-34 m-56">库存</label>
                        <div class="col-sm-8">
                            <input type="text" name="stock" class="form-control float" id="stock"
                                   placeholder="输入默认名称" value="{{ old('stock') }}">
                            @if ($errors->has('stock'))
                                <span class="help-block">
												<strong>{{ $errors->first('stock') }}</strong>
											</span>
                            @endif
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

{{--更新sku--}}
<div class="modal fade" id="updateSku" tabindex="-1" role="dialog" aria-labelledby="updateProductLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel">更改SKU信息</h4>
            </div>
            <div class="modal-body">
                <form id="updateRole" class="form-horizontal" role="form" method="POST"
                      action="{{ url('/saasProduct/setSku') }}">
                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id" id="product_sku_relation_id">
                    <input type="hidden" name="product_id" id="product_id_2">
                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">价格</label>
                        <div class="col-sm-8">
                            <input type="text" name="price" class="form-control float" id="price1" placeholder="输入价格"
                                   value="{{ old('price') }}">
                            @if ($errors->has('price'))
                                <span class="help-block">
												<strong>{{ $errors->first('price') }}</strong>
											</span>
                            @endif
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