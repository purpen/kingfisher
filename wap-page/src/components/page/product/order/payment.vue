<template>
  <div class="payment fullscreen">
    <h2>{{title}}</h2>
    <div class="paylist">
      <RadioGroup v-model="pay" class="pay">
        <Radio class="pay-method wepay" label="微信支付"></Radio>
        <Radio class="pay-method alipay" label="支付宝支付"></Radio>
        <Radio class="pay-method upcash" label="银联支付"></Radio>
      </RadioGroup>
    </div>
    <button class="defrayal" @click="submitPay">{{pay}}￥{{total}}</button>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: 'payment',
    data () {
      return {
        title: '',
        pay: '微信支付',
        total: 0,
        orderid: 0,
        payment: '',
        pay_type: 1
      }
    },
    created () {
      this.title = this.$route.meta.title
      console.log(this.$route.params)
      console.log(this.isLogin)
      this.total = this.$route.params.total
      this.orderid = this.$route.params.orderid
    },
    watch: {
      pay () {
        if (this.pay === '微信支付') {
          this.payment = api.demandWxPay
          this.pay_type = 1
        }
      }
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    },
    methods: {
      submitPay () {
        let that = this
        that.$http.get(that.payment, {params: {order_id: that.orderid, pay_type: that.pay_type, token: this.isLogin}})
          .then((res) => {
            console.log(res)
            if (res.status === 404) {
              that.$Message.error(res.message)
            } else {
              that.$Message.success('success')
//              if (res.data.meta.status_code === 200) {
//                that.$Message.success(res.data.meta.message)
//              } else {
//                that.$Message.error(res.data.meta.message)
//              }
            }
          })
          .catch((err) => {
            console.log(err)
          })
      }
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
