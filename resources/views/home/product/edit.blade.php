@extends('home.base')

@section('title', 'console')
@section('customize_css')
	@parent

@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						添加商品
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('customize_js')
    @parent

@endsection