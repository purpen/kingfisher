@extends('home.base')

@section('title', '系统提醒')


@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						系统提醒
					</div>
				</div>
			</div>
		</div>
	</div>
    
	<div class="container mainwrap">
		<div class="row">
            <div class="col-md-12">
                <div class="message">
                    <p>503.</p>
                </div>
            </div>
        </div>
    </div>
    
@endsection
