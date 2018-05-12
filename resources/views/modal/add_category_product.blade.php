<div class="modal fade" id="addclass" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">新增分类</h4>
            </div>
            <div class="modal-body">
                <form id="addclassify" class="form-horizontal" role="form" method="POST" action="{{ url('/category/store') }}" onsubmit="return false">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-sm-2 control-label p-0 lh-34 m-56">分类名</label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control float" id="title" placeholder="输入分类名"  value="{{ old('title') }}">
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
                            <input type="text" name="order" class="form-control float" id="order" placeholder="选填"  value="{{ old('order') }}">
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
                                    <select class="selectpicker" id="type" name="type" style="display: none;">
                                        <option value="1">商品</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="inputStatus" class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <div class="radio-inline">
                                <label class="mr-3r">
                                    <input type="radio" name="status" value="1" checked>启用
                                </label>
                                <label class="ml-3r">
                                    <input type="radio" name="status" value="0">禁用
                                </label>
                            </div>
                        </div>
                        @if ($errors->has('status'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-magenta" onclick="sure()">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
