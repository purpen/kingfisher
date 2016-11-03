@extends('home.base')

@section('content')
<div class="container mainwrap">
	<div class="row">
		<div class="col-sm-12 text-center">
			<div class="permission-message">
				<img class="permission" src="{{ url('images/default/image_1_.png') }}">
				<h4 class="mt-4r">出错啦！</h4>
				<p class="text-danger">对不起，您访问的页面不存在！</p>
				<p class="mt-4r">
                    <a href="{{ $back_url or url('/home') }}" class="btn btn-default">
                        <i class="glyphicon glyphicon-arrow-left"></i> 返回上一步
                    </a>
                </p>
			</div>

		</div>

	</div>
</div>
@endsection