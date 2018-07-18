<div class="modal fade" id="updateclass" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog modal-zm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">更新分类/授权条件/地域分类</h4>
            </div>
            <div class="modal-body">
                <form id="updateclassify" class="form-horizontal" role="form" method="POST" action="{{ url('/category/update') }}" onsubmit="return false">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" id="category_id">
{{--                    @if(!in_array(old('type'),[1,2]))--}}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }} showones" id="showones">
                        <label for="titles" class="col-sm-2 control-label p-0 lh-34 m-56" style="min-width: 106px">分类名/授权条件</label>
                        <div class="col-sm-8">
                            <input type="text" name="titles" class="form-control float" id="title1" placeholder="请输入分类名或授权条件"  value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
														<strong>{{ $errors->first('title') }}</strong>
													</span>
                            @endif
                        </div>
                    </div>
                    {{--@endif--}}

                    <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }} showtwos" id="showtwos" style="display: none">
                        <label for="provinces" class="col-sm-2 control-label p-0 lh-34 m-56" style="min-width: 106px">省份</label>
                        <div class="col-md-8 pl-4r ml-3r">
                            <div class="form-inline">
                                <div class="form-group mb-0">
                                    <select class="selectpicker" id="provinces" name="provinces">
                                        <option value="">请选择省份</option>
                                        @foreach($provinces as $v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }} showthrees" id="showthrees" style="display: none">
                        <label for="citys" class="col-sm-2 control-label p-0 lh-34 m-56" style="min-width: 106px">市</label>
                        <br>
                        <div class="col-md-8 pl-4r ml-3r" style="width:245px;" id="d3">

                        </div>
                        {{--<button type="submit" class="btn btn-magenta" id="gets" style="margin-left: 50%">确定</button>--}}
                        <div id="gets" style="margin-left: 55%"><a href="javascript:void(0)" style="color: deeppink;font-size: 16px;">确定</a></div>
                    </div>

                    <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }} showfours" style="display: none" id="showfours">
                        <label for="areas" class="col-sm-2 control-label p-0 lh-34 m-56" style="min-width: 106px">区/县</label>
                        <div class="col-md-8 pl-4r ml-3r" style="width:279px;" id="d4">

                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                        <label for="orders" class="col-sm-2 control-label p-0 lh-34 m-56" style="min-width: 106px">排序</label>
                        <div class="col-sm-8">
                            <input type="text" name="orders" class="form-control float" id="order1" placeholder="选填"  value="{{ old('order') }}">
                            @if ($errors->has('order'))
                                <span class="help-block">
														<strong>{{ $errors->first('order') }}</strong>
													</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="types" class="col-sm-2 control-label p-0 lh-34 m-56" style="min-width: 106px">类型</label>
                        <div class="col-md-8 pl-4r ml-3r">
                            <div class="form-inline">
                                <div class="form-group mb-0">
                                    {{--<select class="selectpicker types" id="type" name="type" style="display: none;" >--}}
                                        {{--<option value="1">商品</option>--}}
                                        {{--<option value="2">授权条件</option>--}}
                                        {{--<option value="3">地域分类</option>--}}
                                    {{--</select>--}}
                                    <input type="text" name="types" class="form-control float" id="type1" value="{{ old('type') }}" readonly style="padding-right: 72.5px">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="inputStatus" class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <div class="radio-inline">
                                <label class="mr-3r">
                                    <input type="radio" name="status" id="status1" value="1">启用
                                </label>
                                <label class="ml-3r">
                                    <input type="radio" name="status" id="status0" value="0">禁用
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
                            <button type="submit" class="btn btn-magenta" id="gaves">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
