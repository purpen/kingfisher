@extends('fiu.base')

@section('partial_css')
    @parent
@endsection
@section('customize_css')
    @parent
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        @include('block.errors')
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    站点管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li class=""><a href="{{url('/fiu/site')}}">站点信息</a></li>
                    <li class="active"><a href="{{url('/fiu/trend')}}">趋势分析</a></li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row scroll">
                <div class="col-sm-12">
                   <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th>序号</th>
                                <th>公众号</th>
                                <th>发布数量</th>
                                <th>总阅读数</th>
                                <th>头条</th>
                                <th>平均</th>
                                <th>最高</th>
                                <th>总点赞数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>人民日报</td>
                                <td>10</td>
                                <td>160万+</td>
                                <td>90万+</td>
                                <td>10万+</td>
                                <td>10万+</td>
                                <td>18万+</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>央视新闻</td>
                                <td>8</td>
                                <td>128万+</td>
                                <td>77万+</td>
                                <td>91874</td>
                                <td>10万+</td>
                                <td>50919</td>
                            </tr>
                        </tbody>
                   </table> 
               </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('partial_js')
    @parent
@endsection


