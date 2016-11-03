{{--添加权限--}}
<div class="modal fade " id="addPermission" tabindex="-1" role="dialog" aria-labelledby="addPermissionLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">新增权限</h4>
            </div>
            <div class="modal-body">
                <form id="addPermission" class="form-horizontal" role="form" method="POST" action="{{ url('/permission/store') }}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">名称</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control float" id="name" placeholder="例：admin.index"  value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
                        <label for="display_name" class="col-sm-2 control-label p-0 lh-34 m-56">默认名</label>
                        <div class="col-sm-8">
                            <input type="text" name="display_name" class="form-control float" id="display_name" placeholder="输入默认名称"  value="{{ old('display_name') }}">
                            @if ($errors->has('display_name'))
                                <span class="help-block">
												<strong>{{ $errors->first('display_name') }}</strong>
											</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('des') ? ' has-error' : '' }}">
                        <label for="des" class="col-sm-2 control-label p-0 lh-34 m-56">描述</label>
                        <div class="col-sm-8">
                            <input type="text" name="des" class="form-control float" id="des" placeholder="输入描述"  value="{{ old('des') }}">
                            @if ($errors->has('des'))
                                <span class="help-block">
												<strong>{{ $errors->first('des') }}</strong>
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

{{--修改权限--}}
<div class="modal fade" id="updatePermission" tabindex="-1" role="dialog" aria-labelledby="updatePermissionLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">更改权限</h4>
            </div>
            <div class="modal-body">
                <form id="updatePermission" class="form-horizontal" role="form" method="POST" action="{{ url('/permission/update') }}">
                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id" id="permission_id" >
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">名称</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control float" id="name1" placeholder="输入名称"  value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
                        <label for="display_name" class="col-sm-2 control-label p-0 lh-34 m-56">默认名</label>
                        <div class="col-sm-8">
                            <input type="text" name="display_name" class="form-control float" id="display_name1" placeholder="输入默认名称"  value="{{ old('display_name') }}">
                            @if ($errors->has('display_name'))
                                <span class="help-block">
												<strong>{{ $errors->first('display_name') }}</strong>
											</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('des') ? ' has-error' : '' }}">
                        <label for="description" class="col-sm-2 control-label p-0 lh-34 m-56">描述</label>
                        <div class="col-sm-8">
                            <input type="text" name="description" class="form-control float" id="description1" placeholder="输入描述"  value="{{ old('description') }}">
                            @if ($errors->has('description'))
                                <span class="help-block">
												<strong>{{ $errors->first('description') }}</strong>
											</span>
                            @endif
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label p-0 lh-34 m-56">权限：</label>--}}
                    {{--<div class="col-sm-8">--}}
                    {{--<div class="form-control ptb-3r" style="height:100%;">--}}
                    {{--@foreach ($data->permission as $key => $value)--}}
                    {{--<label class="checkbox-inline check-btn">--}}
                    {{--<input type="checkbox" name="permissions[]" value="{{ $value->id }}" key="{{ $key }}">--}}
                    {{--<button type="button" class="btn btn-magenta mtb-r btn-sm">--}}
                    {{--{{ $value->display_name }}--}}
                    {{--</button>--}}
                    {{--</label>--}}
                    {{--@endforeach--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
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