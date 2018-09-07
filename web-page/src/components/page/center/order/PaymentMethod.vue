<template>
    <div class="container min-height350">
      <div class="payment_method">
        <p class="font-20 color_999 margin-b-15">收银台</p>
        <div class="payment_order display-flex-center">
          <div class="display-f">
            <p class="font-18 ">支付金额：</p>
            <p class="font-24 margin-l-40">￥78119.00元</p>
            <p class="font-18 margin-l-30">订单号：</p>
            <p class="font-18">1983618361392</p>
          </div>
          <div class="margin-t-15">
            <p class="font-14">订单提交成功，请尽快付款！请您在<i class="color_ed3a">24小时</i>内完成支付，否则订单会被自动取消。</p>
          </div>
        </div>
        <div class="display-flex-ju-center margin-b-40">
         <div class="wid-100">
           <p class="font-20 color_999">支付方式</p>
         </div>
          <div class="display-flex-ju-center flex_1">
            <div class="pay_methods">支付宝</div>
            <div class="pay_methods margin-l-85">公司转账</div>
          </div>
          <div class="wid-100">
            <p></p>
          </div>
        </div>
        <div class="submit border-200 text-center">
          <router-link :to="{name: 'SweepPay'}"><Button class="width-140">立即支付</Button></router-link>
        </div>
      </div>
    </div>
</template>

<script>
  export default {
    name: 'PaymentMethod',
    data () {
      return {}
    },
    methods: {},
    created () {

    },
    components: {}
  }
</script>

<style scoped>
  .payment_method {
    padding: 30px 50px;
  }

  .payment_order {
    padding: 40px 30px;
    height: 128px;
    background:rgba(240,240,240,1);
    margin-bottom: 75px;
  }

  .display-flex-center {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .display-f {
    display: flex;
    align-items: center;
  }

  .display-f p {
    color: #333333;
  }

  .pay_methods {
    width: 144px;
    height: 44px;
    border: 1px solid #ED3A4A;
    line-height: 44px;
    text-align: center;
    font-size: 16px;
    color: #333333;
    box-sizing: content-box;
  }

  .margin-l-85 {
    margin-left: 85px;
  }

  .wid-100 {
    width: 100px;
  }

  .flex_1 {
    flex: 1;
  }

  .submit {
    padding: 48px 0 30px 0;
  }
  .border-200 {
    border-top: 1px solid rgba(240,240,240,1);
  }

  .width-140 {
    width: 140px;
    height: 40px;
    line-height: 1;
    border-radius: 0;
  }
</style>
