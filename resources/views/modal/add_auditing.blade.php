<div class="modal fade" id="addroles" tabindex="-1" role="dialog" aria-labelledby="addrolesLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content" style="width: 535px;margin: 0 auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">新增权限模块</h4>
            </div>
            <div class="modal-body">
                <form id="addclassify" class="form-horizontal" role="form" method="POST" action="{{ url('/auditing/store') }}" onsubmit="return false">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}" id="showone">
                        <label for="type" class="col-sm-2 control-label p-0 lh-34 m-56" style="min-width: 106px">审核名称</label>
                        <div class="col-sm-8">
                            <input type="text" name="type" class="form-control float" id="type" placeholder="请输入审核模块名称"  value="{{ old('type') }}">
                            @if ($errors->has('type'))
                                <span class="help-block">
														<strong>{{ $errors->first('type') }}</strong>
													</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label" style="width: 110px">选择审核人<em>*</em></label>
                        <div class="col-sm-3">
                            <div class="input-group  col-md-12">
                                <div class="col-sm-8" style="width: 360px">
                                    @foreach($realname as $list)
                                            <input type="checkbox" name="user_id" id="user_id" class="checkcla" required value="{{ $list->id }}">{{ $list->realname }}
                                    @endforeach

                                </div>
                                <input type="hidden" name="Jszzdm" id="Jszzdm" value="@Model.Jszzdm" />
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
