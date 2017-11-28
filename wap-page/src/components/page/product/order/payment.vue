<template>
  <div class="payment">
    <h2>{{title}}</h2>
    <div class="paylist">
      <RadioGroup v-model="pay" class="pay">
        <Radio class="pay-method upcash" label="银联支付"></Radio>
        <Radio class="pay-method alipay" label="微信支付"></Radio>
        <Radio class="pay-method wepay" label="支付宝支付"></Radio>
      </RadioGroup>
    </div>
    <button class="defrayal">{{pay}}{{99}}</button>
  </div>
</template>
<script>
  export default {
    name: 'payment',
    data () {
      return {
        title: '',
        pay: '银联支付'
      }
    },
    created () {
      this.title = this.$route.meta.title
    }
  }
</script>
<style scoped>
  .payment {
    min-height: calc(100vh - 44px);
    background: #fafafa;
  }

  h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
  }

  .pay {
    width: 100%;
    border-top: 0.5px solid #ccc;
    background: #ffffff;
  }

  .pay-method {
    display: flex;
    align-items: center;
    width: 100%;
    line-height: 50px;
    border-bottom: 0.5px solid #ccc;
    padding: 0 15px 0 60px;
    font-size: 14px;
  }

  .upcash {
    background: url("../../../../assets/images/icon/UPcash.png") no-repeat 15px;
    -webkit-background-size: 40px;
    background-size: 40px;
  }

  .alipay {
    background: url("../../../../assets/images/icon/Alipay.png") no-repeat 15px;
    -webkit-background-size: 30px;
    background-size: 30px;
  }

  .wepay {
    background: url("../../../../assets/images/icon/WeChat@2x.png") no-repeat 15px;
    -webkit-background-size: 30px;
    background-size: 30px;
  }

  .defrayal {
    position: fixed;
    bottom: 0;
    left: 0;
    color: #fff;
    width: 100%;
    height: 44px;
    line-height: 44px;
  }
</style>
