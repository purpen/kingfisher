@extends('home.base')

@section('title', '站点管理')
@section('partial_css')
	@parent
@endsection
@section('customize_css')
	@parent

.input-group > .bootstrap-select {
    padding: 0;
}

form .row {
  margin-left: -5px;
}

.row .col {
  padding-left: 5px;
  padding-right: 5px;
}

.site-conf {

}
.site-conf .form-group {
  margin: 0;
}

.formwrapper {
}

.add-conf-box {
  margin-bottom: 20px;
}

.conf-item {
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
}


@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					新增站点
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="" method="post" action="{{ url('/saas/site/store') }}">
						{!! csrf_field() !!}
						<input type="hidden" class="form-control" name="id" value="{{$site->id}}">
    					<h5>基本信息</h5>
              <hr>

            <div class="row">
              <div class="form-group col col-md-2">
                <label for="mark" class="control-label">站点标识</label>
                <input type="text" class="form-control" name="mark" value="{{$site->mark}}">
              </div>
              <div class="form-group col col-md-3">
                <label for="name" class="control-label">站点名称</label>
                <input type="text" class="form-control" name="name" value="{{$site->name}}">
              </div>

            </div>

            <div class="row">
              <div class="form-group col col-md-2">
                <label for="site_type" class="control-label">类型</label>
                <div class="input-group">
                  <select class="selectpicker" name="site_type" style="display: none;">
                    <option value="1"{{$site->site_type == 1  ? 'selected' : ''}}>公众号</option>
                    <option value="2"{{$site->site_type == 2  ? 'selected' : ''}}>众筹</option>
                    <option value="3"{{$site->site_type == 3  ? 'selected' : ''}}>普通销售</option>
                  </select>
                </div>
              </div>
              <div class="form-group col col-md-3">
                <label for="user_id" class="control-label">分销商</label>
                <div class="input-group">
                  <select class="selectpicker" name="user_id" style="display: none;">
                    <option value="">选择用户</option>
                    @foreach($users as $user)
                      <option value="{{$user->id}}"{{$user->id == $site->user_id ? 'selected' : ''}}>{{$user->realname}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="form-group col col-md-4">
                <div class="form-group">
                  <label for="url" class="control-label">网址</label>
                  <input type="text" class="form-control" name="url" value="{{$site->url}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col col-md-8">
                <div class="form-group">
                  <label for="grap_url" class="control-label">爬取地址</label>
                  <input type="text" class="form-control" name="grap_url" value="{{$site->grap_url}}">
                </div>
              </div>
            </div>


            <div class="site-conf">
              <label for="url" class="control-label">配置</label>
              <div id="conf-box">
                @foreach($site->items as $d)
                  <div class="conf-item">
                    <div class="row">
                      <div class="col col-md-1">
                        <p>{{ $d['field'] }}</p>
                      </div>
                      <div class="col col-md-1">
                        <p>{{ $d['name'] }}</p>
                      </div>
                      <div class="col col-md-10">
                        <p>{{ $d['code'] }}</p>
                      </div>
                    </div>
                    <div class="conf-edit-btn">
                      <input type="hidden" name="item[]" value="{{ $d['temp'] }}" />
                      <button class="btn btn-default btn-sm conf-remove-btn" type="button">删除</button>
                      <button class="btn btn-default btn-sm conf-edit-btn" type="button">编辑</button>
                    </div>
                  </div>
                @endforeach
              </div>
              
              <div class="add-conf-box">
                <button class="btn btn-primary btn-sm add-conf-btn" type="button">+ 添加配置项</button>
              </div>
            </div>

            <div class="row">
              <div class="form-group col col-md-8">
                <div class="form-group">
                  <label for="remark" class="control-label">备注</label>
								<textarea  rows="5" cols="10" name="remark" class="form-control">{{$site->remark}}</textarea>
                </div>
              </div>
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-white cancel btn-lg once" onclick="history.back()">取消</button>
              <button type="submit" class="btn btn-magenta btn-lg save">确认保存</button>
            </div>
                    
                    </form>
                </div>
            </div>
        </div>
	</div>
	<input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('partial_js')
	@parent
  <script>
    // 生成配置项
    function generate_html(obj) {
      var c_field = obj.parents('.conf-item').find('[name="item_field"]').val();
      var c_name = obj.parents('.conf-item').find('[name="item_name"]').val();
      var c_code = obj.parents('.conf-item').find('[name="item_code"]').val();

      var item = c_field + '@!@' + c_name + '@!@' + c_code;

      var html = '';
      html+='<div class="conf-item">';
      html+='<div class="row">';
      html+='<div class="col col-md-1"><p>'+ c_field +'</p></div>';
      html+='<div class="col col-md-1"><p>'+ c_name +'</p></div>';
      html+='<div class="col col-md-10"><p>'+ c_code +'</p></div>';
      html+='</div>';
      html += '<div class="conf-edit-btn">';
      html+='<input type="hidden" name="item[]" value="'+ item +'" />';
      html+='<button class="btn btn-default btn-sm conf-remove-btn" type="button">删除</button>';
      html+='<button class="btn btn-default btn-sm conf-edit-btn" type="button">编辑</button>';
      html+='</div></div>';

      return html;
    }

    // 生成编辑配置项
    function generate_html_edit(obj, evt) {
      var c_field = c_name = c_code = '';
      if (evt === 2) {
        var str = obj.parents('.conf-item').find('[name="item[]"]').val();
        var arr = str.split('@!@');
        c_field = arr[0];
        c_name = arr[1];
        c_code = arr[2];
      }

      var html = '';
      html += '<div class="conf-item">';
      html += '<div class="row">';
      html += '<div class="form-group col col-md-2"><input type="text" class="form-control" name="item_field" value="'+ c_field +'" placeholder="字段"></div>';
      html += '<div class="form-group col col-md-2"><input type="text" class="form-control" name="item_name" value="'+ c_name +'" placeholder="说明"></div>';
      html += '</div>';

      html += '<div class="row">';
      html += '<div class="form-group col col-md-8"><input type="text" class="form-control" name="item_code" value="'+ c_code +'" placeholder="代码"></div>';
      html += '</div>';

      html += '<div class="conf-edit-btn">';
      html += '<button class="btn btn-default btn-sm conf-remove-btn" type="button">删除</button>';
      html += '<button class="btn btn-default btn-sm conf-save-btn" type="button">保存</button>';
      html += '</div></div>';

      return html;
    }
  </script>
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
	var _token = $('#_token').val();

  // 删除配置
  $('.conf-remove-btn').livequery(function(){
    $(this).click(function(){
      $(this).parents('.conf-item').remove();
    });
  });

  // 保存配置
  $('.conf-save-btn').livequery(function(){
    $(this).click(function(){
      var html = generate_html($(this));
      $(this).parents('.conf-item').replaceWith(html);
    });
  });

  // 编辑配置 
  $('.conf-edit-btn').livequery(function() {
    $(this).click(function(){
      var html = generate_html_edit($(this), 2);
      $(this).parents('.conf-item').replaceWith(html);
    });
  })


  // 添加配置项
  $('.add-conf-btn').click(function() {
    var html = generate_html_edit($(this), 1);
    $('#conf-box').append(html);
  });


@endsection
