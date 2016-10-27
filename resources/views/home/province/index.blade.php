@extends('home.base')

@section('title', '省份管理')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    //添加表单验证
    $("#province_form").formValidation({
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
            type: {
                validators: {
                    notEmpty: {
                        message: '请选择类型！'
                    }
                }
            }

        }
    });


    $(function(){

        $('.edit-btn').click(function(){
            var id = $(this).data('id');
            var token = $('#_token').val();
            $.post("{{url('/province/edit')}}",{'id':id, '_token':token},function (e) {
                if (e.status == 1){
                    $("#provinceId").val(e.data.id);
                    $("#provinceName").val(e.data.name);
                    $("#provinceType").val(e.data.type);
                    $("#provinceNumber").val(e.data.number);

                    $("#province_form").attr("action", "{{ url('/province/update') }}");

                    $('#provinceModal').modal('show');

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
						省份管理
					</div>
				</div>
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li><a href="{{url('chinaCity')}}">地址列表</a></li>
                        <li class="active"><a href="{{url('/province')}}">省份列表</a></li>
                        <li class=""><a href="{{url('/city')}}">城市列表</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
	                    <li class="dropdown">
	                        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/province/search') }}" method="POST">
	                            <div class="form-group">
	                                <input type="text" name="where" class="form-control" placeholder="名称">
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
            <button type="button" class="btn btn-white mr-2r" data-toggle="modal" data-target="#provinceModal">+新增省份</button>

        </div>
		<div class="row">
			<div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                    	<th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>编号</th>
                        <th>名称</th>
                        <th>类型</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
					@foreach($provinces as $d)
						<tr id="item-{{$d->id}}">
							<td class="text-center"><input name="Order" type="checkbox"></td>
							<td class="magenta-color">{{$d->number}}</td>
							<td>{{$d->name}}</td>
							<td>{{$d->type_label($d->type)}}</td>
							<td>{{$d->status}}</td>
                            <td>
								<a href="javascript:void(0);" data-id="{{$d->id}}" class="magenta-color mr-r edit-btn" >编辑</a>
								<a href="{{url('/province/destroy')}}" data-ids="{{$d->id}}" class="magenta-color delete-btn">删除</a>
							</td>
						</tr>
					@endforeach
                    </tbody>
                </table>
		</div>
            @if ($provinces)
                <div class="col-md-6 col-md-offset-6">{!! $provinces->render() !!}</div>
            @endif
	</div>
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">


    <!--表单模板-->
    <div class="modal fade" id="provinceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加省份</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="province_form" role="form" method="POST" action="{{ url('/province/store') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" id="provinceId" name="id" />
                        <div class="form-group {{ $errors->has('number') ? ' has-error' : '' }}">
                            <label for="inputLegalPerson" class="col-sm-2 control-label">编号</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="provinceNumber" name="number" placeholder="编号">
                            </div>
                            @if ($errors->has('number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                            @endif
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="provinceName" name="name" placeholder="名称">
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-4">
                                        <select class="selectpicker" id="provinceType" name="type" style="display: none;">
                                            <option value="1">直辖市</option>
                                            <option value="2">行政省</option>
                                            <option value="3">自治区</option>
                                            <option value="4">特别行政区</option>
                                            <option value="5">国外</option>
                                        </select>
                            </div>

                            @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
    
                        </div>

                        <div class="form-group mb-0">
                            <div class="modal-footer pb-r">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button id="submit_province" type="submit" class="btn btn-magenta">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>


@endsection

