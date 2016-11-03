@extends('home.base')

@section('content')
<div class="container mainwrap">
	<div class="row">
		<div class="col-sm-12 text-center">
			<div class="permission-message">
				<img class="permission" src="{{ url('images/default/image.png') }}">
				<h4 class="mt-4r">哎呀！访问被拒绝啦！</h4>
				<p class="text-danger">对不起，您没有权限查看此页面！</p>
				<p class="mt-4r">
                    <a href="{{ $back_url }}" class="btn btn-default">
                        <i class="glyphicon glyphicon-arrow-left"></i> 返回上一步
                    </a>
                </p>
			</div>

		</div>

	</div>
</div>
@endsection




