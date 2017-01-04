<ul class="nav navbar-nav nav-list">
    <li @if($subnav == 'checkpay')class="active"@endif><a href="{{url('/payment')}}">待财务审核 @if($count)<span class="badge">{{$count}}</span>@endif</a></li>
    <li @if($subnav == 'waitpay')class="active"@endif><a href="{{url('/payment/payableList')}}">应付款</a></li>
    <li @if($subnav == 'finishpay')class="active"@endif><a href="{{url('/payment/completeList')}}">已付款</a></li>
</ul>

@if($subnav != 'checkpay')
<ul class="nav navbar-nav navbar-right mr-0" style="position: absolute;right: 0;">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/payment/search')}}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="subnav" value="{{$subnav}}">
            <div class="form-group mr-2r">
                <a href="" class="btn btn-link">最近7天</a>
                <a href="" class="btn btn-link">最近30天</a>
            </div>
            <div class="form-group mr-2r">
                <label for="type" class="control-label">类型：</label>
                <select class="selectpicker" name="type">
                    <option value="1">采购单</option>
                    <option value="2">订单退款</option>
                    <option value="3">订单退货</option>
                    <option value="5">贷款</option>
                    <option value="6">服务费</option>
                    <option value="7">差旅费</option>
                    <option value="8">日常报销</option>
                    <option value="9">营销费</option>
                </select>
            </div>
            <div class="form-group mr-2r">
                <label class="control-label">日期：</label>
                <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期" value="{{$start_date}}">
                至
                <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期" value="{{$end_date}}">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="where" class="form-control" placeholder="编号">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">查询</button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </div>
        </form>
    </li>
</ul>
@endif

