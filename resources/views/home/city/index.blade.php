@extends('home.base')

@section('title', '城市管理')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    //添加表单验证
    $("#city_form").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: '名称不能为空！'
                    },
                    stringLength: {
                        min:1,
                        max:30,
                        message: '名称1-30字之间！'
                    }
                }
            },
            number: {
                validators: {
                    notEmpty: {
                        message: '编号不能为空！'
                    }
                }
            },
            p_number: {
                validators: {
                    notEmpty: {
                        message: '请选择省份！'
                    }
                }
            }

        }
    });


    $(function(){

        $('.edit-btn').click(function(){
            var id = $(this).data('id');
            var token = $('#_token').val();
            $.post("{{url('/city/edit')}}",{'id':id, '_token':token},function (e) {
                if (e.status == 1){
                    $("#cityId").val(e.data.id);
                    $("#cityName").val(e.data.name);
                    $("#cityPnumber").val(e.data.p_number);
                    $("#cityNumber").val(e.data.number);
                    $("#cityPy").val(e.data.city_py);

                    $("#city_form").attr("action", "{{ url('/city/update') }}");

                    $('#cityModal').modal('show');

                }else{
                    alert('获取数据失败!');
                }
            },'json');
        });

    })



@endsection

@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						城市管理
					</div>
				</div>
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li><a href="{{url('chinaCity')}}">地址列表</a></li>
                        <li class=""><a href="{{url('/province')}}">省份列表</a></li>
                        <li class="active"><a href="{{url('/city')}}">城市列表</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
	                    <li class="dropdown">
	                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/city/search') }}" method="POST">
	                            <div class="form-group">
	                                <input type="text" name="where" class="form-control" placeholder="名称">
	                                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
	                            </div>
	                            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
	                        </form>
	                    </li>
	                </ul>
                </div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		<div class="row fz-0">
			<button type="button" class="btn btn-white" data-toggle="modal" data-target="#cityModal">+新增城市</button>

        </div>
		<div class="row">
			<div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                    	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>编号</th>
                        <th>名称</th>
                        <th>拼音</th>
                        <th>所属省</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
					@foreach($cities as $d)
						<tr id="item-{{$d->id}}">
							<td class="text-center"><input name="Order" type="checkbox"></td>
							<td class="magenta-color">{{$d->number}}</td>
							<td>{{$d->name}}</td>
							<td>{{$d->city_py}}</td>
                            @if ($d->p_number)
							    <td>{{$d->province($d->p_number)->name}}</td>
                            @else
                                <td>--</td>
                            @endif
							<td>{{$d->status}}</td>
                            <td>
								<a href="javascript:void(0);" data-id="{{$d->id}}" class="magenta-color mr-r edit-btn" >编辑</a>
								<a href="{{url('/city/destroy')}}" data-ids="{{$d->id}}" class="magenta-color delete-btn">删除</a>
							</td>
						</tr>
					@endforeach
                    </tbody>
                </table>
		</div>
            @if ($cities)
                <div class="col-md-6 col-md-offset-6">{!! $cities->render() !!}</div>
            @endif
	</div>
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

    <!--表单模板-->
    <div class="modal fade" id="cityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加城市</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="city_form" role="form" method="POST" action="{{ url('/city/store') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" id="cityId" name="id" />
                        <div class="form-group">
                            <label for="inputLegalPerson" class="col-sm-2 control-label">编号</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="cityNumber" name="number" placeholder="编号">
                            </div>
                            @if ($errors->has('number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                            @endif

                            <label for="type" class="col-sm-2 control-label">所属</label>
                            <div class="col-sm-4">
                                        <select class="selectpicker" id="cityPnumber" name="p_number" style="display: none;">
                                            @foreach($provinces as $d)
                                                <option value="{{$d->number}}" >{{$d->name}}</option>
                                            @endforeach

                                        </select>
                            </div>

                            @if ($errors->has('p_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('p_number') }}</strong>
                                </span>
                            @endif

                        </div>
                        <div class="form-group">

                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="cityName" name="name" placeholder="名称">
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                            <label for="name" class="col-sm-2 control-label">全拼</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="cityPy" name="city_py" placeholder="全拼">
                            </div>
                            @if ($errors->has('city_py'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('city_py') }}</strong>
                                </span>
                            @endif
    
                        </div>

                        <div class="form-group mb-0">
                            <div class="modal-footer pb-r">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button id="submit_city" type="submit" class="btn btn-magenta">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

@endsection


