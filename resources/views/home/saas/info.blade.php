@extends('home.base')

@section('customize_css')
    @parent
    tr.bone > td{
    border:none !important;
    border-bottom: 1px solid #ddd !important;
    }
    tr.brnone > td{
    border: none !important;
    border-bottom: 1px solid #ddd !important;
    }
    .popover-content tr{
    line-height: 24px;
    font-size: 13px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    saas商品管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.saas.subnav')
            </div>
        </div>
    </div>
    <div class="container mainwrap">

    </div>
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('customize_js')
    @parent

@endsection
@section('load_private')
    @parent
    {{--<script>--}}

@endsection
