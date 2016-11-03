@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						短语管理
					</div>
				</div>
			</div>
		</div>
    </div>
    
	<div class="container mainwrap">
		@include('block.errors')
        
		<div class="row">
			<button type="button" class="btn btn-white" data-toggle="modal" data-target="#addShop">
                <i class="glyphicon glyphicon-edit"></i> 添加短语
            </button>
		</div>
        
		<div class="row">
			<table class="table table-bordered table-striped">
				<thead>
				<tr class="gblack">
					<th>短语ID</th>
					<th>短语内容</th>
					<th>时间</th>
					<th>性别</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
                @foreach($positiveEnergys as $positiveEnergy)
					<tr>
						<td>{{$positiveEnergy->id}}</td>
						<td>{{$positiveEnergy->content}}</td>
						<td>
                            @if($positiveEnergy->type == 1)
                                <span>早晨</span>
                            @elseif($positiveEnergy->type == 2)
                                <span>上午</span>
                            @elseif($positiveEnergy->type == 3)
                                <span>下午</span>
                            @elseif($positiveEnergy->type == 4)
                                <span>晚上</span>
                            @endif
                        </td>
						<td>
                            @if($positiveEnergy->sex == 1)
                                <span class="label label-primary">男</span>
                            @else
                                <span class="label label-success">女</span>
                            @endif
                        </td>
						<td>
							<a href="javascript:void(0)" data-toggle="modal" data-target="#updatePositiveEnergy" class="btn btn-default btn-sm mr-r" onclick="editPositiveEnergy({{$positiveEnergy->id}})" value="{{$positiveEnergy->id}}">修改</a>
							<a href="javascript:void(0)" class="btn btn-default btn-sm" onclick="destroyPositiveEnergy({{$positiveEnergy->id}})" value="{{$positiveEnergy->id}}">删除</a>
						</td>
					</tr>
                @endforeach
				</tbody>
			</table>
        </div>
        
        <div class="row">
			@if($positiveEnergys->render() !== "")
				<div class="col-md-6 col-md-offset-5">
					{!! $positiveEnergys->render() !!}
				</div>
			@endif
        </div>
        
		{{--添加短语--}}
		<div class="modal fade" id="addShop" tabindex="-1" role="dialog" aria-labelledby="addShopLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
						<h4 class="modal-title" id="gridSystemModalLabel">添加短语</h4>
					</div>
					<div class="modal-body">
						<form id="addusername" class="form-horizontal" method="post" action="{{url('/positiveEnergy/store')}}">
							<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">显示时间</label>
                                <div class="col-md-9">
									<select class="selectpicker" id="type" name="type" style="display: none;">
										<option value="1">早晨</option>
										<option value="2">上午</option>
										<option value="3">下午</option>
										<option value="4">晚上</option>
									</select>
                                </div>
                            </div>

							<div class="form-group">
								<label class="col-sm-2 control-label">短语</label>
								<div class="col-sm-9">
									<textarea name="content" id="content" class="form-control"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="inputGeneral_taxpayer" class="col-sm-2 control-label">性别</label>
								<div class="col-sm-10">
                                    <div class="radio-inline">
                                        <label class="mr-3r">
                                            <input type="radio" name="sex" value="1"> 男
                                        </label>
                                        <label class="ml-3r">
                                            <input type="radio" name="sex" value="0"> 女
                                        </label>
                                    </div>
								</div>
							</div>
                            <div class="modal-footer">
                                <button id="submit" type="submit" class="btn btn-magenta">确认提交</button>

                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            </div>
						</form>
		            </div>

		        </div>
		    </div>
		</div>

		{{--修改短语--}}
		<div class="modal fade" id="updatePositiveEnergy" tabindex="-1" role="dialog" aria-labelledby="updatePositiveEnergyLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="gridSystemModalLabel">修改短语</h4>
					</div>
					<div class="modal-body">
						<form id="updatePositive" class="form-horizontal" method="post" action="{{url('/positiveEnergy/update')}}">
							<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" id="PositiveEnergy_id" name="id">
                            <div class="form-group">
								<label class="col-sm-2 control-label">短语</label>
								<div class="col-sm-9">
									<textarea id='content1'name="content" class="form-control"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">选择时间</label>
								<div class="col-md-9">
									<select class="selectpicker" id="type2" name="type" style="display: none;">
										<option class="type1" value="1">早晨</option>
										<option class="type1" value="2">上午</option>
										<option class="type1" value="3">下午</option>
										<option class="type1" value="4">晚上</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputGeneral_taxpayer" class="col-sm-2 control-label">性别</label>
								<div class="col-sm-10">
                                    <div class="radio-inline">
                                        <label class="mr-3r">
                                            <input type="radio" name="sex" id="sex111" value="1"> 男
                                        </label>
                                        <label class="ml-3r">
                                            <input type="radio" name="sex" id="sex000" value="0"> 女
                                        </label>
                                    </div>
								</div>
							</div>
                            <div class="modal-footer">
                                <button id="submit_PositiveEnergy" type="submit" class="btn btn-magenta">确认更新</button>

                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            </div>
						</form>
					</div>

				</div>
			</div>
		</div>

    </div>
@endsection

@section('customize_js');
    @parent
    var _token = $("#_token").val();
    function editPositiveEnergy(id){
        $.get('/positiveEnergy/edit',{'id':id},function(e){
            if(e.status == 1){
                $("#PositiveEnergy_id").val(e.data.id);
                $('#content1').val(e.data.content);

                if(e.data.sex==1){
                    $("#sex111").prop('checked',true);
                }else{
                    $("#sex000").prop('checked',true);
                }

                $('.type1').each(function(){
                    if($(this).attr('value') == e.data.type){
                        $(this).attr('selected',true);
                    }
                })

                $('#updatePositiveEnergy').modal('show');
            }

        },'json');

    }

    function destroyPositiveEnergy(id){
        $.post('/positiveEnergy/destroy',{_token : _token , id:id },function(e){
            if(e.status == 1){
                location.reload();
            }
        },'json')

    }

@endsection