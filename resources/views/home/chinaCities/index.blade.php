@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        地址城市管理
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="{{url('chinaCity')}}">地址列表</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/province/search') }}" method="POST">
                                <div class="form-group">
                                    <input type="text" name="where" class="form-control" placeholder="名称">
                                </div>
                                <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th>编号</th>
                    <th>唯一标示</th>
                    <th>名称</th>
                    <th>父级城市</th>
                    <th>层级</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $city)
                    <tr id="item-{{$city->id}}">
                        <td class="text-center">{{$city->id}}</td>
                        <td class="magenta-color">{{$city->oid}}</td>
                        <td>{{$city->name}}</td>
                        <td>{{$city->parent_name}}</td>
                        <td>{{$city->layer}}</td>
                        <td>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($lists)
        <div class="row">
            <div class="col-md-12 text-center">{!! $lists->render() !!}</div>
        </div
        @endif
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection

