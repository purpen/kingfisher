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
                    fiu意见反馈
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                </div>
            </div>
            <div class="col-md-4 text-right">
                {{--分页数量选择--}}
                <form id="per_page_from" action="{{ url('/saasFeedback') }}" method="get">
                    <div class="datatable-length">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <select class="form-control selectpicker input-sm per_page" name="per_page">
                            <option @if($per_page == 10) selected @endif value="10">10</option>
                            <option @if($per_page == 25) selected @endif value="25">25</option>
                            <option @if($per_page == 50) selected @endif value="50">50</option>
                            <option @if($per_page == 100) selected @endif value="100">100</option>
                        </select>
                    </div>
                    <div class="datatable-info ml-r">
                        条/页，显示 {{ $lists->firstItem() }} 至 {{ $lists->lastItem() }} 条，共 {{ $lists->total() }} 条记录
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>用户</th>
                        <th>内容</th>
                        <th>联系方式</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $v)
                        <tr class="brnone">
                            <td class="text-center">
                                <input type="checkbox" name="feedback_id" value="{{ $v->id }}">
                            </td>
                            <td class="magenta-color">
                                {{ $v->User ? $v->User->account : '无'}}
                            </td>
                            <td>
                                {{ $v->content }}
                            </td>
                            <td >
                                {{ $v->contact ? $v->contact : '无'}}
                            </td>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">{!! $lists->appends(['per_page' => $per_page])->render() !!}</div>
        </div>
    </div>
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('customize_js')
    @parent

@endsection
@section('load_private')
    @parent

@endsection
