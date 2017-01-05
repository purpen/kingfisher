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
                <a href="{{url('/payment/search')}}?time=7&subnav={{$subnav}}" class="btn btn-link">最近7天</a>
                <a href="{{url('/payment/search')}}?time=30&subnav={{$subnav}}" class="btn btn-link">最近30天</a>
            </div>
            <div class="form-group mr-2r">
                <label for="type" class="control-label">类型：</label>
                <select class="selectpicker" name="type">
                    <option value="">类型</option>
                    <option value="1" @if($type == 1) selected @endif>采购单</option>
                    <option value="2" @if($type == 2) selected @endif>订单退款</option>
                    <option value="3" @if($type == 3) selected @endif>订单退货</option>
                    <option value="5" @if($type == 5) selected @endif>货款</option>
                    <option value="6" @if($type == 6) selected @endif>服务费</option>
                    <option value="7" @if($type == 7) selected @endif>差旅费</option>
                    <option value="8" @if($type == 8) selected @endif>快递费</option>
                    <option value="9" @if($type == 9) selected @endif>营销费</option>
                    <option value="10" @if($type == 10) selected @endif>手续费</option>
                    <option value="11" @if($type == 11) selected @endif>福利费</option>
                    <option value="12" @if($type == 12) selected @endif>办公费</option>
                    <option value="13" @if($type == 13) selected @endif>业务招待费</option>
                    <option value="14" @if($type == 14) selected @endif>推广费</option>
                    <option value="15" @if($type == 15) selected @endif>房屋水电费</option>
                    <option value="16" @if($type == 16) selected @endif>公积金</option>
                    <option value="17" @if($type == 17) selected @endif>社保</option>
                    <option value="18" @if($type == 18) selected @endif>印花税</option>
                    <option value="19" @if($type == 19) selected @endif>个人所得税</option>
                    <option value="20" @if($type == 20) selected @endif>税金</option>
                    <option value="21" @if($type == 21) selected @endif>固定资产</option>
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

