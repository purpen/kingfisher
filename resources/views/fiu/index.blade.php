@extends('fiu.base')

@section('customize_css')
    @parent
    
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="console">
                        <h5>欢迎登录太火鸟Fiu系统</h5>
                        <hr>
                    </div>
                </div>
            </div>
		</div>
    </div>
@endsection

@section('customize_js')
    @parent

@endsection
