<div class="modal fade" id="updateclass" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">更新分类</h4>
            </div>
            <div class="modal-body">
                <form id="updateclassify" class="form-horizontal" role="form" method="POST" action="{{ url('/category/update') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" id="category_id">
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-sm-2 control-label p-0 lh-34 m-56">分类名</label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control float" id="title1" placeholder="输入分类名"  value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
														<strong>{{ $errors->first('title') }}</strong>
													</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                        <label for="order" class="col-sm-2 control-label p-0 lh-34 m-56">排序</label>
                        <div class="col-sm-8">
                            <input type="text" name="order" class="form-control float" id="order1" placeholder="选填"  value="{{ old('order') }}">
                            @if ($errors->has('order'))
                                <span class="help-block">
														<strong>{{ $errors->first('order') }}</strong>
													</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label p-0 lh-34 m-56">类型</label>
                        <div class="col-md-8 pl-4r ml-3r">
                            <div class="form-inline">
                                <div class="form-group mb-0">
                                    <select class="selectpicker" id="type1" name="type" style="display: none;">
                                        <option value="1">商品</option>
                                    </select>
                                </div>
                            </div>
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
