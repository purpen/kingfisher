<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'all')class="active"@endif><a href="{{url('/invoice')}}">发票记录</a></li>
    <li @if($tab_menu == 'waitpay')class="active"@endif><a  href="{{url('/invoice/nonOrderList')}}">审核中</a></li>
    <li @if($tab_menu == 'waitcheck')class="active"@endif><a style="color: red;border-bottom: 1px solid red;" href="{{url('/invoice/verifyOrderList')}}">已开票</a></li>
    <li @if($tab_menu == 'waitsend')class="active"@endif><a href="{{url('/invoice/sendOrderList')}}">拒绝</a></li>
    <li @if($tab_menu == 'sended')class="active"@endif><a href="{{url('/invoice/completeOrderList')}}">已过期</a></li>

</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/invoice/verifyOrderList')}}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <select style="width: 130px;height: 34px;" name="receiving_id">
                <option value ="0">请选择</option>
                <option value ="1">增值税普通发票</option>
                <option value="2">增值税专用发票</option>
            </select>
            <div class="form-group mr-2r">

            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="order_number" value="{{$order_number}}" class="form-control" placeholder="订单号">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>

                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </div>
        </form>
    </li>
</ul>