<template>
    <div class="container min-height350">
      <div class="settlement">
        <div class="settlement-title">
          <p class="font-16 margin-b-15 color_333">结算页</p>
          <p class="font-20 color_333">填写并核对订单信息</p>
        </div>
        <div class="address">
          <div class="display-start-end">
            <p class="font-16">收货人信息</p>
            <p class="font-14 cursor">新增收货地址</p>
          </div>
          <div class="addressInfo margin-t-15">
            <ul class="addressInfo-ul">
              <li>
                <div class="wid-200 display-flex-ju-center text-center border-e ">
                  <p class="font-14">韦鹏</p>
                </div>
                <div class="flex-1 text-left margin-l-40">
                  <!--<p class="closed_name">韦鹏</p>-->
                  <p class="address_details margin-b-5">北京 朝阳区 酒仙桥4号751北京时酒仙桥4号751北京时尚设计广场B7栋南楼西侧酒仙桥4号751北京时尚设计广场B7栋南楼西侧尚设计广场B7栋南楼西侧</p>
                  <p class="address_phone font-weight">13020663711</p>
                </div>
                <div class="wid-200 address_operation text-right" style="opacity: 1">
                  <Button>默认地址</Button>
                </div>
              </li>
              <li>
                <div class="wid-200 display-flex-ju-center text-center border-e ">
                  <p class="font-14">韦鹏</p>
                </div>
                <div class="flex-1 text-left margin-l-40">
                  <!--<p class="closed_name">韦鹏</p>-->
                  <p class="address_details margin-b-5">北京 朝阳区 酒仙桥4号751北京时尚设计广场B7栋南楼西侧</p>
                  <p class="address_phone font-weight">13020663711</p>
                </div>
                <div class="wid-200 address_operation text-right">
                  <div class="display-space-b">
                    <p class="color_ed3a">设置默认地址</p>
                    <p>编辑</p>
                    <p>删除</p>
                  </div>
                </div>
              </li>
              <li>
                <div class="wid-200 display-flex-ju-center text-center border-e ">
                  <p class="font-14">韦鹏</p>
                </div>
                <div class="flex-1 text-left margin-l-40">
                  <!--<p class="closed_name">韦鹏</p>-->
                  <p class="address_details margin-b-5">北京 朝阳区 酒仙桥4号751北京时尚设计广场B7栋南楼西侧</p>
                  <p class="address_phone font-weight">13020663711</p>
                </div>
                <div class="wid-200 address_operation text-right">
                  <div class="display-space-b">
                    <p class="color_ed3a">设置默认地址</p>
                    <p>编辑</p>
                    <p>删除</p>
                  </div>
                </div>
              </li>
              <li>
                <div class="wid-200 display-flex-ju-center text-center border-e ">
                  <p class="font-14">韦鹏</p>
                </div>
                <div class="flex-1 text-left margin-l-40">
                  <!--<p class="closed_name">韦鹏</p>-->
                  <p class="address_details margin-b-5">北京 朝阳区 酒仙桥4号751北京时尚设计广场B7栋南楼西侧</p>
                  <p class="address_phone font-weight">13020663711</p>
                </div>
                <div class="wid-200 address_operation text-right">
                  <div class="display-space-b">
                    <p class="color_ed3a">设置默认地址</p>
                    <p>编辑</p>
                    <p>删除</p>
                  </div>
                </div>
              </li>
            </ul>
            <!--<div class="display-f">-->
              <!--<p class="margin-r-5">展开地址</p>-->
              <!--<img src="../../../../assets/images/icon/icon06.png" alt="">-->
            <!--</div>-->
            <div class="display-f wid_80">
              <p class="margin-r-5">收起地址</p>
              <img src="../../../../assets/images/icon/icon06.png" alt="">
            </div>
          </div>
        </div>
        <!--支付方式-->
        <div class="pay border-t-b">
          <div class="pay_title margin-b-20">
            <p class="font-16 ">支付方式</p>
          </div>
          <div class="pay_type padding-l-r display-f">
            <div class="wid-125 display-flex-ju-center text-center border-e">
              <p class="color_666">支付宝</p>
            </div>
            <div class="wid-125 margin-l-25 display-flex-ju-center border-200 text-center">
              <p class="color_666">月结</p>
            </div>
          </div>
        </div>
        <!--订单-->
        <div class="orderLit border-t-b">
          <div class="margin-b-20">
            <p class="font-16 ">送货清单</p>
          </div>
          <div class="padding-l-r">
            <ul class="order-ul">
              <li>
                <div class="wid_400 display-f">
                  <div class="wid_110">
                    <img src="../../../../assets/images/home/banner/bannertest.png" alt="">
                  </div>
                  <div class="margin-l-20 display-felx-c">
                    <p class="lin-clamp-3">商品名称商品名称商品名称商品名称商品名称商品名称</p>
                    <p>颜色: <span>白色</span></p>
                  </div>
                </div>
                <div class="flex_1">x1</div>
                <div class="flex_1">￥412.00</div>
              </li>
              <li>
                <div class="wid_400 display-f">
                  <div>
                    <img src="../../../../assets/images/home/banner/bannertest.png" alt="">
                  </div>
                  <div class="margin-l-20 display-felx-c">
                    <p class="lin-clamp-3">商品名称商品名称商品名商品名称商品名称商品名称商品商品名商品名品名称商品商品名称商品名称商品名称商品名称名称商品名称称商品名称商品名称商品名称名称商品名称
                      商品名称</p>
                    <p>颜色: <span>白色</span></p>
                  </div>
                </div>
                <div class="flex_1">x1</div>
                <div class="flex_1">￥412.00</div>
              </li>
            </ul>
          </div>
        </div>
        <div class="invoice">
          <span class="margin-r-15">发票信息</span>
          <div class="invoice_prompt color_333">开增值税专票需提供一般纳税人证明，以免影响报销</div>
          <div class="invoice_bounced" style="display: none">
            <div class="border-200 noinvoece">
              <span>不开发票</span>
              <Radio v-model="noInvoice"></Radio>
            </div>
          </div>
        </div>
        <div class="invoiceInfo">
          <div class="display-felx-space width_298">
            <span class="margin-r-15 color_333">增值税发票</span>
            <span class="color_666">北京铟立方科技有限公司</span>
          </div>
          <div class="width_135 display-felx-space margin-l-77">
            <span>商品明细</span>
            <span class="span_hover">修改</span>
          </div>
          <div class="width_285 margin-l-254 padding-r-20 text-right">
            <span><i class="color_ed3a">3</i> 件商品,</span>
            <span>总商品金额:</span>
            <span>￥8876.00</span>
          </div>
        </div>
        <div class="confirmInfo">
          <div class="display-flex-end margin-5">
            <p class="font-14">应付总额：</p>
            <p class="font-18 color_ed3a">￥1876.00</p>
          </div>
          <div class="margin-5">
            <p class="font-14">寄送至：北京 朝阳区 酒仙桥4号751北京时尚设计广场B7栋 收货人：曹恒瑞 13768390888</p>
          </div>
        </div>
        <div id="submitOrder">
          <router-link :to="{name: 'PaymentMethod'}"><Button>提交订单</Button></router-link>
        </div>
      </div>
    </div>
</template>

<script>
  export default {
    name: 'orderSettiement',
    data () {
      return {
        noInvoice: true  // 不开发票
      }
    },
    methods: {},
    created () {

    },
    components: {}
  }
</script>

<style scoped>
  .settlement {
    padding: 30px 105px;
  }
  .settlement-title {
    margin-bottom: 30px;
  }

  .display-start-end {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-right: 20px;
  }
  .addressInfo {
    padding: 18px 20px 28px 20px;
    border-top: 1px solid rgba(240,240,240,1);
  }

  .addressInfo-ul li {
    min-height: 72px;
    display: flex;
    justify-content: space-between;
    padding-bottom: 20px;
  }

  .wid-200 {
    width: 200px;
    height: 40px;
  }

  .wid-125 {
    width: 125px;
    height: 40px;
  }
  .border-e {
    border: 2px solid #ED3A4A;
  }

  .flex-1 {
    flex: 1;
    max-width: 490px;
    padding-right: 100px;
  }

  .flex-1 p {
    font-size: 14px;
    color: #666666;
  }

  .address_operation {
    transition: all .5s ease;
    opacity: 0;
  }

  /*结算页地址*/
  .address_operation .ivu-btn {
    width: 90px;
    height: 30px;
    background:rgba(153,153,153,1);
    border: 1px solid rgba(153,153,153,1);
    border-radius: 0;
    font-size: 12px;
    line-height: 1;
  }

  .text-right {
    text-align: right;
  }

  .display-space-b {
    display: flex;
    justify-content: space-between;
    padding-right: 20px;
  }
  .display-space-b p {
    font-size: 12px;
    cursor: pointer;
  }

  .addressInfo-ul li:hover .address_operation {
    opacity: 1;
  }

  .wid_80 {
    width: 80px;
  }

  .display-f {
    display: flex;
    cursor: pointer;
  }

  .border-200 {
    border: 1px solid rgba(200,200,200,1);
  }
  .padding-l-r {
    padding: 0 20px;
  }
  .border-t-b {
    padding: 30px 0 28px 0;
    border-top: 1px solid rgba(240,240,240,1);
    border-bottom: 1px solid rgba(240,240,240,1);
  }
  .orderLit {

  }

  .order-ul li {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
  }

  .order-ul li:last-child {
    margin-bottom: 0;
  }

  .wid_400 {
    width: 400px;
  }

  .flex_1 {
    flex: 1;
    text-align: right;
  }

  .display-felx-c {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .invoice {
    display: flex;
    align-items: center;
    padding-top: 30px;
    position: relative;
  }

  .invoiceInfo {
    margin-top: 38px;
    display: flex;
    margin-bottom: 18px;
  }

  .invoiceInfo span {
    font-size: 14px;
  }

  .width_298 {
    width: 298px;
  }

  .width_135 {
    width: 135px;
  }

  .width_285 {
    width: 285px;
  }

  .margin-l-77 {
    margin-left: 77px;
  }

  .margin-l-254 {
    margin-left: 254px;
  }

  .padding-r-20 {
    padding-right: 20px;
  }
  .display-felx-space {
    display: flex;
    justify-content: space-between;
  }

  .confirmInfo {
    height: 76px;
    background:rgba(240,240,240,1);
    padding-right: 20px;
    text-align: right;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .display-flex-end {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    line-height: 1;
  }
  .margin-5 {
    margin: 5px 0 5px 5px;
  }

  #submitOrder {
    margin: 30px 0;
    text-align: right;
  }
  #submitOrder .ivu-btn {
    width: 150px;
    height: 40px;
    font-size: 18px;
    line-height: 1;
    color:rgba(240,240,240,1);
    font-weight:bold;
    border-radius: 0;
  }

  .invoice_prompt {
    width: 80%;
    height: 32px;
    background: url('../../../../assets/images/icon/icon100.png') no-repeat;
    background-size: contain;
    line-height: 32px;
    padding-left: 50px;
  }

  .span_hover {
    transition: all .5s ease;
  }

  .span_hover:hover {
    color: #ED3A4A;
  }

  .invoice_bounced {
    width: 524px;
    height: 293px;
    background:rgba(255,255,255,1);
    padding: 35px 30px 25px 30px ;
    position: absolute;
    margin-left: 50%;
    transform: translate(-50%);
    bottom: 0;
    border: 4px solid rgba(240,240,240,1);
  }

  .noinvoece {
    height: 36px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 18px;
    color: #666666;
  }

  .wid_110 {
    width: 110px;
    height: 110px;
    position: relative;
  }
  .wid_110 img {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    margin: auto;
  }
</style>
